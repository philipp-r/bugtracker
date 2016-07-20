<?php
//var_dump($config); exit;

/*
 Function to terminate script
*/
function endApi( $returnValues, $httpStatus ){
	// The HTTP status is currently not implemented.
	// API returns always 200
	/*
	if( $httpStatus == 200 ){
		header($_SERVER["SERVER_PROTOCOL"].' 200 OK');
		// Why we use $_SERVER["SERVER_PROTOCOL"]?
		// See: http://php.net/manual/de/function.header.php#92305
	} 
	elseif( $httpStatus == 403 ){
		header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden');
	} 
	elseif( $httpStatus == 410 ){
		header($_SERVER["SERVER_PROTOCOL"].' 410 Gone');
	} 
	elseif( $httpStatus == 500 ){
		header($_SERVER["SERVER_PROTOCOL"].' 500 Internal Server Error');
	} 
	elseif( $httpStatus == 501 ){
		header($_SERVER["SERVER_PROTOCOL"].' 501 Not Implemented');
	} 
	else{
		// catch-all with 400
		header($_SERVER["SERVER_PROTOCOL"].' 400 Bad Request');
	} 
	*/

	// output as JSON
	header('Content-type: application/json');
	// exit with the $return values
	exit( json_encode($returnValues) );

}


// check if configuration file exists
if(!file_exists("database/config_api.php")){
	$returns['status'] = 0;
	$returns['statusDetails'] = "Configuration file is missing. Check out the documentation https://github.com/Spamty/Bumpy-Booby/blob/master/API.md and example configuration https://github.com/Spamty/Bumpy-Booby/blob/master/sample_config/config_api.php for the API.";
	endApi( $returns, 500 );
}

// include API configuration
require("database/config_api.php");


// check if API enabled
if( !$config["api_enabled"] ){
	$returns['status'] = 0;
	$returns['statusDetails'] = "The API is disabled.";
	endApi( $returns, 501 );
}



/*
 Travis CI API
*/
if( $_GET['XMODE'] == "travisci" ){
	
	// We get JSON in $_POST['payload'] which is decoded in array
	// see https://docs.travis-ci.com/user/notifications/#Webhooks-Delivery-Format
	// and https://gist.github.com/svenfuchs/1225015#gistcomment-891767
	$travisJson = $_POST['payload'];
	$travis = json_decode($travisJson, true);
	//var_dump($travis);exit;
	
	
	// read headers, so we get $headers["Authorization"]
	$headers = apache_request_headers(); // see http://stackoverflow.com/a/2902713

	// the username is $username 
	$username = "travis-".$travis['repository']['name'];

	// check if this is a Travis CI user
	if( $API_ACCESS[$username]['mode'] != "travisci" ||
	// check api key
	$API_ACCESS[$username]['key'] != $headers["Authorization"] ){
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid username or password.";
		endApi( $returns, 403 );
	}


	$validProject = false;
	// check if project exists
	if( isset($config["projects"][$_GET['project']]) ){
		// check project permissions
		$projects = $API_ACCESS[$username]['projects'];
		// if has permission for all projects
		if( $projects == "ALL_PROJECTS" ){
			$validProject = true;
		}
		else{
			// check every project that is set in config
			$projectsArray = explode(",", $projects);
			foreach($projectsArray as $project){
				if($project == $_GET['project']){
					$validProject = true;
				}
			}
		}
	}
	if( !$validProject ){
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid project.";
		endApi( $returns, 400 );
	}


	// check permissions for "new_issue"
	if($API_ACCESS[$username]['permissions'] != "new_issue" &&
	$API_ACCESS[$username]['permissions'] != "ALL_PERMISSIONS" ) {
		$returns['status'] = 0;
		$returns['statusDetails'] = "No permission for new_issue.";
		endApi( $returns, 403 );
	}


	// travis CI status description
	switch ($travis['status_message']) {
	    case "Pending":
	        $travis['status_message_details'] = "A build has been requested";
	        break;
	    case "Passed":
	        $travis['status_message_details'] = "The build completed successfully";
	        break;
	    case "Fixed":
	        $travis['status_message_details'] = "The build completed successfully after a previously failed build";
	        break;
	    case "Broken":
	        $travis['status_message_details'] = "The build completed in failure after a previously successful build";
	        break;
	    case "Failed":
	        $travis['status_message_details'] = "The build is the first build for a new branch and has failed";
	        break;
	    case "Still Failing":
	        $travis['status_message_details'] = "The build completed in failure after a previously failed build";
	        break;
	}
	
	// build POST parameters
	$travisPost = array(
		'issue_summary' => "Building repository ".$travis['repository']['name']." branch ".$travis['branch']." ".$travis['status_message'],
		'issue_text' => "Build [".$travis['number']."](".$travis['build_url'].") of repository [".$travis['repository']['name']."](".$travis['repository']['url'].") branch ".$travis['branch']." **".$travis['status_message']."** 
\n \n Status *".$travis['status_message']."*: ".$travis['status_message_details']."
\n \n Commit ".$travis['commit']." by ".$travis['committer_name']." at ".$travis['committed_at'].": *".$travis['message']."* ",
	);
	// create issue
	$issues = Issues::getInstance($_GET['project']);
	$ans = $issues->new_issue($travisPost, true);
	// return success
	$returns['status'] = 1;
	$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
	$returns['ID'] = $issues->lastissue;
	endApi( $returns, 200 );

}







/*
  Import RSS
*/
elseif($_GET['XMODE'] == 'rss'){

	function createRssIssue($issueData_id, $issueData_summary, $issueData_text, $issueData_link){
			global $rssfeed, $imported;
			// check if this id was already imported
			if($imported[$rssfeed['name']][$issueData_id] == 1){
				print_r( $issueData_id." already imported" );
			}else{
				print_r("importing ".$issueData_id);
				// mark as imported in JSON list
				$imported[$rssfeed['name']][$issueData_id] = 1;
				// create issue
				$issues = Issues::getInstance($rssfeed['project']);
				$ans = $issues->new_issue(
					array(
						'issue_summary'=>$issueData_summary,
						'issue_text'=>$issueData_text." LINK: <".$issueData_link.">",
						'issue_date'=>$issueData_date,
					),
				true);
			}
	}
	
	// get list with imported ids
	$imported_json = file_get_contents("database/rss_imported.json");
	// decode
	$imported = json_decode($imported_json, true);

	
	foreach( $RSS as $rssfeed ){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $rssfeed['url']);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml_source = curl_exec($ch);
		curl_close($ch);
	
		$xml = simplexml_load_string($xml_source);
		
		// filter GitHub RSS
		if( strpos($rssfeed['name'], 'github-') !== false){
			foreach( $xml->entry as $feed_item ){
					// prepare data
					$issueData_summary = $rssfeed['title_prefix']." ";
					$issueData_summary .= (string)$feed_item->title;
					$issueData_id = (string)$feed_item->id;
					$issueData_text = (string)$feed_item->content;
					$issueData_text = strip_tags($issueData_text);
					$issueData_link = (string)$feed_item->link->attributes()->href;
					$issueData_date = (string)$feed_item->updated;
					$issueData_date = strtotime($issueData_date);
					
					createRssIssue($issueData_id, $issueData_summary, $issueData_text, $issueData_link);
			}
		} 
		// filter Sourceforge RSS
		elseif( strpos($rssfeed['name'], 'sourceforge-') !== false){
			foreach( $xml->channel->item as $feed_item ){
					// prepare data
					$issueData_summary = $rssfeed['title_prefix']." ";
					$issueData_summary .= (string)$feed_item->title;
					$issueData_id = (string)$feed_item->guid;
					$issueData_text = (string)$feed_item->description;
					$issueData_text = strip_tags($issueData_text);
					$issueData_link = (string)$feed_item->link;
					$issueData_date = (string)$feed_item->pubDate;
					$issueData_date = strtotime($issueData_date);
					
					createRssIssue($issueData_id, $issueData_summary, $issueData_text, $issueData_link);
			}
		} 
		// filter Bumpy-Booby RSS
		elseif( strpos($rssfeed['name'], 'bumpybooby-') !== false){
			foreach( $xml->channel->item as $feed_item ){
				// filter for # so we only get new issues and no comments
				if( strpos($feed_item->link, "#") == false ){
					// prepare data
					$issueData_summary = (string)$feed_item->title;
					$issueData_id = (string)$feed_item->link;
					$issueData_text = (string)$feed_item->description;
					$issueData_link = (string)$feed_item->link;
					$issueData_date = (string)$feed_item->pubDate;
					$issueData_date = strtotime($issueData_date);

					createRssIssue($issueData_id, $issueData_summary, $issueData_text, $issueData_link);
				}
			}
		}
		// default 
		else{
		
		}
		
	}

	// encode
	$imported_json = json_encode($imported);
	// get list with imported ids
	file_put_contents("database/rss_imported.json", $imported_json);

}







/*
 Default API
*/
else{

	
	// check if this is a default user
	if( $API_ACCESS[$_POST['api_username']]['mode'] != "default" ||
	// check api key
	$API_ACCESS[$_POST['api_username']]['key'] != md5($_POST['api_password']) ){
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid username or password.";
		endApi( $returns, 403 );
	}
	
	// validate the project
	$validProject = false;
	// check if project exists
	if( isset($config["projects"][$_GET['project']]) ){
		// check project permissions
		$projects = $API_ACCESS[$_POST['api_username']]['projects'];
		// if has permission for all projects
		if( $projects == "ALL_PROJECTS" ){
			$validProject = true;
		}
		else{
			// check every project that is set in config
			$projectsArray = explode(",", $projects);
			foreach($projectsArray as $project){
				if($project == $_GET['project']){
					$validProject = true;
				}
			}
		}
	}
	if( !$validProject ){
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid project.";
		endApi( $returns, 400 );
	}

	
	// NEW_ISSUE
	if($_POST['action'] == "new_issue" && 
	// check permissions for "new_issue"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "new_issue" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {
		// validate POST
		if( empty($_POST['issue_summary']) || empty($_POST['issue_text']) ){
			$returns['status'] = 0;
			$returns['statusDetails'] = "issue_summary and issue_text are required.";
			endApi( $returns, 400 );
		}
		// change summary
		$_POST['issue_text'] = $_POST['issue_text']."   - `Issue created with API by ".$_POST['api_username']."`";
		// create issue
		$issues = Issues::getInstance($_GET['project']);
		$ans = $issues->new_issue($_POST, true);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
		$returns['ID'] = $issues->lastissue;
		endApi( $returns, 200 );
	
	}
	// DELETE_ISSUE
	elseif($_POST['action'] == "delete_issue" && 
	// check permissions for "delete_issue"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "delete_issue" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {
		// validate POST
		// we do not check if the issue with this id exists
		if( empty($_POST['issue_id']) ){
			$returns['status'] = 0;
			$returns['statusDetails'] = "issue_id is required.";
			endApi( $returns, 400 );
		}
		// create issue
		$issues = Issues::getInstance($_GET['project']);
		$ans = $issues->delete_issue($_POST['issue_id'], "", true);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
		$returns['ID'] = $_POST['issue_id'];
		endApi( $returns, 200 );
	
	}
	else{
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid value for action.";
		endApi( $returns, 403 );
	}

}





exit;
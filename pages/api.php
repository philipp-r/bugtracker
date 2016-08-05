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
if(!file_exists(DIR_DATABASE."config_api.php")){
	$returns['status'] = 0;
	$returns['statusDetails'] = "Configuration file is missing. Check out the documentation https://docs.bugtrackr.eu/api/ and example configuration https://github.com/bugtrackr/bumpy-booby/blob/master/sample_config/config_api.php for the API.";
	endApi( $returns, 500 );
}

// include API configuration
require(DIR_DATABASE."config_api.php");


// check if API enabled
if( !$config["api_enabled"] ){
	$returns['status'] = 0;
	$returns['statusDetails'] = "The API is disabled.";
	endApi( $returns, 501 );
}


// Function to count issues
function count_issues($fpost){
	global $config;
	// code copied from /pages/issues.php
	$issues = Issues::getInstance();
	$a = $issues->getAll();
	$url = new Url(getProject().'/issues');
	$label = NULL;
	if (isset($fpost['label'])) {
		if (isset($config['labels'][$fpost['label']])) {
			OrderFilter::$filter = array($fpost['label']);
			$a = array_filter($a, array('OrderFilter', 'filter_label'));
			$url = new Url(getProject().'/labels/'.$fpost['label']);
			$label = $config['labels'][$fpost['label']];
		}
		else {
			$returns['status'] = 0;
			$returns['statusDetails'] = "Invalid label.";
			endApi( $returns, 400 );
		}
	}
	$open = 'open';
	if (isset($fpost['open'])) {
		if ($fpost['open'] == 'closed') {
			OrderFilter::$filter = array(false);
			$a = array_filter($a, array('OrderFilter', 'filter_open'));
			$url->addParam('open', 'closed');
			$open = 'closed';
		}
		elseif ($fpost['open'] == 'open') {
			OrderFilter::$filter = array(true);
			$a = array_filter($a, array('OrderFilter', 'filter_open'));
			$url->addParam('open', 'open');
			$open = 'open';
		}
		else {
			$url->addParam('open', 'all');
			$open = 'all';
		}
	}
	else {
		OrderFilter::$filter = array(true);
		$a = array_filter($a, array('OrderFilter', 'filter_open'));
	}
	$nb = count($a);
	return $nb;

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
	// log
	logm("Travis CI API: created issue in ".$_GET['project'].", ID ".$issues->lastissue);
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
				// log
				logm("RSS feed: importing item with guid ".$issueData_id." in ".$rssfeed['project']);
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
	$imported_json = file_get_contents(DIR_DATABASE."rss_imported.json");
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
	file_put_contents(DIR_DATABASE."rss_imported.json", $imported_json);

}








/*
  Badge
*/
elseif($_GET['XMODE'] == 'badge'){

	// shields defaults
	if(empty($_GET['shields_color'])){ $_GET['shields_color']="red"; }
	if(empty($_GET['shields_format'])){ $_GET['shields_format']="png"; }
	if(empty($_GET['shields_label'])){ $_GET['shields_label']="issues"; }

	// the username is $username 
	$username = "badge-".$_GET['api_username'];
	// check if valid user
	if( $API_ACCESS[$username]['mode'] != "badge" ){
		// expecting an image so redirect
		$redirectUrl='https://img.shields.io/badge/INVALID-USERNAME-red.'.$_GET['shields_format'].'?style='.$_GET['shields_style'];
		//die($redirectUrl);
		header('Location: '.$redirectUrl);
		header($_SERVER["SERVER_PROTOCOL"]." 302 Found"); 
		exit;
	}
	// check project access
	$validProject = false;
	// check if project exists
	$projects = $API_ACCESS[$username]['projects'];
	// if has permission for all projects
	if( $projects == "ALL_PROJECTS" ){ $validProject = true; }
	else{
		// check every project that is set in config
		$projectsArray = explode(",", $projects);
		foreach($projectsArray as $project){
			if($project == $_GET['project']){
				$validProject = true;
			}
		}
	}
	if( !$validProject ){
		// expecting an image so redirect
		$redirectUrl='https://img.shields.io/badge/INVALID-PROJECT-red.'.$_GET['shields_format'].'?style='.$_GET['shields_style'];
		//die($redirectUrl);
		header('Location: '.$redirectUrl);
		header($_SERVER["SERVER_PROTOCOL"]." 302 Found"); 
		exit;
	}

	// get number of issues
	$nb = count_issues($_GET);
	// redirect
	$redirectUrl='https://img.shields.io/badge/'.$_GET['shields_label'].'-'.$nb.'-'.$_GET['shields_color'].'.'.$_GET['shields_format'].'?style='.$_GET['shields_style'];
	//die($redirectUrl);
	header('Location: '.$redirectUrl);
	header($_SERVER["SERVER_PROTOCOL"]." 302 Found"); 
	exit;

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
		// log
		logm("API: new_issue: project ".$_GET['project']." ID ".$issues->lastissue);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
		$returns['ID'] = $issues->lastissue;
		endApi( $returns, 200 );
	
	}
	// EDIT_ISSUE
	elseif($_POST['action'] == "edit_issue" && 
	// check permissions for "edit_issue"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "edit_issue" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {
		// validate POST
		if( empty($_POST['issue_summary']) || empty($_POST['issue_text']) || !is_numeric($_POST['issue_id']) ){
			$returns['status'] = 0;
			$returns['statusDetails'] = "issue_id, issue_summary and issue_text are required.";
			endApi( $returns, 400 );
		}
		// change prepare edit variables
		$edits['summary'] = $_POST['issue_summary'];
		$edits['text'] = $_POST['issue_text']."   - `Issue edited with API by ".$_POST['api_username']."`";
		// create issue
		$issues = Issues::getInstance($_GET['project']);
		$ans = $issues->edit_issue($_POST['issue_id'], $edits, true);
		// log
		logm("API: edit_issue: project ".$_GET['project']." ID ".$_POST['issue_id']);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
		$returns['ID'] = $_POST['issue_id'];
		endApi( $returns, 200 );
	
	}
	// DELETE_ISSUE
	elseif($_POST['action'] == "delete_issue" && 
	// check permissions for "delete_issue"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "delete_issue" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {
		// validate POST
		// we do not check if the issue with this id exists
		if( !is_numeric($_POST['issue_id']) ){
			$returns['status'] = 0;
			$returns['statusDetails'] = "issue_id is required.";
			endApi( $returns, 400 );
		}
		// create issue
		$issues = Issues::getInstance($_GET['project']);
		$ans = $issues->delete_issue($_POST['issue_id'], "", true);
		// log
		logm("API: delete_issue: project ".$_GET['project']." ID ".$_POST['issue_id']);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
		$returns['ID'] = $_POST['issue_id'];
		endApi( $returns, 200 );
	
	}
	// EXISTS
	elseif($_POST['action'] == "exists" && 
	// check permissions for "exists"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "exists" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {
		// validate POST
		if( !is_numeric($_POST['issue_id']) ){
			$returns['status'] = 0;
			$returns['statusDetails'] = "issue_id is required.";
			endApi( $returns, 400 );
		}
		// create issue
		$issues = Issues::getInstance($_GET['project']);
		$ans = $issues->exists($_POST['issue_id'], true);
		if($ans){
			// return success
			$returns['status'] = 1;
			$returns['statusDetails'] = "Issue exists.";
		}else{
			// return issue does not exist
			$returns['status'] = 0;
			$returns['statusDetails'] = "Issue does not exist.";
		}
		// log
		logm("API: exists: project ".$_GET['project']." ID ".$_POST['issue_id']);
		$returns['ID'] = $_POST['issue_id'];
		endApi( $returns, 200 );
	
	}
	// UPDATE_ISSUE
	elseif($_POST['action'] == "update_issue" && 
	// check permissions for "update_issue"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "update_issue" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {
		// validate POST
		// we do not check if the issue with this id exists
		if( empty($_POST['issue_status']) || !is_numeric($_POST['issue_id']) ){
			$returns['status'] = 0;
			$returns['statusDetails'] = "issue_id and issue_status are required.";
			endApi( $returns, 400 );
		}
		// update issue
		$issues = Issues::getInstance($_GET['project']);
		$ans = $issues->update_issue($_POST['issue_id'], $_POST, true);
		// log
		logm("API: update_issue: project ".$_GET['project']." ID ".$_POST['issue_id']);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
		$returns['ID'] = $_POST['issue_id'];
		endApi( $returns, 200 );
	
	}
	// COUNT_ISSUES
	elseif($_POST['action'] == "count_issues" && 
	// check permissions for "count_issues"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "count_issues" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {

		$nb = count_issues($_POST);
		// log
		logm("API: count_issues: project ".$_GET['project']);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = $nb." issues found.";
		$returns['issues'] = $nb;
		endApi( $returns, 200 );
	
	}
	// COMMENT
	// EDIT_COMMENT
	// DELETE_COMMENT
	else{
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid value for action.";
		endApi( $returns, 403 );
	}

}




exit;
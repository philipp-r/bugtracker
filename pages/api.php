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
if(!file_exists("database/api_config.php")){
	$returns['status'] = 0;
	$returns['statusDetails'] = "Configuration file is missing. Check out the documentation https://github.com/Spamty/Bumpy-Booby/blob/master/API.md and example configuration https://github.com/Spamty/Bumpy-Booby/blob/master/api_config.example.php for the API.";
	endApi( $returns, 500 );
}

// include API configuration
require("database/api_config.php");


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
	
	
	// validate POST
	if( empty($_POST['issue_summary']) || empty($_POST['issue_text']) ){
		$returns['status'] = 0;
		$returns['statusDetails'] = "issue_summary and issue_text are required.";
		endApi( $returns, 403 );
	}


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
	
	
	if($_POST['action'] == "new_issue" && 
	// check permissions for "new_issue"
	($API_ACCESS[$_POST['api_username']]['permissions'] == "new_issue" || $API_ACCESS[$_POST['api_username']]['permissions'] == "ALL_PERMISSIONS") ) {
		// create issue
		$issues = Issues::getInstance($_GET['project']);
		$ans = $issues->new_issue($_POST, true);
		// return success
		$returns['status'] = 1;
		$returns['statusDetails'] = "Bumpy Booby returned: ".$ans;
		$returns['ID'] = $issues->lastissue;
		endApi( $returns, 200 );
	
	}
	else{
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid value for action.";
		endApi( $returns, 403 );
	}

}





exit;
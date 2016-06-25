<?php

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


// check if API enabled
if( !$config["api_enabled"] ){
	$returns['status'] = 0;
	$returns['statusDetails'] = "The API is disabled.";
	endApi( $returns, 501 );
}


// check if "bbapi" group has access to project
if( !in_array( "bbapi", $config['projects'][$_GET['project']]['can_access'] ) ){
	$returns['status'] = 0;
	$returns['statusDetails'] = "Invalid project.";
	endApi( $returns, 403 );
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
	
	
	// authentication
	// read headers, so we get $headers["Authorization"]
	$headers = apache_request_headers(); // see http://stackoverflow.com/a/2902713

	// check all users
	$validUser = false;
	foreach ($config['users'] as $u) {
		// check where username matches travis-REPOSITORY
		if ($u['username'] == "travis-".$travis['repository']['name']) {
			if(
				// Only users of API group can login
				$u['group'] == "bbapi" || 
				// check if password is correct
				$u['hash'] == Text::getHash($headers["Authorization"], "travis-".$travis['repository']['name'])
			){
				$validUser = true;
				$_POST['api_userid'] = $u['id'];
			}
		}
	}
	if(!$validUser){
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid username or password.";
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
		'api_userid' => $_POST['api_userid'],
		'issue_summary' => "Building repository ".$travis['repository']['name']." branch ".$travis['branch']." ".$travis['status_message'],
		'issue_text' => "Build [".$travis['number']."](".$travis['build_url'].") of repository [".$travis['repository']['name']."](".$travis['repository']['url'].") branch ".$travis['branch']." **".$travis['status_message']."** 
\n \n Status *".$travis['status_message']."*: ".$travis['status_message_details']."
\n \n Commit ".$travis['commit']." by ".$travis['committer_name']." at ".$travis['committed_at'].": *".$travis['message']."* "
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

	
	// check authentication
	$validUser = false;
	foreach ($config['users'] as $u) {
		if ($u['username'] == $_POST['api_username']) {
			if(
				// Only users of API group can login
				$u['group'] == "bbapi" &&
				// check if password is correct
				$u['hash'] == Text::getHash($_POST['api_password'], $_POST['api_username'])
			){
				$validUser = true;
				$_POST['api_userid'] = $u['id'];
			}
		}
	}
	if(!$validUser){
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
	
	
	if($_POST['action'] == "new_issue") {
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
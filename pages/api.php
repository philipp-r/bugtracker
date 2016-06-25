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

/*
 Default API
*/
if( $_GET['XMODE'] != "travisci" ){


	// check if API enabled or API key is not set
	if( !$config["api_enabled"] ){
		$returns['status'] = 0;
		$returns['statusDetails'] = "The API is disabled.";
		endApi( $returns, 501 );
	}
	
	
	// check authentication
	foreach ($config['users'] as $u) {
		if ($u['username'] == $_POST['api_username']) {
			if(
				// Only users of API group can login
				$u['group'] != "bbapi" || 
				// check if password is correct
				$u['hash'] != Text::getHash($_POST['api_password'], $_POST['api_username'])
			){
				$returns['status'] = 0;
				$returns['statusDetails'] = "Invalid username or password.";
				endApi( $returns, 403 );
			}
			$_POST['api_userid'] = $u['id'];
		}
	}
	
	
	// check if "bbapi" group has access to project
	if( !in_array( "bbapi", $config['projects'][$_GET['project']]['can_access'] ) ){
		$returns['status'] = 0;
		$returns['statusDetails'] = "Invalid project.";
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


/*
 Travis CI API
*/
else{


	var_dump($_GET);
	var_dump($_POST);
	var_dump($_SERVER);

}
exit;

<?php
// EVENT pull_request
// build POST parameters
$githubPost = array(
	'issue_summary' => "Pull request ".$post_data['action']." in GitHub repository: ".$post_data['repository']['name'],
	'issue_text' => "Pull request ".$post_data['action']." [number ".$post_data['number']."](".$post_data['pull_request']['html_url'].") in GitHub repository: [".$post_data['repository']['name']."](".$post_data['repository']['html_url'].")
\n \n ".$post_data['pull_request']['title'],
);
<?php
// EVENT push
// build POST parameters
$githubPost = array(
	'issue_summary' => "Push in GitHub repository: ".$post_data['repository']['name'],
	'issue_text' => "Push in GitHub repository: [".$post_data['repository']['name']."](".$post_data['repository']['html_url'].")
\n \n ".$post_data['head_commit']['message'],
);
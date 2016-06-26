<?php
/*
	Configuration of API users
	See *API.md* file for more information
*/
$API_ACCESS = array(


	"API_USERNAME_1" => array(
		"mode" => "default", // XMODE default
		"key" => "66f3c330818cdba8e1a9ec67ecaa2b93", // generate key with /classes/api/keygen.php
		"projects" => "ALL_PROJECTS", // comma seperated list of projects or "ALL_PROJECTS"
		"permissions" => "ALL_PERMISSIONS", // comma seperated list of permissions or "ALL_PERMISSIONS"
	),

	"travis-REPOSITORY" => array(
		"mode" => "travisci", // XMODE travisci
		"key" => "2ff384a686bdd4b54a567b2e0cb335d7336ee7bf5ea06a971fa6086d926862ca", // generate key with /classes/api/keygen-travisci.php
		"projects" => "ALL_PROJECTS", // comma seperated list of projects or "ALL_PROJECTS"
		"permissions" => "ALL_PERMISSIONS", // comma seperated list of permissions or "ALL_PERMISSIONS"
	),

	"github-REPOSITORY" => array(
		"mode" => "github", // XMODE github
    	"key" => "YOUR_GITHUB_SECRET", // GitHub secret
		"projects" => "ALL_PROJECTS", // comma seperated list of projects or "ALL_PROJECTS"
		"permissions" => "ALL_PERMISSIONS", // comma seperated list of permissions or "ALL_PERMISSIONS"
	),

); 
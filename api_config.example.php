<?php
/*
	Configuration of API users
	See *API.md* file for more information
*/
$API_ACCESS = array(


	"API_USERNAME_1" => array(
		"mode" => "default", // XMODE default
		"key" => "0cc175b9c0f1b6a831c399e269772661", // generate key with /classes/api/keygen.php
		"projects" => "ALL_PROJECTS", // comma seperated list of projects or "ALL_PROJECTS"
		"permissions" => "ALL_PERMISSIONS", // comma seperated list of permissions or "ALL_PERMISSIONS"
	),

	"travis-REPOSITORY" => array(
		"mode" => "travisci", // XMODE travisci
		"key" => "ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb", // generate key with /classes/api/keygen-travisci.php
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
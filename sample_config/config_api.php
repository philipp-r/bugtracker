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
		"permissions" => "ALL_PERMISSIONS", // single permission or "ALL_PERMISSIONS"
	),

	"travis-REPOSITORY" => array(
		"mode" => "travisci", // XMODE travisci
		"key" => "ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb", // generate key with /classes/api/keygen-travisci.php
		"projects" => "ALL_PROJECTS", // comma seperated list of projects or "ALL_PROJECTS"
	),

	"badge" => array(
		// list projects that have badges available
		"default" => true,
		"2nd-project" => true,
		// or use "ALL_PROJECTS"
		//"ALL_PROJECTS" => true,
	),


);

$RSS = array(

	array(
		"name" => "github-Bumpy-Booby",
		"title_prefix" => "New commit in Bumpy-Booby",
		"url" => "https://github.com/piero-la-lune/Bumpy-Booby/commits/master.atom",
		"project" => "default",
	),
	array(
		"name" => "bumpybooby-derivoile.fr",
		"title_prefix" => "",
		"url" => "http://bumpy-booby.derivoile.fr/default/rss",
		"project" => "default",
	),


);

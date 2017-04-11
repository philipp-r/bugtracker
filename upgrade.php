<?php

if (!isset($config)) {
	exit;
}

// check version
function strict_lower($a, $b) {
	$ea = explode('.', $a); // config version
	$eb = explode('.', $b); // new version
	for ($i=0; $i < count($ea); $i++) {
		if (!isset($eb[$i])) { $eb[$i] = 0; }
		$na = intval($ea[$i]);
		$nb = intval($eb[$i]);
		if ($na > $nb) { return false; }
		if ($na < $nb) { return true; } // true if new version higher than config version
	}
	return false;
}

// upgrade 0.3
if (strict_lower($config['version'], '0.3')) {
	$config['nb_last_activity_rss'] = 20;
}

// upgrade 1.0.4
if (strict_lower($config['version'], '1.0.4')) {
	if(!isset($config['captcha_new_issue'])){$config['captcha_new_issue'] = true;}
	if(!isset($config['captcha_post_comment'])){$config['captcha_post_comment'] = true;}
	if(!isset($config['captcha_signup'])){$config['captcha_signup'] = false;}
}
// upgrade 1.0
if (strict_lower($config['version'], '1.0')) {
	if(!isset($config['cdn_url'])){$config['cdn_url'] = "";}
	if(!isset($config['api_enabled'])){$config['api_enabled'] = false;}
	if(!isset($config['link_contact'])){$config['link_contact'] = "";}
	if(!isset($config['link_legalnotice'])){$config['link_legalnotice'] = "";}
	if(!isset($config['link_privacypolicy'])){$config['link_privacypolicy'] = "";}
}
// upgrade 1.1
if (strict_lower($config['version'], '1.1')) {
	if(!isset($config['theme'])){$config['theme'] = "app.css";}
}

$settings = new Settings();
if ($config['url_rewriting']) { $settings->url_rewriting(); }
$settings->save();

header('Content-Type: text/html; charset=utf-8');
die('Successfully upgraded! Refresh the page to access Nireus.');

?>

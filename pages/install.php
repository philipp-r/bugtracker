<?php

$title = Trad::T_INSTALLATION;

$languages = array();
$l = explode(',', LANGUAGES);
foreach ($l as $v) { $languages[$v] = $v; }

$content = '<h1>Auto '.Trad::T_INSTALLATION.'</h1>'
	.'<p>&nbsp;</p>';


if (is_file(DIR_DATABASE.FILE_CONFIG)) {
	$content = '
		<div class="alert alert-error">
			'.Trad::A_ERROR_INSTALL.'
		</div>
	';
}
else {
	$config = Settings::get_default_config(getenv('INSTALL_LANG'));
	$settings = new Settings();
	$post = $_POST;
	var_dump($post); die();
	$post['user_id'] = array('');
	$post['user_email'] = array('');
	$post['user_notifications'] = array('never');
	$post['user_group'] = array(DEFAULT_GROUP_SUPERUSER);
	$ans = $settings->changes($post);
	if (!empty($ans)) {
		foreach ($ans as $v) {
			$this->addAlert(Trad::settings($v));
		}
	}
	else {
		header('Location: '.Url::parse('home'));
		exit;
	}
}

?>
<?php

$form_s = (isset($_POST['issue_summary'])) ?
	htmlspecialchars($_POST['issue_summary']):
	'';
$form_t = (isset($_POST['issue_text'])) ?
	htmlspecialchars($_POST['issue_text']):
	'';
$form_st = (isset($_POST['issue_status'])) ?
	$_POST['issue_status']:
	DEFAULT_STATUS;
$form_u = (isset($_POST['issue_assignedto'])) ?
	$_POST['issue_assignedto']:
	DEFAULT_USER;
$form_d = (isset($_POST['issue_dependencies'])) ?
	htmlspecialchars($_POST['issue_dependencies']):
	'';
$form_l = (isset($_POST['issue_labels'])) ?
	explode(',', $_POST['issue_labels']):
	array();
$form_up = (isset($_POST['uploads'])) ?
	explode(',', $_POST['uploads']):
	array();
$token = getToken();

if( isset($_POST['new_issue']) ){
	$captcha_check_passed = false;
	// if user is not logged in, check Captcha
	if( !$config['loggedin'] ){
		session_start();
		require_once 'classes/securimage/securimage.php';
		$image = new Securimage();
		if ($image->check($_POST['captcha_code']) == true) {
			$captcha_check_passed = true;
		}
		else{
			$this->addAlert(Trad::F_INVALID_CAPTCHA);
		}

	}
	else{
		$captcha_check_passed = true;
	}

	if($captcha_check_passed){
		$issues = Issues::getInstance();
		$ans = $issues->new_issue($_POST, false);
		if ($ans === true) {
			header('Location: '.Url::parse(getProject().'/issues/'.$issues->lastissue));
			exit;
		}
		$this->addAlert($ans);
	}
}


$title = Trad::T_NEW_ISSUE;

$should_login = '';
if (!$config['loggedin']
	&& canAccess('signup')
	&& in_array(DEFAULT_GROUP, $config['permissions']['new_issue'])
) {
	$should_login = '<p class="help">'.Trad::A_SHOULD_LOGIN.'</p>';
}

$settings = '';
if (canAccess('update_issue')) {
	$statuses = array();
	foreach ($config['statuses'] as $k => $v) {
		$statuses[$k] = $v['name'];
	}
	$users = array(DEFAULT_USER => Trad::W_NOBODY);
	foreach ($config['users'] as $k => $u) {
		$users[$k] = htmlspecialchars($u['username']);
	}
	$labels = '';
	foreach ($config['labels'] as $k => $v) {
		if (canAccess('private_issues') || $k != PRIVATE_LABEL) {
			$selected = (in_array($k, $form_l)) ?
				'label selected':
				'label unselected';
			$labels .= '<a href="javascript:;" class="'.$selected.'" style="'
				.'background-color:'.$v['color'].'" data-id="'.$k.'">'
					.$v['name']
			.'</a>';
		}
	}
	$settings = '<div class="inner-form div-right">'
		.'<label for="issue_status">'.Trad::F_STATUS.'</label>'
		.'<select name="issue_status" class="select-status">'
			.Text::options($statuses, $form_st)
		.'</select>'
		.'<select name="issue_assignedto" class="select-users">'
			.Text::options($users, $form_u)
		.'</select>'
		.'<label for="issue_dependencies">'.Trad::F_RELATED.'</label>'
		.'<input type="text" name="issue_dependencies" value="'.$form_d.'" '
			.'placeholder="#1, #2, ..." />'
		.'<label>'.Trad::F_LABELS2.'</label>'
		.'<p class="p-edit-labels">'.$labels.'</p>'
		.'<input type="hidden" name="issue_labels" value="" />'
	.'</div>';
}


$content = '<h1>'.Trad::T_NEW_ISSUE.'</h1>'
.'<div class="box box-new-issue">'
	.'<div class="top">'
		.'<div class="manage">'
			.'<a href="javascript:;" class="a-help-markdown a-icon-hover">'
				.'<i class="icon-question-sign"></i>'
			.'</a>'
		.'</div>'
		.'<i class="icon-pencil"></i>'
		.Trad::F_WRITE
	.'</div>'
	.'<form action="'.Url::parse(getProject().'/issues/new').'" method="post" '
		.'class="div-table">'
		.'<div class="inner-form div-left">'
			.'<div class="div-help-markdown">'.Trad::HELP_MARKDOWN.'</div>'
			.'<input type="text" name="issue_summary" value="'.$form_s.'" '
				.'placeholder="'.Trad::F_SUMMARY.'" required />'
			.'<textarea name="issue_text" rows="12" '

if( !empty($form_t) ){
	$content .=	$form_t;
}
elseif( getProject()=="bumpy-booby" ){
$content .=	"[ Please describe your bug / feature request as detailed as possible. ]

## Expected Behavior
[ If you're describing a bug, tell us what should happen. 
If you're suggesting a change/improvement, tell us how it should work. ]

## Current Behavior
[ If describing a bug, tell us what happens instead of the expected behavior.
If suggesting a change/improvement, explain the difference from current behavior. ]

## Possible Solution
[ Not obligatory, but suggest a fix/reason for the bug, or ideas 
how to implement the addition or change. Code examples are welcome. ]

## Steps to Reproduce the bug
[ Provide a link to a live example, or an unambiguous set of steps to reproduce this bug. 
Include code to reproduce, if relevant. ]

## My Environment
 * Bumpy Booby version: [ version OR branch and commit ]
 * Browser: [ your web browser ]
 * Webserver: [ Apache / Lighttpd ]
 * [ add more info if possible ]";
}
elseif( getProject()=="docs" ){
$content .=	"[ Please describe the bug / enhancement as detailed as possible. ]";
}
elseif( getProject()=="support" ){
$content .=	"[ Please describe your problem / question as detailed as possible. ]


## Steps to Reproduce
[ You can provide a link to a live example (your Bumpy Booby) here. ]

## My Environment
 * Bumpy Booby version: [ version OR branch and commit ]
 * Browser: [ your web browser ]
 * Webserver: [ Apache / Lighttpd ]
 * [ add more info if possible ]";
}
$content .= '</textarea>'
			.'<div class="preview text-container" style="display:none"></div>'
			.$should_login;

// include securimage if user is not logged in
if( !$config['loggedin'] ){
	require_once 'classes/securimage/securimage.php';
	$content .=	Securimage::getCaptchaHtml();
}

$content .=	'<div class="form-actions">'
				.'<button type="button" class="btn btn-preview">'
					.Trad::V_PREVIEW
				.'</button>'
				.'<button type="submit" class="btn btn-primary">'
					.Trad::V_SUBMIT
				.'</button>'
			.'</div>'
			.'<input type="hidden" name="uploads" value="" />'
			.'<input type="hidden" name="token" value="'.$token.'" />'
			.'<input type="hidden" name="new_issue" value="1" />'
		.'</div>'
		.$settings
	.'</form>'
.'</div>';

if (canAccess('upload')) {
	$content .= Uploader::get_html('.box-new-issue form', $form_up);
}

?>
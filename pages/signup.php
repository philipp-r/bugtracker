<?php

$username = (isset($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
$email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';

if (isset($_POST['new_user'])) {
	$captcha_check_passed = false;
	// if user is not logged in, check Captcha
	if( !$config['loggedin'] && $config['captcha_signup'] ){
		require_once 'vendor/autoload.php';
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
		// create new user
		$settings = new Settings();
		$ans = $settings->new_user($_POST);
		if ($ans === true) {
			$_SESSION['alert'] = array('text' => Trad::A_SUCCESS_SIGNUP, 'type' => 'alert-success');
			header('Location: '.Url::parse('home'));
			exit;
		}
		else {
			$this->addAlert($ans);
		}
	}
}

$title = Trad::V_SIGNUP;



$content = '

<h1>'.Trad::V_SIGNUP.'</h1>

<form action="'.Url::parse('signup').'" method="post" class="form form-signup">
	<label for="username2">'.Trad::F_USERNAME.'</label>
	<input type="text" name="username" id="username2" class="input-normal" value="'.$username.'" required />
	<label for="password2">'.Trad::F_PASSWORD.'</label>
	<input type="password" name="password" id="password2" class="input-normal" required />
	<label for="email">'.Trad::F_EMAIL.'</label>
	<input type="email" name="email" id="email" class="input-large" value="'.$email.'" />
	<p class="help">'.Trad::F_TIP_USER_EMAIL.'</p>';
	
// include securimage if user is not logged in
if( !$config['loggedin'] && $config['captcha_signup'] ){
	// to include securimage
	require_once 'vendor/autoload.php';
	$content .= Securimage::getCaptchaHtml( array(
		'image_alt_text' => Trad::W_CAPTCHA_IMAGE,
		'refresh_alt_text' => Trad::W_CAPTCHA_REFRESH,
		'refresh_title_text' => Trad::W_CAPTCHA_REFRESH,
		'input_text' => Trad::W_CAPTCHA_INPUT,
	) );
}

$content .='<div class="form-actions">
		<input type="hidden" name="token" value="'.getToken().'" />
		<input type="hidden" name="new_user" value="1" />
		<button type="submit" class="btn btn-primary">'.Trad::V_SIGNUP.'</button>
	</div>
</form>
';

?>
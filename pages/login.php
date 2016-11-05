<?php

// if logged in redirect to homepage
if ($config['loggedin']) {
	header('Location: '.Url::parse('home'));
}

$title = Trad::V_LOGIN;

$content = '

<h1>'.Trad::V_LOGIN.'</h1>

<form action="" method="post" class="form form-signup">
	<label for="username">'.Trad::F_USERNAME.'</label>
	<input type="text" name="username" id="username" required />
	<label for="password">'.Trad::F_PASSWORD.'</label>
	<input type="password" name="password" id="password" required />
	<!-- <label for="stayloggedin"><input type="checkbox" name="stayloggedin" id="stayloggedin" value="yes" class="loggedin-checkbox"> '.Trad::S_STAY_LOGGEDIN.'</label> -->
	<div class="form-actions">
		<input type="hidden" name="token" value="'.getToken().'" />
		<input type="hidden" name="login" value="1" />
		<button type="submit" class="btn btn-primary">'.Trad::V_LOGIN.'</button>
	</div>
</form>


';

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>keygen-travisci.php</title>
	<meta name="robots" content="noindex,nofollow">
</head>
<body>
<h1>Travis CI API</h1>


<?php
if( !empty($_POST['submit']) ){

$api_key = hash("sha256", $_POST['github_user']."/".$_POST['github_repo'].$_POST['travis_token']);
?>
<p>The key is: <em><?php echo $api_key; ?></em><br>
Add this to the "api_config.php" file.</p>
<hr>
<?php
}
?>


<form action="keygen-travisci.php" method="POST">
	<p>GitHub username (repo owner): <input type="text" name="github_user" id="github_user"></p>
	<p>GitHub repository name: <input type="text" name="github_repo" id="github_repo"></p>
	<p>Travis Token: <input type="text" name="travis_token" id="travis_token"></p>
	<input type="submit" name="submit" id="submit" value="GENERATE">
</form>

</body>
</html>
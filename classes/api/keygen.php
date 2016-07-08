<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>keygen.php</title>
	<meta name="robots" content="noindex,nofollow">
</head>
<body>
<?php
// http://stackoverflow.com/a/4356295
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$api_key = generateRandomString(rand(18,28));
?>

<h1>Default API</h1>

<p>Your API key is: <em><?php echo $api_key; ?></em><br>
Use this as your "api_password" parameter.</p>

<p>The md5 hash is: <em><?php echo md5($api_key); ?></em><br>
Add this to the "config_api.php" file.</p>

</body>
</html>
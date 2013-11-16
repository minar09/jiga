<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ask In More Innovative Way</title>
<style type="text/css">
.container {
	height: 100%;
	
}
.middele {
	width: 320px;
	padding: 20px 0;
	margin-bottom: 0;
	margin-left: auto;
	margin-right: auto;
	margin-top: 150px;
}

a{
	color: #fff;
	text-decoration: none;
}

body {
	font-family: 'Oswald', Arial, sans-serif;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
}
.main_header {
	background-color: #000000;
	text-align: right;
	padding-top: 5px;
	padding-bottom: 5px;
}
.forHeaderwidth {
	margin-left: auto;
	margin-right: auto;
	color: #CCCCCC;
	font-family: Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 12px;
	width: 80%;
}
.forHeaderwidth:hover {
	color: #FFFFFF;
}
</style>
<link href="css/button.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
</head>

<body>
<div class="container">
    <div class="main_header">
        <div class="forHeaderwidth">
        its an Inferno production
        </div>
		
	</div>
    

<?php

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_PlusService.php';

// Set your cached access token. Remember to replace $_SESSION with a
// real database or memcached.
session_start();

$client = new Google_Client();
$client->setApplicationName('Google+ PHP Starter Application');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('41872116600.apps.googleusercontent.com');
$client->setClientSecret('ofFWv5GA26NZ1QCZlURu7vKk');
$client->setRedirectUri('http://gcdc2013-jiga.appspot.com/oauth2callback');
$client->setDeveloperKey('AIzaSyDPnCQZU1drw10R07ex_8NWea-wZFXjflo');
$plus = new Google_PlusService($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $activities = $plus->activities->listActivities('me', 'public');
  print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';

  // We're not done yet. Remember to update the cached access token.
  // Remember to replace $_SESSION with a real database or memcached.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  //print "<a href='$authUrl'>Connect Me!</a>";
}

?>

<div class="middele">
    	<a href='$authUrl' class="a-btn">Connect Me! > 
            <span class="a-btn-slide-text">Sign in with Google +</span>
            <span class="a-btn-icon-right"><span></span></span>
        </a>
	</div>


</div>

</body>
</html>
<!DOCTYPE html>
 <head>
  <title>Jiga - Ask Perfectly, Get Answer Perfectly</title>
  <link rel='stylesheet' href='style.css' />
  <link rel='script' href='script.js'>
 </head>
 <body>
<?php
    require_once 'google/appengine/api/users/UserService.php';
	//require_once 'google-api-php-client/src/apiClient.php';  
    //require_once 'google-api-php-client/src/contrib/apiPlusService.php'; 
	require_once 'google-api-php-client/src/Google_Client.php';
	require_once 'google-api-php-client/src/contrib/Google_PlusService.php';



    use google\appengine\api\users\User;
    use google\appengine\api\users\UserService;

    $user = UserService::getCurrentUser();

    if ($user) {
        echo 'Hello, ' . htmlspecialchars($user->getNickname());
    }
    else {
      header('Location: ' .
             UserService::createLoginURL($_SERVER['REQUEST_URI']));
    }
	
	//session_start();
    $id = $_POST['id'];
    $client = new Google_Client();
    $client->setApplicationName("jiga");
    // oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
    $client->setClientId('41872116600.apps.googleusercontent.com');
    $client->setClientSecret('ofFWv5GA26NZ1QCZlURu7vKk');
    $client->setRedirectUri('http://gcdc2013-jiga.appspot.com/oauth2callback');
    $client->setDeveloperKey('AIzaSyDPnCQZU1drw10R07ex_8NWea-wZFXjflo');
	
    $plus = new Google_PlusService($client);
	
  if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die("The session state did not match.");
  }
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $me = $plus->people->get('me');
  print "Your Profile: <pre>" . print_r($me, true) . "</pre>";

  $params = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public', $params);
  print "Your Activities: <pre>" . print_r($activities, true) . "</pre>";
  
  $params = array(
    'orderBy' => 'best',
    'maxResults' => '20',
  );
  $results = $plus->activities->search('Google+ API', $params);
  foreach($results['items'] as $result) {
    print "Search Result: <pre>{$result['object']['content']}</pre>\n";
  }

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
    ?>
    </div>

 </body>
</html>
	
	

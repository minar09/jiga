<?php
    require_once 'google/appengine/api/users/UserService.php';

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

	
	

<?php
	session_start();
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("119653069253-1bq8se82um36kp9jhofgslmq78s25nn1.apps.googleusercontent.com");
	$gClient->setClientSecret("td4hrUoZQpNMezG4ILIN2PSS");
	$gClient->setApplicationName("CPI Login Tutorial");
	$gClient->setRedirectUri("http://localhost/recfacial/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.me");
?>

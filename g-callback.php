<?php
	require_once "config.php";
	require_once "common/Conexion.php";
	if (isset($_SESSION['access_token']))
		$gClient->setAccessToken($_SESSION['access_token']);
	else if (isset($_GET['code'])) {
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token;
	} else {
		header('Location: login.php');
		exit();
	}

	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo_v2_me->get();

	$_SESSION['id'] = $userData['id'];
	$_SESSION['email'] = $userData['email'];
	$_SESSION['gender'] = $userData['gender'];
	$_SESSION['picture'] = $userData['picture'];
	$_SESSION['familyName'] = $userData['familyName'];
	$_SESSION['givenName'] = $userData['givenName'];

	$db_email = $userData['email'];
	$db_nombre = $userData['givenName'];
	$db_apellido = $userData['familyName'];
	
	$db = Conexion::getConexion();
	$query = $db->prepare("insert into adminlog (nombre, apellidos, email) values (?,?,?)");
	$query->execute([$db_nombre,$db_apellido,$db_email]);
	header('Location: listgroups.php');
		exit();
	
	

?>
<?php

include 'userDao.php';

$action = $_POST['action'];
switch ($action) {
	case 'createAccount':
		createAccount();
		break;
	case 'login':
		login();
		break;
	case 'searchId':
		searchId();
		break;
	default:
		break;
}



?>
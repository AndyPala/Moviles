<?php

$action = $_POST['action'];
switch ($action) {
	case 'createAccount':
		createAccount();
		break;
	case 'login':
		login();
		break;
	default:
		break;
}

function connect() {
	$databasehost = "localhost";
	$databasename = "psmbd";
	$databaseuser = "root";
	$databasepass = "root";

	$con = mysql_connect($databasehost, $databaseuser, $databasepass) or die(mysql_error());
	mysql_select_db($databasename) or die(mysql_error());
}

function disconnect() {
	mysql_close();
}

function login(){
	$userJson = $_POST['userJSON'];
	$user = json_decode($userJson, true);

	$username = $user['username'];
	$password = $user['password'];

	connect();

	if(strpos($username, '@')){
		$query = mysql_query("call sp_login_email('".$username."', '".$password."')");
	}
	else{
		$query = mysql_query("call sp_login_user('".$username."', '".$password."')");
	}

	if (mysql_errno()) {
		disconnect();
		echo mysql_error();
	}else {
		$rows = array();
		while ($r = mysql_fetch_assoc($query)) {
			$rows[] = $r;
		}
		disconnect();
		print json_encode($rows);
	}
}

?>
<?php
function login(){
	$extrasJSON = $_POST['extrasJSON'];
	$user = json_decode($extrasJSON, true);

	$username = $user['username'];
	$password = $user['password'];

	connect();

	if(strpos($username, '@') && strpos($username, '.') ){
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

function createAccount(){
	$extrasJSON = $_POST['extrasJSON'];
	$user = json_decode($extrasJSON, true);

	$username = $user['username'];
	$email = $user['email'];
	$password = $user['password'];

	connect();


	$query = mysql_query("call sp_insertar_usuario('".$username."', '".$email."', '".$password."')");

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

function searchUser_Id(){
	$extrasJSON = $_POST['extrasJSON'];
	$user = json_decode($extrasJSON, true);

	$idUser = $user['idUser'];

	connect();


	$query = mysql_query("call sp_buscar_usuario_id(".$idUser.")");

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

function searchUserReviews(){
	$extrasJSON = $_POST['extrasJSON'];
	$user = json_decode($extrasJSON, true);

	$idUser = $user['idUser'];

	connect();

	$query = mysql_query("call sp_buscar_resena_usuario(".$idUser.")");

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
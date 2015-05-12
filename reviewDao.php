<?php
function searchReview_UserPlace(){
	$extrasJSON = $_POST['extrasJSON'];
	$review = json_decode($extrasJSON, true);

	$idUser = $review['idUser'];
	$idPlace = $review['idPlace'];

	connect();

	$query = mysql_query("call sp_buscar_resena_usuarioLugar(".$idUser.", ".$idPlace.")");

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

function addReview(){
	$extrasJSON = $_POST['extrasJSON'];
	$review = json_decode($extrasJSON, true);

	$idUser = $review['idUser'];
	$idPlace = $review['idPlace'];
	$desc = $review['desc'];
	$star = $review['star'];

	connect();

	$query = mysql_query("call sp_insertar_resena(".$idUser.", ".$idPlace.", '".$desc."', ".$star.")");

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

function getReviewAverage(){
	$extrasJSON = $_POST['extrasJSON'];
	$review = json_decode($extrasJSON, true);

	$idPlace = $review['idPlace'];

	connect();

	$query = mysql_query("call sp_buscar_promedio_lugar(".$idPlace.")");

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
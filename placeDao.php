<?php
	function addPlace(){
		$extrasJSON = $_POST['extrasJSON'];
		$place = json_decode($extrasJSON, true);

		$idCategory = $place['idCategory'];
		$name = $place['placeName'];
		$latitude = $place['latitude'];
		$longitude = $place['longitude'];
		$treshold = $place['treshold'];

		connect();

		$query = mysql_query("call sp_insertar_lugar('".$idCategory."', '".$name."', '".$latitude."', '".$longitude."', '".$treshold."')");

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

	function searchPlaces(){
		$extrasJSON = $_POST['extrasJSON'];
		$place = json_decode($extrasJSON, true);

		$latitude = $place['latitude'];
		$longitude = $place['longitude'];
		$maxDst = $place['maxDst'];

		connect();

		$query = mysql_query("call sp_buscar_lugares('".$latitude."', '".$longitude."', '".$maxDst."')");

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

	function searchPlacesCategory(){
		$extrasJSON = $_POST['extrasJSON'];
		$place = json_decode($extrasJSON, true);

		$latitude = $place['latitude'];
		$longitude = $place['longitude'];
		$maxDst = $place['maxDst'];
		$idCategory = $place['idCategory'];

		connect();

		$query = mysql_query("call sp_buscar_lugares_categoria('".$latitude."', '".$longitude."', '".$maxDst."', '".$idCategory."')");

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

	function searchReviews_Place(){
		$extrasJSON = $_POST['extrasJSON'];
		$place = json_decode($extrasJSON, true);

		$idPlace = $place['idPlace'];

		connect();

		$query = mysql_query("call sp_buscar_resena_lugar(".$idPlace.")");

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
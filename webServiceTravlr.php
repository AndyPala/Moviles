<?php

include 'connection.php';
include 'userDao.php';
include 'placeDao.php';
include 'reviewDao.php';

$action = $_POST['action'];
switch ($action) {
	case 'createAccount':
		createAccount();
		break;
	case 'login':
		login();
		break;
	case 'searchUser_Id':
		searchUser_Id();
		break;
	case 'addPlace':
		addPlace();
		break;
	case 'searchPlaces':
		searchPlaces();
		break;
	case 'searchPlacesCat':
		searchPlacesCategory();
		break;
	case 'searchUserReviews':
		searchUserReviews();
		break;
	case 'searchReview_UserPlace':
		searchReview_UserPlace();
		break;
	case 'addReview':
		addReview();
		break;
	case 'searchReviews_Place':
		searchReviews_Place();
		break;
	default:
		break;
}



?>
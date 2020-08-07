<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/User.php");
$users = new User();
$error = false;
$error_message = "";
$error_type = "";
$error_icon = "exclamation-circle";

if(isset($_SESSION['user'])){
	$condition = "where username = '".$_SESSION['user']['username']."' and password = '".$_SESSION['user']['password']."'";
	$users = $users->select($condition);
	if(count($users) > 1){
		$error = true;
		$error_type = "danger";
		$error_message = "It seems there is a problem with your account, please contact your administrator!";
		unset($_SESSION['user']);
	}elseif($users[0]['role_id'] < 1){
		$error = true;
		$error_type = "danger";
		$error_message = "You don't have permission to access this panel!";
		unset($_SESSION['user']);
	}
}else{
	$error = true;
	$error_type = "warning";
	$error_message = "You need to login first!";
	unset($_SESSION['user']);
}

if($error){
	$notification = array(
		"message"=>$error_message,
		"type"=>$error_type,
		"icon"=>$error_icon
	);
	$_SESSION['notification'] = $notification;
	header('Location: /index');
	exit;
}

?>
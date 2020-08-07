<?php 
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/User.php");
	$users = new User();
	$error = false;
	$error_message = "";
	$error_type = "";
	$error_icon = "exclamation-circle";
	if(isset($_POST['submit_login'])){
		if(!empty($_POST['email'])){
			$get_email = mysqli_real_escape_string($users->conn, $_POST['email']);
			$get_password = mysqli_real_escape_string($users->conn, $_POST['password']);
			$condition = "where username = '$get_email' and password = '$get_password'";
			$users = $users->select($condition);
			if(count($users) > 1){
				$error = true;
				$error_type = "danger";
				$error_message = "It seems there is a problem with your account, please contact your administrator!";
			}elseif (count($users) == 0) {
				$error = true;
				$error_type = "danger";
				$error_message = "Your account isn't exist!";
			}else{
				$_SESSION['user'] = $users[0];
				header('Location: /dashboard/home');
				exit;
			}

		}else{
			$error = true;
			$error_type = "danger";
			$error_message = "Username or Password cannot be empty!";
		}
	}

	$notification = array(
		"message"=>$error_message,
		"type"=>$error_type,
		"icon"=>$error_icon
	);

	$error ? $_SESSION['notification'] = $notification : "";
	header('Location: /index');
	exit;
 ?>
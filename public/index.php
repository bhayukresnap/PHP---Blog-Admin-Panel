<?php 
	session_start();
	if(isset($_SESSION['user'])){
		header("Location: /dashboard/home");
		exit;
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php"); ?>
</head>
<body>
	<section class="material-half-bg">
		<div class="cover"></div>
	</section>
	<section class="login-content">
		<div class="logo">
			<h1>Vali - Dashboard</h1>
			<a href="#" id="memek">Test</a>
		</div>
		<div class="login-box">
			<form class="login-form" method="post" action="/dashboard/login">
				<h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
				<div class="form-group">
					<label class="control-label">USERNAME</label>
					<input class="form-control" type="text" placeholder="Email" autofocus autocomplete="off" name="email">
				</div>
				<div class="form-group">
					<label class="control-label">PASSWORD</label>
					<input class="form-control" type="password" placeholder="Password" autocomplete="off" name="password">
				</div>
				<div class="form-group btn-container">
					<button class="btn btn-primary btn-block" name="submit_login"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
				</div>
			</form>
		</div>
	</section>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/js.php"); ?>
	<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/notification.php"); ?>
</body>
</html>
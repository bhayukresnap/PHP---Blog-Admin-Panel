<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/User.php");
if(isset($_POST['submit_post'])){
	$data = array(
		$_POST['name'],
		$_POST['username'],
		$_POST['password'],
		"",
		"",
		"",
		DATE,
		DATE,
	);
	$post = new User();
	$post->insert($data);
}
header("Location: /dashboard/users");
exit;
?>
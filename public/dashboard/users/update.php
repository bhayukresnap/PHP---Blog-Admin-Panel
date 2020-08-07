<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/User.php");
if(isset($_POST['submit_post'])){
	$data = array(
		"photo"=>file_exists($_FILES['photo']['tmp_name']) ? $_FILES['photo'] : $_POST['photo_current'],
		"name"=>$_POST['name'],
		"job"=>$_POST['job'],
		"photo_current"=> $_POST['photo_current'],
		"updated_at" => DATE,
	);
	$post = new User();
	$post->update($data, $_SESSION['user']['id']);
}
header("Location: /dashboard/profile");
exit;
?>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/Post.php");
if(isset($_POST['submit_post'])){
	$data = array(
		"image"=>file_exists($_FILES['image']['tmp_name']) ? $_FILES['image'] : $_POST['image_current'],
		"image_current"=> $_POST['image_current'],
		"title"=>$_POST['title'],
		"body"=>$_POST['body'],
		"last_update_by"=>$_SESSION['user']['id'],
		"published_at"=> $_POST['published_at']." 00:00:00",
		"updated_at"=>DATE,
		"tags"=> isset($_POST['tags']) ? $_POST['tags'] : "",
	);
	$post = new Post();
	$post->update($data, $_POST['post_id']);
}
header("Location: $_SERVER[HTTP_REFERER]");
exit;
?>
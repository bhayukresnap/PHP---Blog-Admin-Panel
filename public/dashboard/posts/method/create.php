<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/Post.php");
if(isset($_POST['submit_post'])){
	$data = array(
		"image"=>$_FILES['image'],
		"title"=>$_POST['title'],
		"body"=>$_POST['body'],
		"last_update_by"=>$_SESSION['user']['id'],
		"published_at"=> $_POST['published_at']." 00:00:00",
		"created_at"=>DATE,
		"updated_at"=>DATE,
		"tags"=> isset($_POST['tags']) ? $_POST['tags'] : "",
	);
	$post = new Post();
	$post->insert($data);
}
header("Location: /dashboard/posts/create");
exit;
?>
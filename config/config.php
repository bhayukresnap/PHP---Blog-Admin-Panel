<?php 
	define("CONFIG", 
		array(
		"db"=>array(
			"server"=>"localhost",
			"user"=>"root",
			"password"=>"",
			"dbname"=>"vali_admin",
		)
	)
);
	date_default_timezone_set('Asia/Jakarta');
	define("DATE",date('Y-m-d h:i:s'));
	define("IMG_SIZE", 1048576);
	define("IMG_PATH_DIR", '/images/');
	define("PUBLIC_PATH", $_SERVER['DOCUMENT_ROOT']."/public/");
	define("LIMIT_PER_PAGE", 10);
 ?>
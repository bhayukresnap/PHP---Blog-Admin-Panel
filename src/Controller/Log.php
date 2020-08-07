<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/Database.php');
	class Log extends Database{

		public function __construct($table = 'logs'){
			parent::__construct($table);
		}
		
	}
 ?>
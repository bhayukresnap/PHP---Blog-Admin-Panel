<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/Database.php');
	class Tag extends Database{

		public function __construct($table = 'tags'){
			$columns = array(
				"tag_name",
			);
			parent::__construct($table, $columns);
		}

		public function insert($data){
			$insert = parent::insert($data);
			if($insert[0]){
				$last_id = parent::select("where id = $insert[1]");
	    		$this->show = true;
	    		$this->type = 1;
	    		$this->message = "Data has been added to database!";
	    		parent::set_log($last_id[0]['tag_name']." tag", 1);
	    	}else{
	    		$this->show = true;
	    		$this->message = "This data is already exist!";
	    	}
			Helper::notification($this->show, $this->message, $this->type);
		}

		public function delete($data){
			$deleteData = parent::delete($data);
			if($deleteData[0]){
				$this->show = true;
				$this->type = 1;
				$this->message = "Data has been removed from database!";
				parent::set_log($deleteData[1][0]['tag_name']." tag", 0);
			}else{
				// $this->show = true;
				// $this->message = "Something is wrong!";
			}
		    Helper::notification($this->show, $this->message, $this->type);
		}
		
	}
 ?>
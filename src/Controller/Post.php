<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/Database.php');
	class Post extends Database{

		public function __construct($table = 'posts'){
			$columns = array(
				"image",
				"title",
				"body",
				"last_update_by",
				"published_at",
				"created_at",
				"updated_at",
			);
			parent::__construct($table, $columns);
		}
		
		public function insert($data){
			$image_verif = Helper::ImageVerification($data['image']);
			if($image_verif[0] == 1){
				$data['image'] = $image_verif[1];
				$tags = $data['tags'];
				unset($data['tags']);
				$insert = parent::insert($data);				
				if($insert[0]){
					$last_id = parent::select("where id = $insert[1]");
					$sql = '';
					if(!empty($tags)){
						foreach($tags as $key => $value){
						$sql .= "INSERT INTO tags_posts (post_id, tag_id) VALUES ('$insert[1]', '$value');";
					}
					mysqli_multi_query($this->conn, $sql);
					}
		    		$this->show = true;
		    		$this->type = 1;
		    		$this->message = "Data has been added to database!";
		    		parent::set_log($last_id[0]['title']." post", 1);
		    	}else{
		    		$this->show = true;
		    		$this->message = "This data is already exist!";
		    		unlink(PUBLIC_PATH . $data['image']);
		    	}
		    	Helper::notification($this->show, $this->message, $this->type);
			}
			//return print_r($data);
		}
			
		public function update($data, $id){
			$image_verif = is_array($data['image']) ? Helper::ImageVerification($data['image']) : array(1);
			if(count($image_verif) > 1){
				$data['image'] = $image_verif[1];
				if(file_exists(PUBLIC_PATH . $data['image_current'])){
					unlink(PUBLIC_PATH . $data['image_current']);
				}
			}

			if($image_verif[0] == 1){
				$tags = $data['tags'];
				unset($data['tags']);
				unset($data['image_current']);
				$update = parent::update($data, $id);
				if($update[0]){
					$last_id = parent::select("where id = $id");
					$sql = '';
					mysqli_multi_query($this->conn, "DELETE from tags_posts WHERE post_id = $id");
					if(!empty($tags)){
						foreach($tags as $key => $value){
						$sql .= "INSERT INTO tags_posts (post_id, tag_id) VALUES ('$id', '$value');";
					}
					mysqli_multi_query($this->conn, $sql);
					}
		    		$this->show = true;
		    		$this->type = 1;
		    		$this->message = "Data has been modified to database!";
		    		parent::set_log($last_id[0]['title']." post", 2);
		    	}else{
		    		$this->show = true;
		    		$this->message = "This data is already exist!";
		    		unlink(PUBLIC_PATH . $data['image']);
		    	}
		    	Helper::notification($this->show, $this->message, $this->type);
			}
		}

		public function delete($data){
			$deleteData = parent::delete($data);
			if($deleteData[0]){
				$this->show = true;
				$this->type = 1;
				$this->message = "Data has been removed from database!";
				parent::set_log($deleteData[1][0]['title']." post", 0);
				unlink(PUBLIC_PATH . $deleteData[1][0]['image']);
			}else{
				// $this->show = true;
				// $this->message = "Something is wrong!";
			}
		    Helper::notification($this->show, $this->message, $this->type);
		}

	}
 ?>
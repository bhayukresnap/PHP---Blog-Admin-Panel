<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/src/Database.php');
	class User extends Database{
		
		public function __construct($table = 'users'){
			$columns = array(
				"name",
				"username",
				"password",
				"role_id",
				"photo",
				"job",
				"created_at",
				"updated_at",
			);
			parent::__construct($table, $columns);
		}

		public function insert($data){
			$insert = parent::insert($data);
			if($insert[0]){
	    		$this->show = true;
	    		$this->type = 1;
	    		$this->message = "Data has been added to database!";
	    	}else{
	    		$this->show = true;
	    		$this->message = "This username is already exist!";
	    	}
			Helper::notification($this->show, $this->message, $this->type);
		}

		public function delete($data){
			$deleteData = parent::delete($data);
			if($deleteData[0]){
				$this->show = true;
				$this->type = 1;
				$this->message = $deleteData[1][0]['username']." has been removed from database!";
			}else{
				// $this->show = true;
				// $this->message = "Something is wrong!";
			}
		    Helper::notification($this->show, $this->message, $this->type);
		}

		public function update($data, $id){
			$image_verif = is_array($data['photo']) ? Helper::ImageVerification($data['photo']) : array(1);
			if(count($image_verif) > 1){
				$data['photo'] = $image_verif[1];
				if(file_exists(PUBLIC_PATH . $data['photo_current'])){
					unlink(PUBLIC_PATH . $data['photo_current']);
				}
			}

			if($image_verif[0] == 1){
				unset($data['photo_current']);
				$update = parent::update($data, $id);
				if($update[0]){
					$last_id = parent::select("where id = $id");
		    		$this->show = true;
		    		$this->type = 1;
		    		$this->message = "Data has been modified to database!";
		    		$_SESSION['user'] = $last_id[0];
		    	}else{
		    		$this->show = true;
		    		$this->message = "This data is already exist!";
		    		unlink(PUBLIC_PATH . $data['photo']);
		    	}
		    	Helper::notification($this->show, $this->message, $this->type);
			}
		}

		public function grant_access($id){
			$user = $this->select('where id = '.$id);
			if(count($user) > 1){
				$this->show = true;
				$this->message = "It seems there is a problem with your account, please contact your administrator!";
			}elseif(count($user) == 0){
				// $this->show = true;
				// $this->message = "This account isn't exist!";
			}elseif($user[0]['role_id'] == 1){
				// $this->show = true;
				// $this->message = "This user already has access!";
			}else{
				$update = "update $this->table set role_id = '1' where id = '$id'";
				if(mysqli_query($this->conn, $update)){
					$this->show = true;
					$this->type = 1;
					$this->message = $user[0]['username']." is admin now!";
				}else{
					$this->show = true;
					$this->message = "Your query isn't working!";
				}
			}
	 		Helper::notification($this->show, $this->message, $this->type);
		}

		public function revoke_access($id){
			$user = $this->select('where id = '.$id);			
			if(count($user) > 1){
				$this->show = true;
				$this->message = "It seems there is a problem with your account, please contact your administrator!";
			}elseif(count($user) == 0){
				$this->show = true;
				$this->message = "This account isn't exist!";
			}elseif($user[0]['role_id'] == 0){
				$this->show = true;
				$this->message = "This user hasn't access yet!";
			}else{
				if(mysqli_query($this->conn, "update $this->table set role_id = '0' where id = '$id'")){
					$this->show = true;
					$this->type = 1;
					$this->message = $user[0]['username']." has no access!";
				}else{
					$this->show = true;
					$this->message = "Your query isn't working!";
				}
			}
	 		Helper::notification($this->show, $this->message, $this->type);
		}

	}
 ?>
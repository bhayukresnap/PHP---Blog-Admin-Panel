<?php 	
class Helper{
	public function notification($show, $message, $type){
		$notification = array(
			"message"=>$message,
			"type"=>$type == 1 ? "success" : "danger",
			"icon"=>$type == 1 ? "check" : "exclamation-circle",
			"title"=> $type == 1 ? "Success : " : "Failed : ",
		);
		$show ? $_SESSION['notification'] = $notification : "";
	}

	public function mapValues($data){
		return implode(", ", substr_replace(substr_replace($data, "'", 0, 0), "'", max(array_map('strlen', $data)) + 1));
	}

	public function mapColumns($data){
		return implode(", ", $data);
	}

	public function mapUpdate($data){
		$temp = [];
		foreach($data as $key => $value){
			$temp[] = $key." = '".$value."'";
		}
		return implode(", ", $temp);
	}

	public function ImageVerification($image){
		$show = true;
		$message = '';
		$type = 0;
		if($image['name'] != ''){
			$image_path = IMG_PATH_DIR . str_replace(" ", "_", strtolower(basename($image["name"])));
			$image_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
			$image_size = $image['size'];
			if(file_exists(PUBLIC_PATH.$image_path)) {
				$show = true;
				$type = 0;
				$message = "Please change your image name!";
			}else{
				if($image_size < IMG_SIZE){
					if($image_ext == 'jpg' || $image_ext == 'jpeg' || $image_ext == 'png' || $image_ext == 'gif'){
						if(move_uploaded_file($image['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/public/".$image_path)){
							return array(1, $image_path);
						}else{
							$message = "Unfortunately, The image has not been uploaded";
						}
					}else{
						$message = "Only jpg, jpeg, png, gif are allowed!";
					}
				}else{
					$message = "Image must less than 1mb!";
				}
			}
		}else{
			$message = "Please check your image!";
		}

		Helper::notification($show, $message, $type);
	}
}
?>
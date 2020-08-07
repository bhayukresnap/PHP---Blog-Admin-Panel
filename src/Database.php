<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/config/config.php");
include_once($_SERVER['DOCUMENT_ROOT']."/src/Helper.php");
	class Database{
		public $conn;
		protected $table, $columns, $charset = 'utf8';
		public $show = false, $message = '', $type = 0;
		public function __construct($table = '', $columns = []) {
	        $this->conn = new mysqli(CONFIG["db"]["server"], CONFIG["db"]["user"], CONFIG["db"]["password"], CONFIG["db"]["dbname"]);
	        $this->table = $table;
	        $this->columns = Helper::mapColumns($columns);
	        $this->conn->set_charset($this->charset);
			!$this->conn ? die("Connection Failed: ".mysqli_connect_error()) : '';
	    }

	    public function select($conditions = '', $select = '*', $pagination = ""){
	    	$temp = array();
	    	$where_clause = ($conditions ? $conditions : '');
	    	if($pagination){
		    	$start_from = ($pagination-1) * LIMIT_PER_PAGE;
	    		$where_clause .= " limit $start_from, ". LIMIT_PER_PAGE;
	    	}
	    	$run_sql =  mysqli_query($this->conn, "select $select from $this->table ".$where_clause);
	    	while($data = mysqli_fetch_assoc($run_sql)){
	    		$temp[] = $data;
	    	}
	    	if($pagination){
	    		return array(
	    			"data" => $temp,
	    			"page" => $this->pagination(),
	    		);
	    	}
	    	return $temp;
	    }
	    
	    public function insert($data){
	    	$data = is_array($data) ? Helper::mapValues($data) : Helper::mapValues(array($data));
	    	$insert = mysqli_query($this->conn, "insert into $this->table ($this->columns) values ($data)");
	    	return array($insert, mysqli_insert_id($this->conn));
	    }

	    public function delete($id){
	    	$check_availability = $this->select("where id = $id");
	    	if(count($check_availability) >= 1){
				$delete = mysqli_query($this->conn, "delete from $this->table where id = $id");
		    	return array($delete, $check_availability);
			}else{
				return array(0);
			}
	    }

	    public function update($data, $id){
	    	$data = Helper::mapUpdate($data);
	    	$update = mysqli_query($this->conn, "update $this->table set $data where id = '$id'");
	    	return array($update);
	    }

	    public function pagination(){
	    	$temp = [];
			$count = count($this->select());
			$total_pages = ceil($count / LIMIT_PER_PAGE);
			$active_page = '';
			for($i = 1; $i<=$total_pages; $i++){
				if(isset($_GET['page']) && !empty($_GET['page'])){
					if($_GET['page'] == $i){
						$active_page = 'active';
					}
				}elseif($i == 1){
					$active_page = 'active';
				}
				$temp[] = '<li class="page-item '.($active_page).'"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
				$active_page = '';
			}
			return $temp;
	    }

	    public function set_log($text, $type){
	    	$date = DATE;
	    	$user_id = $_SESSION['user']['id'];
	    	$insert = mysqli_query($this->conn, "insert into logs (text, log_type, user_id, date) values ('$text',$type,$user_id,'$date')");
	    }

	    public function __destruct(){
	    	$this->conn->close();
	    }
	}

 ?>
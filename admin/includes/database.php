<?php

require_once("new_config.php");


class Database{

	public $connection;

	function __construct(){
	$this->open_db_connection();
}

	public function open_db_connection(){
		$this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

		if($this->connection->connect_errno){

			die("Database connection failed" . mysqli_error());

		}
		return $this->connection;
	}



	public function query($sql){
		$result = $this->connection->query($sql);

		return $result;
	}

	public function confirm($result){
		if(!$result){
			die("Query Failed");
			return false;
		}else{
			return true;
		}
	}

	public function escape_string($string){
		return $this->connection->real_escape_string($string);

	}

	public function insert_id_method(){
		return $this->connection->insert_id;
	}


}


$database = new Database();



?>
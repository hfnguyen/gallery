<?php

class Db_objects
{

	/*Properties checking extensions*/
	private $file_ext;
	private $allowed;
	protected $id;

	/*DEALING WITH FILES AND ERRORS*/

	public $errors = array();

	protected static $db_table = "users";

	public $upload_errors = array(

	UPLOAD_ERR_OK 			=>"No Error", 
	UPLOAD_ERR_INI_SIZE 	=>"The uploaded file exceeds the UPLOAD_MAX_FILE_SIZE directive in php.ini", 
	UPLOAD_ERR_FORM_SIZE 	=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML", 
	UPLOAD_ERR_PARTIAL 		=>"File was only partially uploaded", 
	UPLOAD_ERR_NO_FILE 		=>"No files were uploaded", 
	UPLOAD_ERR_NO_TMP_DIR 	=>"Missing the temporary folder", 
	UPLOAD_ERR_CANT_WRITE 	=>"Failed to write file to disk", 
	UPLOAD_ERR_EXTENSION 	=>"A PHP extension stopped the file upload",
	);

	//Passing $_FILES['uploaded_file'] as an argument
	public function set_file($file){
		if ($file['error'] != 0) {
			$this->errors[] = $this->upload_errors[$file['error']];
			return false;
		}else{

			$this->fname    = $file['name']; 
			$this->tmp_path	= $file['tmp_name'];
			$this->fsize 	= $file['size'];
		}
	}
	

	/*find all record in database*/

	public static function find_all(){
		return static::find_query("SELECT * FROM " . static::$db_table . " ");
	}

	/*Method finding user in databse by id*/

	public static function find_by_id($id){
		global $database;
		$result_array = static::find_query("SELECT * FROM " . static::$db_table . " WHERE id = $id ");

		return !empty($result_array) ? array_shift($result_array) : false;
		 
	}


	public static function find_query($sql){
		global $database;
		$array_of_objects = array();
		$result = $database->query($sql);
		while($row = $result->fetch_array()){
			$array_of_objects[] = static::instantiation($row);
		}
		return $array_of_objects;
	}

	/*Method creating an object with values of properties corressponding with values in database*/

	public static function instantiation($record){

		$called_class = get_called_class();

		$the_object = new $called_class;

        foreach ($record as $key => $value) {
        	if($the_object->check_key($key)){
        		$the_object->$key = $value;
        	}
        }

        return $the_object;
	}

	/*Method checking the key of the array when processing the 'instantiation method' above*/

	protected function check_key($key){
		$checking_array = get_object_vars($this);
		return array_key_exists($key, $checking_array);		
	}


		/*Method escaping special characters*/

	protected function clean_properties(){
		global $database;
		$clean_properties = array();

		foreach ($this->properties() as $key => $value) {
			$clean_properties[$key] = $database->escape_string($value);
		}

		return $clean_properties;
	}


	/*Method getting all the properties of the object and then return an array*/

	protected function properties(){
		$properties = array();

		foreach (static::$db_table_fields as $value){
			if (property_exists($this, $value)) {
				$properties[$value] = $this->$value;
			}
		}

		return $properties;

	}


	// method creating record
	//Note: concatenation: '" concatenate here... "'

	public function create(){
		global $database;

		$properties = $this->clean_properties();

		$sql  = "INSERT INTO " .static::$db_table. "(" . implode(",",array_keys($properties)) . ")";
		$sql .= "VALUES('". implode("','", array_values($properties)) ."')";

		if ($database->query($sql)) {
			$this->id = $database->insert_id_method();
			return true;
		}else{
			return false;
		}
	}


	public function update(){
		global $database;

		$properties 	  = $this->clean_properties();
		$properties_pairs = array();

		foreach ($properties as $key => $value) {
			$properties_pairs[] = "{$key}='$value'";
		}

		$sql = "UPDATE " .static::$db_table. " SET ";
		$sql .= implode(", ", $properties_pairs);
		$sql .= " WHERE id =" . $database->escape_string($this->id) . "";

		$result = $database->query($sql);
		$database->confirm($result);

	}

	public function delete(){
		global $database;
		$sql = "DELETE FROM " .static::$db_table. " WHERE id = $this->id";
		$result = $database->query($sql);
		return $database->confirm($result) ? true:false;
	}

	public function implement(){
		return isset($this->id) ? $this->update() : $this->create();
	}

	public static function count_all(){
		global $database;
		$sql = "SELECT COUNT(*) FROM " . static::$db_table;
		$result = $database->query($sql);

		$row = $result->fetch_array(MYSQLI_ASSOC);

		return array_shift($row);
	}



}


?>
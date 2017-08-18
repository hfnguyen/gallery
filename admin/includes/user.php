<?php

class User extends Db_objects
{
	protected static $db_table = "users";
	protected static $db_table_fields = array('username', 'password', 'firstname', 'lastname', 'fname');
	public $id;
	public $username;
	public $password;
	public $firstname;
	public $lastname;
	public $fname;
	public $tmp_path;
	public $fsize;
	public $upload_dir = "images";
	public $img_ph 	   = "http://placehold.it/400x4000&text=image"; 


	public function img_placeholder() {
		return empty($this->fname)? $this->img_ph : $this->upload_dir.DS.$this->fname;
	}

	public function find_by_username($username){
		global $database;
		$username = $database->escape_string($username);

		$sql = "SELECT * FROM " . self::$db_table . " WHERE ";
		$sql .= "username = '{$username}' ";

		$result = self::find_query($sql);
		return !empty($result) ? array_shift($result) : false;
	}


	public function ajax_save_user_image($user_image, $user_id){

		global $database;

		$user_image = $database->escape_string($user_image);
		$user_id = $database->escape_string($user_id);

		$this->fname = $user_image;
		$this->id 	 = $user_id;
		$this->implement();

		echo $this->img_placeholder();

	}



	public function add_or_update_user($check=0){

		global $database;
		$target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_dir.DS.$this->fname;

		if(file_exists($target_path)){
			if ($check == 0) {
				$this->create();
			}else{
				$this->update();
			}
		}else{
			/*Work out the extension*/

			$file_ext = explode(".", $this->fname);
			$file_ext = strtolower(end($file_ext));
			$allowed  = array('jpg', 'jpeg', 'png' );


			if(in_array($file_ext, $allowed)){

				if (move_uploaded_file($this->tmp_path, $target_path)) {

					if ($check == 0) {
						$this->create();
						unset($this->user_tmp);
						return true;
					}else{
						$this->update();
						unset($this->user_tmp);
						return true;
					}

				}else{
					echo "The file directory probably does not have permission";
					return false;
				}
			}else{

				echo "The uploaded photo is not supported. Please choose another one!";
				return false;
			}

		}
	}

	/*Method verifying and then return an object*/

	public static function verify($username,$password){
		global $database;

		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		$sql  = "SELECT * FROM " . self::$db_table . " WHERE ";
		$sql .= "username = '{$username}' AND ";
		$sql .= "password = '{$password}' ";
		$sql .= "LIMIT 1";

		$result_array = self::find_query($sql);

		return !empty($result_array) ? array_shift($result_array) : false;

	}

	public function delete_photo(){
		if($this->delete()){
			$target_path = SITE_ROOT . DS . 'admin'	. DS . $this->upload_dir . DS . $this->fname;
			return unlink($target_path) ? true : false;
		}else{
		return false;
	}
}

}//End of class User





?>
<?php

/**
**/
class Photos extends Db_objects
{
	
	protected static $db_table = "photos";
	protected static $db_table_fields = array('id', 'title', 'caption', 'description', 'fname', 'alternative_text', 'ftype', 'fsize');
	public $id;
	public $title;
	public $caption;
	public $description;
	public $fname;
	public $alternative_text;
	public $ftype;
	public $fsize;
	public $tmp_path;
	public $upload_dir = "images";


	public function photo_path(){
		return $this->upload_dir.DS.$this->fname;
	}


	/*update or create photo*/

	public function update_or_create_photo(){
		if ($this->id) {
			$this->update();
		}else{

			/* Update_or_create_photo method will be processed even when no files were uploaded, use this condition to avoid that case*/
			if (!empty($this->errors)) {
				return false;
			}

			/*Prevent duplicate files uploaded*/
			$target_path = SITE_ROOT . DS . 'admin'	. DS . $this->upload_dir . DS . $this->fname;
			if (file_exists($target_path)) {
					$this->errors[] = "The file {$this->fname} already exists";
					return false;
			}

			/*Work out the file extension*/

			$this->file_ext = explode(".", $this->fname);
			$this->file_ext = strtolower(end($this->file_ext));
			$this->allowed = array('jpeg', 'jpg', 'png', 'gif' );

			if(in_array($this->file_ext, $this->allowed)){

				if (move_uploaded_file($this->tmp_path, $target_path)) {
					if ($this->create()) {
						unset($this->tmp_path);
						return true;
					}
					}else{
						$this->errors[] = "The file directory probably does not have permission";
						return false;
					}

			}else{
				$this->errors[] = "The uploaded photo is not supported. Please choose another one!";
				return false;
			}
		}
	}


	public function delete_photo(){
		if($this->delete()){
			$target_path = SITE_ROOT . DS . 'admin'	. DS . $this->photo_path();
			return unlink($target_path) ? true : false;
		}else{
		return false;
	}
}

	public static function display_sidebar_data($photo_id){
		$photo = Photos::find_by_id($photo_id);

		$output = "<a class='thumbnail' href='#'><img class='img-thumbnail' width='100' src='{$photo->photo_path()}'></a>";
		$output.= "<p>{$photo->fname}</p> ";
		$output.= "<p>{$photo->ftype}</p> ";
		$output.= "<p>{$photo->fsize}</p> ";

		echo $output;
	}

}

?>
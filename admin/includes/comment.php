<?php

class Comment extends Db_objects
{
	protected static $db_table = "comments";
	protected static $db_table_fields = array('photo_id', 'author', 'content');
	public $id;
	public $photo_id;
	public $author;
	public $content;

	public static function set_comment($photo_id, $author="Anonymous", $content=""){

		if (!empty($photo_id) && !empty($author) && !empty($content)) {
			
			$comment = new Comment();
			$comment->photo_id = (int)$photo_id;
			$comment->author   = $author;
			$comment->content  = $content;

			return $comment;
		}else{
			return false;
		}
	}


	
	public static function find_comment($photo_id){

		global $database;
		$photo_id = $database->escape_string($photo_id);

		$sql  = "SELECT * FROM " . self::$db_table;
		$sql .= " WHERE photo_id= {$photo_id}";
		$sql .= " ORDER by photo_id ASC";

		return self::find_query($sql);
	}

}//End of class User





?>
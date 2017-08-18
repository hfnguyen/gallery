<?php
require_once("init.php");

if (isset($_POST['image_name'])) {
	
	$user_id	 = $_POST['user_id'];
	$user_image  = $_POST['image_name'];
	$user 		 = User::find_by_id($user_id);
	$user->ajax_save_user_image($user_image, $user_id);
}

if (isset($_POST['image_id'])) {
	Photos::display_sidebar_data($_POST['image_id']);
}

?>
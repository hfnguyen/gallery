<?php
require_once("includes/init.php");

if(!$session->is_signed_in()){
    header("Location:../login.php");
}

if (empty($_GET['del_id'])) {
	header("Location: photos.php");
}

$photo = Photos::find_by_id($_GET['del_id']);

if ($photo) {
	$photo->delete_photo();
	$session->message("The photo {$photo->id} has been deleted!");
	header("Location: photos.php");
} else{
	header("Location: photos.php");
}

?>
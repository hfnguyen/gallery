<?php
require_once("includes/init.php");

if(!$session->is_signed_in()){
    header("Location:../login.php");
    exit();
}

if (empty($_GET['id'])) {
	header("Location: comment_photo.php");
	exit();
}

$comment = Comment::find_by_id($_GET['id']);

if ($comment) {
	$session->message("The comment has been deleted!");
	$comment->delete();
}

header("Location: comment_photo.php?id={$comment->photo_i}d");

?>
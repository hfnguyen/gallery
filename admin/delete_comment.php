<?php
require_once("includes/init.php");

if(!$session->is_signed_in()){
    header("Location:../login.php");
}

if (empty($_GET['dc'])) {
	header("Location: comments.php");
}

$comment = Comment::find_by_id($_GET['dc']);

if ($comment) {
	$comment->delete();
}

header("Location: comments.php");

?>
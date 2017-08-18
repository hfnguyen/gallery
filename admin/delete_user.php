<?php
require_once("includes/init.php");

if(!$session->is_signed_in()){
    header("Location:../login.php");
    exit();
}

if (empty($_GET['d_user'])) {
	header("Location: users.php");
	exit();
}

$user = User::find_by_id($_GET['d_user']);

if ($user) {
	$user->delete_photo();
	$session->message("The user {$user->username} has been deleted!");
	header("Location: users.php");
	exit();
} else{
	header("Location: users.php");
	exit();
}

?>
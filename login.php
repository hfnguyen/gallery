<?php 
require_once("admin/includes/init.php"); 
require_once("includes/header.php"); 

?>

<?php

if($session->is_signed_in()){
	header("Location: admin/index.php");
}

/*Minus $_SESSION as it increased in this logout page since we included init.php in that page*/
$_SESSION['count'] = $_SESSION['count']-1;

if(isset($_POST['submit'])){
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	$user_found = User::verify($username,$password);

	if($user_found){
		$session->login($user_found);

		/*Minus $_SESSION as it increased in this page since we included init.php*/

		$_SESSION['count'] = $_SESSION['count']-1;
		header("Location: admin/index.php");
	}else{
		$the_message = "Your password or username is incorrect";
	}
}else{
	$username = "";
	$password = "";
	$the_message = "";
}

?>

<div class="container">

<h4 class="bg-danger"><?php echo $the_message; ?></h4>
	<header>
		<h1 class="text-center">Login</h1>
		<div class="col-sm-4 col-sm-offset-5">         
		    <form action="" method="post">
		    
		        <div class="form-group">
			        <label for="username">Username</label>
			            <input type="text" name="username" class="form-control" value="<?php echo htmlentities($username); ?>" >
		        </div>

		         <div class="form-group">
			         <label for="password">Password</label>
			            <input type="password" name="password" class="form-control" value="<?php echo htmlentities($password); ?>" >
		        </div>

		        <div class="form-group">
		          <input type="submit" name="submit" value="Submit" class="btn btn-primary" >
		        </div>

		    </form>
		</div> 
	</header> 
</div>


<?php require_once("includes/footer.php");  ?>
<?php

require_once("includes/header.php"); 
require_once("includes/init.php"); 

if(!$session->is_signed_in()){
    header("Location:../login.php");
    exit();
}

$user = new User();
$message = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user->username = $_POST['username'];
    $message = $user->username;

    if($user->find_by_username($user->username)){
        $message = "Username already exists!";
    }else{
        $user->password     = $_POST['password'];
        $user->firstname    = $_POST['firstname'];
        $user->lastname     = $_POST['lastname'];
        
        $user->set_file($_FILES['user_image']);

        if($user->add_or_update_user()){
            $message = "User successfully added!";
        }
    }
}

?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            
          <?php include("includes/top_nav.php"); ?>
              
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            
            <?php include("includes/side_nav.php"); ?>
            
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">
                        User
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data" >     
                        <div class="col-md-6 col-md-offset-3">

                        <?php echo "<h3>$message</h3>"; ?> 

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" required >

                            </div>

                            <div class="form-group">
                                <img class="admin-user-thumbnail user_image" src="<?php echo $user->img_placeholder(); ?>" class="img-thumbnail">
                                <input type="file" name="user_image">
                            </div>
                                
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" name="firstname"  class="form-control">
                            </div>
                                
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" name="lastname"  class="form-control" >
                            </div>                          
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password"  class="form-control" required >
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" value="Add" class="btn btn-primary">
                            </div>

                        </div>
                    </form>  

                    </div>
                </div>
                <!-- /.row -->
            </div>              
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    <?php include("includes/footer.php"); ?>
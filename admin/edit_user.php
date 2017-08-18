<?php
require_once("includes/header.php");
require_once("includes/photo_library_modal.php");  
require_once("includes/init.php"); 

if(!$session->is_signed_in()){
    header("Location:../login.php");
    exit();
}

$message = "";

if (empty($_GET['e_user'])) {
    header("Location: users.php");
    exit();
}else{

    $id = $database->open_db_connection()->real_escape_string($_GET['e_user']);

    $user = User::find_by_id($id);

/*Process after finding this specific user*/
    if ($user) {
        if (isset($_POST['edit'])) {

            $user->username   = $_POST['username'];
            $user->firstname  = $_POST['firstname'];
            $user->lastname   = $_POST['lastname'];
            $user->password   = $_POST['password'];

            $user->set_file($_FILES['user_image']);

            $user->add_or_update_user($id);
            $session->message("The user has been updated!");
            header("Location: users.php");
            exit();
        }

    }else{
        header("Location: users.php");
        exit();
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

                    <div class="col-md-6 user_image_box">
                        <a href="#" data-toggle="modal" data-target="#photo-library" ><img class="img-responsive" src="<?php echo $user->img_placeholder(); ?>" alt="" ></a>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data" >     
                        <div class="col-md-6">
                        
                        <?php echo "<h3>$message</h3>";  ?>

                            <div class="form-group">
                                <input type="file" name="user_image">
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $user->username;  ?>">

                            </div>
                                
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" name="firstname"  class="form-control" value="<?php echo $user->firstname;  ?>">
                            </div>
                                
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" name="lastname"  class="form-control" value="<?php echo $user->lastname;  ?>">
                            </div>                          
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password"  class="form-control" value="<?php echo $user->password; ?>" required>
                            </div>

                            <div class="form-group">

                            <a id="user-id" class="btn btn-danger" href="delete_user.php?d_user=<?php echo $user->id; ?>">Delete</a>

                                <input type="submit" name="edit" value="Edit" class="btn btn-primary pull-right">
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
        <?php ob_flush(); ?>

    <?php include("includes/footer.php"); ?>
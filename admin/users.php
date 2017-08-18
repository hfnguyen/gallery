<?php

require_once("includes/header.php"); 
require_once("includes/init.php"); 

if(!$session->is_signed_in()){
    header("Location:../login.php");
}

$users = User::find_all();

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
                        Users
                    </h1>  
                    <p class="bg-success"><?php echo $session->message; ?></p>
                    <a href="add_user.php" class="btn btn-primary">Add User</a>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                    </tr>
                                </thead>
                                <tbody>     
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php  echo $user->id; ?></td>

                                        <td><img class="admin-user-thumbnail user_image" src="<?php echo $user->img_placeholder();  ?>"></td>

                                        <td><?php  echo $user->username; ?>
                                            
                                            <div class="action_link">
                                                <a href="delete_user.php?d_user=<?php echo $user->id; ?>">Delete</a>
                                                <a href="edit_user.php?e_user=<?php echo $user->id;?>">Edit</a>
                                                <a href="">View</a>
                                            </div>

                                        </td>
                                        <td><?php  echo $user->firstname; ?></td>
                                        <td><?php  echo $user->lastname; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>              
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    <?php include("includes/footer.php"); ?>
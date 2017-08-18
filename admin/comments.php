<?php

require_once("includes/header.php");
require_once("includes/init.php"); 

if(!$session->is_signed_in()){
    header("Location:../login.php");
}

$comments = Comment::find_all();



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
                            Comments
                        </h1>         
                    </div>

                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Photo id</th>
                                <th>Author</th>
                                <th>Content</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php  foreach ($comments as $comment): ?>
                            <tr>
                                <td><?php echo $comment->id; ?></td>
                                <td><?php echo $comment->photo_id; ?></td>
                                <td><?php echo $comment->author; ?></td>
                                <td><?php echo $comment->content; ?></td>
                                <td><a href="delete_comment.php?dc=<?php echo $comment->id; ?>">Delete</a></td>
                            </tr>
                        </tbody>
                        <?php endforeach; ?>

                    </table>

                </div>
                <!-- /.row -->
            </div>              
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    <?php include("includes/footer.php"); ?>
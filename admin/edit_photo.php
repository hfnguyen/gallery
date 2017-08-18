<?php

require_once("includes/header.php"); 
require_once("includes/init.php"); 

if(!$session->is_signed_in()){
    header("Location: ../login.php");
}

if (empty($_GET['ed_id'])) {
    header("Location: photos.php");
}else{

    $id = $database->open_db_connection()->real_escape_string($_GET['ed_id']);

    $photo = Photos::find_by_id($id);

    if ($photo) {
        if (isset($_POST['update'])) {

            $photo->title            = $_POST['title'];
            $photo->photo            = $_POST['photo'];
            $photo->caption          = $_POST['caption'];
            $photo->alternative_text = $_POST['alt_text'];
            $photo->description      = $_POST['desc'];

            $photo->update();
        }
    }else{
        header("Location: photos.php");
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
                        Photo
                    </h1> 

                    <form action="" method="post">     
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $photo->title; ?>" >

                            </div>

                            <div class="form-group">
                                <img src="<?php echo $photo->photo_path(); ?>" class="img-thumbnail">
                            </div>
                                
                            <div class="form-group">
                                <label for="caption">Caption</label>
                                <input type="text" name="caption"  class="form-control" value="<?php echo $photo->caption; ?>" >
                            </div>
                                
                            <div class="form-group">
                                <label for="Alt text">Alternative Text</label>
                                <input type="text" name="alt_text"  class="form-control" value="<?php echo $photo->alternative_text; ?>" >
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" name="desc"  class="form-control" value="<?php echo $photo->description; ?>" cols="30" rows="10" ></textarea>
                            </div>                             
                            
                        </div>


                        <div class="col-md-4">
                            <div class="photo-info-box">
                                <div class="info-box-header">
                                    <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                </div>

                                <div class="inside">
                                    <div class="box-inner">

                                        <p class="text">
                                            <span class="glyphicon glyphicon-calendar"></span>Uploaded on:
                                        </p>

                                        <p class="text">
                                            Photo Id: <span class="data photo_id_box">34</span>
                                        </p>

                                        <p class="text">
                                            Filename: <span class="data">image.jpg</span>
                                        </p>

                                        <p class="text">
                                            File Type: <span class="data">JPG</span>
                                        </p>

                                        <p class="text">
                                            File Size: <span class="data">12345</span>
                                        </p>
                                    </div>
                                    <div class="info-box-footer clearfix">
                                        <div class="info-box-delete pull-left">
                                            <a href="delete_photo.php?del_id=<?php echo $photo->id; ?>" class="btn btn-danger btn-lg">Delete</a>
                                        </div>

                                        <div class="info-box-update pull-right">
                                            <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg" >
                                        </div>
                                    </div>
                                </div>
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
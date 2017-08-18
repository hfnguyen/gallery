<?php 

include_once "includes/header.php";



$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

/*Work out items on each page, items = 4 */

/*$page = $_GET['page']*4 - 1;
$k = ($_GET['page'] - 1)*4;*/

$items_per_page = 4;

$items_total_count = Photos::count_all();

$paginate = new paginate($page, $items_per_page, $items_total_count);

//$photos = Photos::find_all();

$sql    = "SELECT * FROM photos ";
$sql   .= "LIMIT {$items_per_page} ";
$sql   .= "OFFSET {$paginate->offset()} ";
$photos = Photos::find_query($sql);



?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <div class="thumbnails row">

                    <?php foreach($photos as $photo):  ?>

                        <!-- <?php

                            //if ( $k <= $key && $key <= $page) {

                        ?> -->
                            <div class="col-xs-6 col-md-3" >

                                <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                                    
                                    <img src="admin/<?php echo $photo->photo_path(); ?>" alt="">
                                </a>

                            </div>

                    <?php endforeach; 
                    //}  
                    ?>

                </div>

                <div class="row">
                    <ul class="pager">

                        <?php
                            if ($paginate->total_pages() > 1 ) {

                                if ($paginate->has_next()){

                                    echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                                }

                                for ($i=1; $i <= $paginate->total_pages() ; $i++) { 
                                    if ($i == $paginate->current_page) {
                                        
                                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                                    }else {
                                         echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                                    }
                                }


                                if ($paginate->has_previous()) {

                                    echo "<li class='next'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                                }
                            }                       
                        ?>

                    </ul>
                </div>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include_once "includes/sidebar.php";?>

        </div>
        <!-- /.row -->

      <?php include_once "includes/footer.php";?>

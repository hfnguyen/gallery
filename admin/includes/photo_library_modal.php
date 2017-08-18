<?php ob_start(); ?>
<div class="modal fade" id="photo-library">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gallery System Library</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-9">
            <div class="thumbnails row">
                <!-- PHP code -->
                <?php
                $photos = Photos::find_all(); 

                foreach($photos as $photo): 

                ?>
                <div class="col-xs-2">
                    <a role="checkbox" aria-checked="false" tabindex="0" id="" href="#">
                        <img class="modal-thumbnails img-responsive" src="<?php  echo $photo->photo_path(); ?>" data="<?php echo $photo->id; ?>" >
                    </a>
                    <div class="photo-id hidden"></div>
                </div>

                  <?php endforeach; ?>

            </div>
        </div><!-- col-md-9 -->

        <!-- Sidebar information -->
        <div class="col-md-3">
            <div id="modal_sidebar"></div>
        </div>

      </div><!-- Modal Body -->
      <div class="modal-footer">
          <div class="row">
              <button id="set_user_image" type="button" class="btn btn-primary" disabled="true" data-dismiss="modal" >Apply Selection</button>
          </div>
        
      </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
  </div><!-- .modal -->
</div>

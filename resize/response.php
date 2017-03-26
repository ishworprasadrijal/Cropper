<?php 
$_galleries = $data['galleries'];
if(isset($_galleries) && count($_galleries)>0){ ?>
<div class="row">
   <?php foreach($_galleries as $_gallery): ?>
        <div class="panel panel-info ic pull-left" data-directory="<?php echo $_gallery->directory;?>" data-title="<?php echo $_gallery->title;?>" data-id="<?php echo $_gallery->id;?>">
                <label class="copy_clip btn-success btn btn-xs" data-txt="anchor"> Copy</label>
                <label class="delete_media btn-danger btn btn-xs" data-txt="anchor" data-id="<?php echo $_gallery->id;?>"> Delete</label>
                <div style="margin: 3px;">
                    <img src="<?php echo $_gallery->directory.'/thumbnails/'.$_gallery->title; ?>">
                </div>
            </div>
    <?php endforeach; ?>
</div>
<hr>
        <div class="footer">
            <span class="btn btn-default pull-right npg_js" data-last_id="<?php echo isset($npg_id)?$npg_id:0;?>" data-preset="<?php echo isset($preset)?$preset:'';?>">Next </span>
        </div> <?php }else{
    echo "<div class='alert alert-danger'>No More Galleries</div>";
    } ?>

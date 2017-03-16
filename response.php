<?php 
$_galleries = $data['galleries'];
if(isset($_galleries) && count($_galleries)>0){ ?>
<div class="row">
   <?php foreach($_galleries as $_gallery): ?>
        <div class="panel panel-info ic pull-left" data-directory="<?=$_gallery->directory;?>" data-title="<?=$_gallery->title;?>">
            <label class="copy_clip btn-primary btn btn-sm" data-txt="url" > Url</label>
            <label class="copy_clip btn-primary btn btn-sm" data-txt="anchor"> Anchor</label>
            <div style="margin: 3px;">
                <img src="<?=$_gallery->directory.'/thumbnails/'.$_gallery->title;?>">
            </div>
        </div>
    <?php endforeach; ?>
</div>
<span class="btn btn-default pull-right npg_js" data-last_id="<?=$_gallery->id;?>">Next </span> <?php }else{
    echo "<div class='alert alert-danger'>No More Galleries</div>";
    } ?>

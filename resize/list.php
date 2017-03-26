<?php  
  /*==============================   
   Gallery is a fast, lightweight PHP plugin for cropping, resizing and uploading images in php. It uses Fengyuan Chen's Cropper.js v0.7.0

   @package         PHP
   @version        1.0
   @author         Ishwor Prasad Rijal
   @liscense       Free
   @copyright     2017 Ishwor Prasad Rijal (ishworsws@gmail.com)
   @link          https://github.com/ishworprasadrijal/Cropper 
   
    
  ================================*/
 $base_url = 'http://'.$_SERVER['SERVER_NAME'];
?>

<?php $_galleries = $data['galleries'];  ?>
  <div class="gallery-page">
  	<div class="gallery-grid">
  	<div class="row">
       <?php $ppg_id =0; if(isset($_galleries) && count($_galleries)>0){
        foreach($_galleries as $_gallery): ?>
       		<?php if($ppg_id==0) $ppg_id = $_gallery->id; ?> 
 			<div class="panel panel-info ic pull-left" data-directory="<?php echo $_gallery->directory;?>" data-title="<?php echo $_gallery->title;?>" data-id="<?php echo $_gallery->id;?>">
				<label class="copy_clip btn-success btn btn-xs" data-txt="anchor"> Copy</label>
				<label class="delete_media btn-danger btn btn-xs" data-txt="anchor" data-id="<?php echo $_gallery->id;?>"> Delete</label>
				<div style="margin: 3px;">
					<img src="<?php echo $base_url.'/'.$_gallery->directory.'/thumbnails/'.$_gallery->title; ?>">
				</div>
			</div> 
		<?php $npg_id = $_gallery->id; 
		endforeach; ?>
		<?php }else{
			echo "<div class='alert alert-danger'>No Galleries</div>";
			}?>
      </div>
      <hr>
		<div class="footer">
	      	<span class="btn btn-default pull-right npg_js" data-last_id="<?php echo isset($npg_id)?$npg_id:0;?>" data-preset="<?php echo isset($preset)?$preset:'';?>">Next </span>
	    </div>
   </div>
	    <hr>
		<label for="file_uploader" class="btn btn-success" data-preset="banner">
			<input type="file" id="file_uploader" class="new_crop_js" data-preset="<?php echo isset($preset)?$preset:''?>" style="display: none;"/>
			Upload
		</label>
  	<input type="text" class='form-control' id="url" style="opacity: 0;"> 
</div>

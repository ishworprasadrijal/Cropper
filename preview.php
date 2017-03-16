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
?>
<?php $_gallery = $data['gallery']; ?>
<div class="panel panel-info ic pull-left" data-directory="<?=$_gallery->directory;?>" data-title="<?=$_gallery->title;?>" data-id="<?=$_gallery->id;?>">
	<label class="copy_clip btn-success btn btn-xs" data-txt="anchor"> Copy</label>
	<label class="delete_media btn-danger btn btn-xs" data-txt="anchor" data-id="<?=$_gallery->id;?>"> Delete</label>
	<div style="margin: 3px;">
		<img src="<?php echo $data['croppedImage'];?>" style="max-width: 120px; height: 80px;">
	</div>
</div>
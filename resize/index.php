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
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="Description" CONTENT="Author: Ishwor Prasad Rijal, Category: Image resize and uploading Plugins for php Developer, ">
    <meta name="google-site-verification" content=""/>
    <title> Crop & Upload </title>
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="PHP, Crop, Resize, Upload, Free, Image, Gallery, Cropper, Plugin">
    
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/cropper.css" />
    <style>
      .cropperModal .modal-content .modal-body .img-container{
        height:300px;
      }

    </style>
    <script src="../assets/js/jquery.1.7.2.min.js" type="text/javascript"></script> 
    <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script> 
    <script src="../assets/js/cropper.js" type="text/javascript"></script> 
    <script src="../assets/js/notifier.js" type="text/javascript"></script> 
    <script src="../assets/js/media.js" type="text/javascript"></script> 
    <script> var base_url = "http://<?php echo $_SERVER['SERVER_NAME'];?>/"; </script>
  </head>
<!--   <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-4943021509426085",
    enable_page_level_ads: true
  });
</script> -->
<?php 
 $base_url = 'http://'.$_SERVER['SERVER_NAME'].'/cropper/';
 define('base_url',$base_url);
  require_once('gallery.php');
  $gallery = new GALLERY();
?>
<div class="container">
  <br>
  <div class="gallery-page-outer" style="display:none;">
    <?php $gallery->get_list('galleries'); ?>
  </div>
  <span class="btn btn-default toggle_gallery_js">List Gallery</span>
</div>
<?/*==============================                
 : cropper modal load everytime form template
================================*/ ?>
<div class="modal fade bs-example-modal-lg cropperModal" id="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="panel panel-info">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <div class="row">
         <div class="panel-heading" style="text-align: center">Crop </div>
        </div>
        </div>
        <div class="panel-body">
          <div class="modal-body">
            <div class="img-container">
              <img id="image" src="" alt="Picture">
            </div>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Close</button>
                <button type="button" id="cropBtn" class="btn btn-success btn-md" data-dismiss="modal">Crop and upload </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<?php 
  if(isset($_POST['action'])) {
    $action = $_POST['action'];
    return $action;
    $var = isset($_POST['name']) ? $_POST['name'] : null;
    $getData = $action($var);
    return $getData;
  }else{    
  	$action = isset($_POST['action']) ? $_POST['action'] : null;
  	if($action) return $gallery->$action;
  }
?>

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

<?php 
  include('db.php');
  include('gallery.php');
  $gallery = new GALLERY();
?>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="assets/css/cropper.css" />
<script src="assets/js/jquery.1.7.2.min.js" type="text/javascript"></script> 
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="assets/js/cropper.js" type="text/javascript"></script> 
<script src="assets/js/notifier.js" type="text/javascript"></script> 
<script src="assets/js/media.js" type="text/javascript"></script> 
<script> var base_url = "http://<?php echo $_SERVER['SERVER_NAME'];?>/"; </script>
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
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <div class="row">
       <h2 class="col-md-4">Crop </h2>
      </div>
      </div>

      <div class="modal-body">
        <div class="img-container">
          <img id="image" src="" alt="Picture">
        </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
            <button type="button" id="cropBtn" class="btn btn-primary btn-lg" data-dismiss="modal">Crop and upload </button>
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
	$gal = new gallery();
  echo $_GET['action'];
	$action = $_POST['action'];
	if($action) return $gal->$action;
  }
?>


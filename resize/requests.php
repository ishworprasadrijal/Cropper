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
	require_once('db.php');
	require_once('gallery.php');


	$gallery = new GALLERY();
	list(,$params) = explode('requests.php/',$_SERVER["REQUEST_URI"]);
  $actions = explode('/',$params);
  $action = $actions[0];
  unset($actions[0]);
  $parameters = implode(",",$actions);
	echo $gallery->$action($parameters);
?>
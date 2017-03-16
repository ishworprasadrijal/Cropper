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


	$setting = new GALLERY();
	list(,$params) = explode('requests.php/',$_SERVER[REQUEST_URI]);
	list($action,$p) = explode('/',$params);
	$parameters = str_replace($action,'',$p);
	echo $setting->$action($parameters);
?>
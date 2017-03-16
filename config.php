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
return (object) 
    [
    'hostname'=>'localhost',
    'db_user'=>'phpmyadmin_user',
    'db_password'=>'your_phpmyadmin_password',
    'database_name'=>'your_database_name',

	'default'=>(object) array(
            'naming'=>array('CropperModule-','timestamp'),
            'size'=>array(600,400),
            'directory'=>'assets/media/',
            'thumbnail'=>true,
            'ps'=>'default',
        ),
    'galleries'=>(object)array(
            'naming'=>array('Gallery_image-','timestamp'),
            'size'=>array(600,400),
            'directory'=>'assets/media/galleries',
            'thumbnail'=>true,
            'ps'=>'galleries',
        ),
    ];
?>
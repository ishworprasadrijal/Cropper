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
$base_url = 'http://'.$_SERVER['SERVER_NAME'].'/';
$docroot = '../';  /* absolute path from config.php */
return (object) array(      
      'hostname'=>'localhost',
      'db_user'=>'root',
      'db_password'=>'',
      'database_name'=>'components_cropper',
      'table_name'=>'medias',
      'base_url'=>$base_url,
      'docroot'=>$docroot,

  'default'=>(object) array(
            'naming'=>array('cropperModule-','timestamp'),
            'size'=>array(400,400),
            'directory'=>'assets/media/',
            'thumbnail'=>true,
            'ps'=>'default',
        ),
    'galleries'=>(object)array(
            'naming'=>array('gallery_image-','timestamp'),
            'size'=>array(400,400),
            'directory'=>$docroot.'assets/media/galleries',
            'thumbnail'=>true,
            'ps'=>'galleries',
        ),
    );
?>
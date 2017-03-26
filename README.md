# Cropper
Crop, resize and upload the minimized file. A fast, lightweight and complete application on PHP
# How to use?

#1. Configuration: (in config.php)

      $base_url = 'http://'.$_SERVER['SERVER_NAME'].'/';
      $docroot = '../';  /* absolute path from config.php to assets directory */
      'hostname'=>'localhost',
      'db_user'=>'database_user',
      'db_password'=>'database_password',
      'database_name'=>'your_database_name',
      'table_name'=>'medias',/*can be overwritten later*/
  
#2. Create a database with following properties :

    CREATE TABLE IF NOT EXISTS `medias` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `module_id` int(11) DEFAULT NULL,
      `directory` varchar(255) NOT NULL DEFAULT 'assets/media/',
      `type` varchar(100) DEFAULT NULL,
      `extension` varchar(100) DEFAULT NULL,
      `module_name` varchar(100) DEFAULT NULL,
      `title` varchar(255) DEFAULT NULL,
      `status` tinyint(1) NOT NULL DEFAULT '1',
      `created_at` int(11) DEFAULT NULL,
      `updated_at` int(11) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
   
  #3. Define Size to be cropped, directory to store images, and naming pattern of images
  
      'galleries'=>(object)array(
                'naming'=>array('Gallery_image-','timestamp'),
                'size'=>array(600,400),
                'directory'=>'assets/media/galleries',
                'thumbnail'=>true,
                'ps'=>'galleries',
            ),
#4. See <a href="http://ishworprasadrijal.com.np"> Demo here </a>.

# What is Cropper?
It is aimed to develop a image uploader plugin for php that allows you to define image size in the config file, and allow you to select region during uploading process and upload selected region of the image only to server due to which,
your all uploaded image have similar size throughout the project
you will be able to upload necessary section of image only

It will allow you to show preview before uploading and will upload in background so you can continue working on your page parallelly while cropper is uploading, resizing and so on.

This uses cropper.js to show selected region.


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
class GALLERY{
	public function __construct($preset='default') {
        $this->db = require_once('db.php');
        $this->db = new DB();
        $this->db->table_name ='medias';
    }

	public function get_setting($preset='default'){
		return $this->db->config->$preset;
	}

	public function get_settings($preset='default'){
		return json_encode($this->db->config->$preset);
	}

	public function getNames($module_name='default',$params=array()){
		$settings = $this->get_setting($module_name);
		$naming ='';
		foreach($settings->naming as $i=>$name){
			if($name=='timestamp'){
				$naming .= time(date("Y-m-d-H-i-s"));
			}elseif($name=='id'){
				$naming .= $params['id'];
			}elseif($name=='size'){
				$naming .='-'.$settings->size[0].'X'.$settings->size[1];
			}else{
				$naming .= $name;
			}
		}//endforeach
		return $naming;
	}

	public function get_list($preset='default'){
		$query = "SELECT * FROM `medias` WHERE `module_name` = '$preset' ORDER BY `created_at` DESC LIMIT 0,14";
		$data['galleries'] 	= 	$this->db->fetch($query);
		$data['preset']		=	$preset;
		$view = include('list.php');
		return $view;
	}


	public function upload(){
		$id 		= isset($_POST["id"]) ? $_POST['id'] : '';
		$preset 	= ($_POST["preset"]=='') ? 'default' : $_POST["preset"];
		list($ext, $data) 	= explode(';', $_POST["ftype"]);
		$settings 	= $this->get_setting($preset);
		$directory 	= $settings->directory;
		$path 		= $directory;
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $parameters = array('id'=>$id,'timestamp'=>$timestamp);
        $name 		= $this->getNames($preset,$parameters);
        $filename 		= $name.'.'.$ext;
        $full_filename 	= $path.'/'.$filename;
        $upload = $this->db->find($id); // find the record if exists */
        if($upload){
       			$this->db->update('title',$filename,$id);
       		}else{
				$upload = (object) array('module_id' => $id,
	        	'module_name' => $preset,
	        	'title'		=> $filename,
	        	'type' 		=> "data:image/jpeg",
	        	'status'  	=> 1,
	        	'directory'	=> $directory,
	        	'extension'	=> '.'.$ext
	        	);
	        	$upload = $this->db->create($upload);
       		}
	        $response['filename'] 		=$filename;
	        $response['full_filename'] 	=$full_filename;
	        $response['path'] 			= $path;
	        $response['upload_id'] 		= $upload->id;
	        $response['url'] 			= $directory.'/'.$filename;
	        $response['status'] ="success";
        return json_encode($response);
	}

	public function moreProcessing(){
		$id = $_POST['id'];
		$path = $_POST['path'];
		$image = $_POST['image'];
		$upload = $this->db->find($id);
		list($type, $data) 	= explode(';', $image);
        list(, $data)      	= explode(',', $data);
        list(, $ext)      	= explode(':', $type);
        list(, $extension)  = explode('/', $ext);
        $data 				= base64_decode($data);

		if($upload){
			$settings 	= $this->get_setting($upload->module_name);
			$settings->directory = $settings->directory;
			if($settings->ps!='default'){
				$width = $settings->size[0];
		       	$height = $settings->size[1];
			       	if(!file_exists($settings->directory)){
						mkdir($settings->directory, 0777);
					}
					if(file_put_contents($settings->directory.'/'.$upload->title, $data)){
			   			$full_filename = $settings->directory.'/'.$upload->title;
			   			$destination = $settings->directory.'/'.$upload->title;
			   			$this->crop_resize($full_filename,$destination,$width,$height);
			   			if(isset($settings->thumbnail)){
			   				if(!file_exists($settings->directory.'/thumbnails')){
								mkdir($settings->directory.'/thumbnails', 0777);
							}
			   				$destination = $settings->directory.'/thumbnails/'.$upload->title;
			   				$this->crop_resize($full_filename,$destination,120,80);
			   			}
					}
			}else{
				if(!file_exists($settings->directory)){
						mkdir($settings->directory, 0777,true);
					}
					if(file_put_contents($settings->directory.'/'.$upload->title, $data)){
			   			$full_filename = $settings->directory.'/thumbnails/'.$upload->title;
				    	if(isset($settings->thumbnail)){
			   				$destination = $settings->directory.'/thumbnails/'.$upload->title;
			   				$this->crop_resize($full_filename,$destination,120,80);
			   			}

				}

			}

		}
	}

	// resize image
	public function crop_resize($filename,$destination,$newwidth,$newheight){
		header('Content-Type: image/jpeg');
		list($width, $height) = getimagesize($filename);
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefromjpeg($filename);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagejpeg($thumb,$destination);
	}

	public function preview($gid=null){
		$id = isset($_POST['id']) ? $_POST['id'] : $gid;
		$data['croppedImage'] = isset($_POST['img']) ? $_POST['img'] : '';
		$data['gallery']=$this->db->find($id);
		$view = include('preview.php');
	}

	public function next($id=0){
		$preset = ($_POST['preset']=='')? 'default': $_POST['preset'];
		$data['galleries'] = $this->db->fetch('select * from medias');
		$data['preset']=$preset;
		$view = include('response.php');
	}

	public function crons(){
		$sql = 'select * from medias where 1';
		$recs = $this->db->fetch($sql);
		foreach($recs as $rec){
			unlink($rec->directory.'/'.$rec->title);
			unlink($rec->directory.'/thumbnails/'.$rec->title);
		}
		$sql = 'truncate medias';
		$this->db->execute($sql);
	}

	public function delete(){
		$base_url = $_SERVER['HTTP_REFERER'];
		$id = isset($_POST['id']) ? $_POST['id'] : null;
		if($id)
		$gallery = $this->db->find($id);
		try{
			$path = $base_url.'/'.$gallery->directory.'/'.$gallery->title;
			$file = file_exists($path) ? $path : null;
			if($file) unlink($file);

			$thumbnail = $base_url.'/'.$gallery->directory.'/thumbnails/'.$gallery->title;
			$tfile = file_exists($thumbnail) ? $thumbnail : null;
			if($tfile) unlink($tfile);

			$data['status']='success';
	        $data['message']='Successfully Removed #'.$id;
		}catch(exception $e){
	        $data['status']='error';
			$data['message'] = $e->getMessage();
		}
		$this->db->delete($id);
        return json_encode($data);
	}

}
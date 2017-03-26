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
class DB{
    public function __construct() {
        $this->config = require_once('config.php');
        $this->table = $this->table_name= $this->config->table_name;
    }

    public function connect(){
        return new mysqli($this->config->hostname,$this->config->db_user,$this->config->db_password,$this->config->database_name);
      }

    public function forge(){
      $query = "DESCRIBE `".$this->config->table_name."`";
      $columns = $this->fetch($query);
      if($columns){
        foreach($columns as $column){
          $fieldValue = in_array($column->Field,array('created_at','updated_at')) ? time() : $column->Default;
          (object) $col[$column->Field] = ($fieldValue ? $fieldValue : '');
        }
        return (object) $col;
      }else{
        return null;
      }
    }

    public function fetch($query){
      $connection = $this->connect();
      $result = $connection->query($query);
      if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $records[] = (object)$row;
        }
      }
      return isset($records) ? (object) $records : null;
    }

    public function execute($query){
        $connection = $this->connect();
        $result = $connection->query($query);
        return $this->find($connection->insert_id);
    }

    public function delete($id){
      $connection = $this->connect();
      $query ="DELETE FROM `".$this->table."` WHERE `id` = '".$id."'";
      $result = $connection->query($query);
      return $id;
    }

    public function find($id){
      $sql = 'SELECT * FROM `'.$this->table.'` WHERE `id` = '.$id.' LIMIT 0,1';
      $results =  $this->fetch($sql);
      if(count($results)>0){
      foreach($results as $r){
        return $r; //return one row only since fetch returns multiple objects        
      }
      }
    }

    public function create($params){
      $sql = 'INSERT INTO `'.$this->table.'` ';
      $columns = '';
      foreach($params as $key => $parameter){
        $columns[] = $key;
        $values[] = $parameter;
      }
      $sql .= '(`'.implode('`,`',$columns).'`)';
      $sql .= ' VALUES("'.implode('","',$values).'")';
      return $this->execute($sql);
    }

    public function update($params){
        $sql = 'UPDATE `'.$this->table.'` SET ';
        foreach($params as $key => $parameter){
          if($key != 'id'){
            $sql .= ' `'.$key.'` = "'.$parameter.'",';
          }else{
            $primary_key = $parameter;
          }
        }
        $sql = substr($sql,0,-1);
        $sql .= ' WHERE `id` = '.$primary_key;
        return $this->execute($sql)? $this->find($primary_key) : $this->find($primary_key);  
    }

    public function get_client_ip() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
         $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
    }
}
?>
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
    public function connect(){
        $this->db = include('config.php');
        return new mysqli($this->db->hostname,$this->db->db_user,$this->db->db_password,$this->db->database_name);
      }

    public function fetch($query){
      $connection = $this->connect();
      $result = $connection->query($query);
      if ($result->num_rows > 0) {
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

    public function find($id){
      $sql = 'select * from medias where id = '.$id.' limit 0,1';
      $results =  $this->fetch($sql);
      foreach($results as $r){
        return $r; //return one row only since fetch returns multiple objects        
      }
    }

    public function create($params){
      $sql = 'insert into medias ';
      $columns = '';
      foreach($params as $key => $parameter){
        $columns[] = $key;
        $values[] = $parameter;
      }
      $sql .= '(`'.implode('`,`',$columns).'`)';
      $sql .= ' values("'.implode('","',$values).'")';
      return $this->execute($sql);
    }

    public function update($params){
        $sql = 'update medias set ';
        foreach($params as $key => $parameter){
          if($key != 'id'){
            $sql .= ' `'.$key.'` = "'.$parameter.'",';
          }else{
            $primary_key = $parameter;
          }
        }
        $sql = substr($sql,0,-1);
        $sql .= ' where `id` = '.$primary_key;
        return $this->execute($sql)? $this->find($primary_key) : $this->find($primary_key);  
    }
}
?>
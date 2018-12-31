<?php

ini_set('display_errors','1');

class MysqlResultSet implements Iterator {

      const DATA_OBJECT            = 1;

      public function __construct($sql, $type, $handler) {

             $this->results = mysqli_query($handler, $sql);  
 
             if(!$this->results) {

                 throw new Exception(mysqli_error($handler));
             }

             $this->count = mysqli_num_rows($this->results);

             if($this->count == 0) {

                    throw new Exception("Number of rows == 0");

             }

             $this->type = $type;

             $this->query = $sql;
      }

      public function __destruct() {

             mysqli_free_result($this->results);
      }  

      function fetch() {

               if($this->count > 0) {

                  switch($this->type) {

                         case 1: $func = 'mysqli_fetch_object';  
                         break; 

                         default: $func = 'mysqli_fetch_object'; 
                         break;
                  }

                  $this->row = $func($this->results);

                  $this->index++;
               }           

      }	 

      public function rewind() {

             if($this->count > 0) {

                mysqli_data_seek($this->results, 0);                

                $this->index = -1;  

                $this->fetch();
 
             }   

      }

      public function valid() {

             return $this->row != false;
      }

      public function current() {

             return $this->row;
      }

      public function key() {

             return $this->index; 
      }

      public function next() {

             $this->fetch();
      }
}


interface IDatabase {

          public function connect($host,$user,$pass,$db);
          public function query($sql);
          public function fetch();
          public function iterate($sql,$type);
          public function close();
}

class Mysql implements IDatabase {

          public $handler;

          public function connect($host, $user, $pass, $db) {

                 $this->handler = mysqli_connect($host, $user, $pass, $db) or die('<p>Connection failed: <p>' . mysqli_connect_error());
          }

          public function __destruct() {

                 mysqli_close($this->handler);
          }

          public function query($sql) {

                 $this->resultset = mysqli_query($this->handler, $sql);

          }

          public function fetch() {

                 $arr = array();

                 while($row = mysqli_fetch_assoc($this->resultset)) {

                       $arr[] = $row;
                 }

                 return $arr;
          }

          public function iterate($sql, $data_type = MysqlResultSet::DATA_OBJECT) {

                 return new MysqlResultSet($sql, $data_type, $this->handler);
          }

          public function close() {

                 mysqli_close($this->handler);
          }

}

$obj = new Mysql();

$obj->connect("localhost","root","mobydick","dbname");

try {

    foreach($obj->iterate("SELECT * FROM tasks", 1) as $row) {

            echo$row->id.' - '.$row->task. '<br/>';
    }

} catch(Exception $exp) {

        echo$exp->getMessage();
}


?>

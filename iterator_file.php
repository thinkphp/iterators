<?php

    ini_set('display_errors', '1');

    class FileIterator {
 
          public $filename;
          public $handler;
 
          public function __construct( $fn ) {

                 $this->filename = $fn;
          }

          public function fetch() {

                 if(!file_exists($this->filename)) {

                    return false; 
                 }

                 if(!isset($this->handler)) {

                    $this->handler = fopen($this->filename, "r");  
                 }

                 if(!feof($this->handler)) {

                     return $line = fgets($this->handler, 4096);

                 } else {

                     fclose($this->handler);
  
                     return false; 
                 }
                 
          }
    }

    $filename = "core.ini";

    $obj = new FileIterator($filename);

    while(($buffer = $obj->fetch()) !== false) {

           echo$buffer."<br/>";

    } 


    class FileIterator2 implements Iterator {
 
          public $filename;

          public $handler;

          public function __construct($filename) {

                 if(!file_exists($filename)) return false;
                  
                 $this->filename = $filename;                
          }

          public function rewind() {

                 $this->handler = fopen($this->filename, "r");

                 $this->line = fgets($this->handler, 4096);  

                 $this->pos = 0;
          }

          public function valid() {

                 return !feof($this->handler);          
          }

          public function next() {

                 $this->line = fgets($this->handler, 4096);  

                 $this->pos++;
          }

          public function current() {

                 return $this->line;
          }

          public function key() {

                 return $this->pos;  
          }   

    }

    echo"<hr>";

    $obj = new FileIterator2($filename);

    foreach($obj as $file) {

            echo$file."<br/>";  
    }  

    if(isset($_GET['view-source'])) {

        highlight_file($_SERVER['SCRIPT_FILENAME']);
    } 
?>

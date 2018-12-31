<?php

    ini_set('display_errors','1'); 

    class IteratorDir {

          public $dir;

          private $handler;

          public function __construct($dir) {

                 $this->dir = $dir;
          }

          function fetch() {

                  if(!isset($this->handler)) {

                     $this->handler = dir($this->dir);
                  }  

                  if(($entry = $this->handler->read())!== false) {

                      return $entry;
  
                  } else {

                    $this->handler->close(); 

                    $this->handler = NULL;  
                    
                    return false;
                  }

          }
    } 

    $files = new IteratorDir(".");

    echo"<ul>";   

    while(($file = $files->fetch()) !== false) {

          echo"<li>".$file."</li>";
    }

    echo"</ul>";

    class IteratorDir2 implements Iterator {

          public $dir;

          private $handler;
 
          public function __construct($dir) {

                 $this->dir = $dir;  
          }    

          public function __destruct() {

                    $this->handler->close();
          }

          public function rewind() {

                 $this->handler = dir($this->dir);           

                 $this->entry = $this->handler->read();
          }

          public function valid() {

                 return $this->entry !== false;
          }

          public function next() {

                 $this->entry = $this->handler->read();   
          }

          public function key() {

                 return $this->entry;  
          }

          public function current() {


                 return $this->entry;
          }
    }

    $files = new IteratorDir2(".");

    echo"<ul>";   

    foreach($files as $key=>$file) {

          echo"<li>".$file."</li>";
    }

    echo"</ul>";


?>

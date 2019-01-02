<?php

ini_set('display_errors','1');

$colors = array("green","yellow","white","blue","lightblue","lightgreen","gray");

class IteratorColors {

      public $_colors = array();
 
      public function __construct($colors) {

             $this->_colors = $colors;
      }

      public function fetch() {

             $color = each($this->_colors);

             if($color) {

                return $color['value'];  

             } else {
    
               reset($this->_colors);

               return false;      
 
             }
      }
}

class ColorsIterator implements Iterator {

      public $_colors;
 
      public function __construct($colors) {

             $this->_colors = $colors;
      }  

      public function rewind() {

             $this->count = count($this->_colors);

             $this->pos = 0; 
      }

      public function valid() {

             return $this->pos < $this->count;
      }        

      public function current() {

             return $this->_colors[$this->pos];
      }

      public function key() {

             return $this->pos;   
      }

 
      public function next() {

             return $this->pos++; 
      }
}

//first method
foreach($colors as $k => $v) {
 
        echo$k. " - ". $v . "<br/>";
}

//second method
$it = new IteratorColors($colors);

while(false !== ($color = $it->fetch()) ) {

      echo$color. '<br/>';  
}

//third method
$obj = new ColorsIterator($colors);

foreach($obj as $c) {

        echo$c. ' ';
}

if(isset($_GET['view-source'])) {

   highlight_file($_SERVER['SCRIPT_FILENAME']);
}

?>

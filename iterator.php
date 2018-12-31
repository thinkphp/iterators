
<style>
ol,ul{font-size: 23px}
</style>
<?php 

    ini_set('display_errors', '1');
   
    $phrase = "I see, the life almost like one long, university, that I never had everday, I am learning something new";

    echo"<h2>".$phrase."</h2>";
 
    //solution 1.
    //using each - return the current key and value pair from an array and advance the array cursor.
    class Phrase {

          public $vector_phrase;
 
          public function __construct($phrase) {

                 $this->vector_phrase = explode(" ",$phrase); 
          }

          public function fetch() {
                  
                 $val = each($this->vector_phrase);

                  if($val) {

                     $v = $val['value'];

                     $re = '/,/m';

                     preg_match_all($re, $v, $matches, PREG_SET_ORDER, 0);

                     if($matches) {

                        $v = str_replace(',','',$v);     
                     }

                     return $v;

                  } else { reset($this->vector_phrase); return false; }
          }
    }  

    echo"<br/><ul>"; 

    $obj = new Phrase($phrase); 

    while(($word = $obj->fetch()) != false) {

           echo"<li>".$word."</li>";   

    }
    echo"</ul>"; 

    //solution 2.
    //foreach with an iterator
    //Iterator::current - return the current element
    //Iterator::key     - return the key of the current element
    //Iterator::rewind  - rewind the cursor to the first element
    //Iterator::next    - move farward the cursor to the next element
    //Iterator::valid   - checks if current position if valid
    /*
      Order of operations when using a loop foreach:

            1. Before the first iteration of the loop, Iterator::rewind is called
            2. Before each iteration of the loop, Iterator::valid is called
            3. If Iterator::valid returns false, then the loop is terminated.
            4. if Iterator::valid returns true, then Iterator::current() and Iterator::key() are called.
            5. The loop body is evaluated.
            6. After each iteration of the loop, Iterator::next is called and we repeat from the step 2 above.  

            This is equivalent to:

            $it->rewind();
            while($it->valid()) {
                  $key = $it->key();
                  $val = $it->current();

                  //...the code goes here  
                  $it->next();
            }
    */   
 
    class Frase implements Iterator {

          public $vector;

          public function __construct($phrase) {

                 $this->vector = explode(" ", $phrase);

                 $this->len = count($this->vector);    
          }

        public function rewind() {

                 $this->key = 0; 
          }
  

        public function current() {

                 $v = $this->vector[ $this->key ]; 

                     $re = '/,/m';

                     preg_match_all($re, $v, $matches, PREG_SET_ORDER, 0);

                     if($matches) {

                        $v = str_replace(',','',$v);     
                     }

                 return $v;
        }

        public function key() {

                 return $this->key;   
        }

        public function next() {

                 return $this->key++; 
        }

        public function valid() {

                 return $this->key < $this->len;
        }
    }

    $obj = new Frase($phrase);    

    echo'<ol>'; 

    foreach($obj as $k=>$v) {

            echo'<li>' . $v . '</li>';
    }  

    echo'</ul>'; 

    $obj2 = new Frase($phrase);    

    $obj2->rewind();

    while($obj2->valid()) {

         echo$obj2->current(). " ";  

         $obj2->next();
    }   

    if(isset($_GET['view-source'])) {

             highlight_file($_SERVER['SCRIPT_FILENAME']);
    }
?>

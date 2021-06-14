<?php 

$json = file_get_contents('myAutoload/autoload.json');
$array = json_decode($json, true);


class Converter {

    
    public static $filesname = [];

    public static $autoloader = [];
    
    public function __construct($array) {
    $this->json = $array;
    }
    
    private function createArray($array) {

        foreach( $array as $key => $val ) {
            self::$autoloader[] = [];
            self::$filesname[] = $key;
        }

    }

    public function readingCatalogs($array) {
    
    $this->createArray($array);

    $count = 0;

    function readingSubCatalogs($catalog, &$suitable) {
     $url = $catalog . '/';

     $current = [];

     if( ( $handle = opendir($url) ) !== false ) {

        while( $entry = readdir($handle) ) {
             if( !is_dir($entry) && strpos($entry, '.php') !== false) {
             $suitable[] = $url . $entry;
             }
             else if(!is_dir($entry) ) {
             $file_ext = pathinfo($entry, PATHINFO_EXTENSION);

             if( $file_ext === '') {
                array_push( $current , $url . $entry );
             }
            
             }
        }
       closedir($handle);
     }
     
     foreach( $current as $dir ) {
        $firstDir = array_shift($current);
        readingSubCatalogs($firstDir, $suitable);
     } 
    }

    foreach( $array as $val ) {
        $url = $val;
        readingSubCatalogs($url,self::$autoloader[$count]);
        $count++;
    }

    

    }


    public function combat() {
        return array_combine(self::$filesname, self::$autoloader);       
    }

    public function broadcast($file) {
      $readyArr = $this->combat();
      foreach( $readyArr as $key => $val ) {
        if( $file === $key ) {
           foreach( $val as $url ) {
            require_once $url;
           }
        }
      }
    }


}

$autoload = new Converter($array);
$autoload->readingCatalogs($array);


?>



<?php 


namespace includes\Workers;
use includes\Finders\Finder;

class Worker extends Finder {
  
  protected $xuy  = 5;

	protected static $workers = [];

	public static function create($worker) {
	
      $check = true;
      $key = ['Name','Email','Age','Profession'];

      foreach($worker as $work ) {
       if( $work === '' ) {
     	$check = false;
     	break;
       }
      }

      $c = array_combine($key, $worker);

    if( $check ) {
     $c['register_time'] = date("d/m/Y/H/i");
     array_push( self::$workers, $c ); 
    }else{
     array_push( self::$workers, 'Данные не верны!' ); 
    }

	}

	public static function all() {
     
    $all_workers = [];

    foreach (self::$workers as $value) {
    	$all_workers[] = $value;
    }


    $array = [
    'workers_count' => count(self::$workers),
    'all_workers' => $all_workers,
    ];

    return $array;

	} 

	public static function save() {
    $fp = fopen('info/info.txt', 'w');

    foreach (self::$workers as $value) {
    	
      if( gettype($value) === 'string' ) {
    	fwrite($fp, $value . "\n\n" );
        continue;
      }

    	foreach ($value as $key => $val) {
         $text = "$key: $val\n";
    	 fwrite($fp, $text );

    	}

    fwrite($fp, "\n");

    }

    fclose($fp);

	}
}

?>
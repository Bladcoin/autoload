<?php 

namespace includes\Finders;


class Finder {
    
    public static $email;

	public static function find() {

	  foreach( static::$workers as $worker ) {
        if( gettype($worker) === 'array') {
           switch ($worker['Email']) {
           	case self::$email:
           		print_r($worker);
           		break;
           	default:
           		break;
           }
        }
	  }

	}
}

?>
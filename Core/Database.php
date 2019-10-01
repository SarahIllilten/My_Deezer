<?php

class Database {
	private static $instance = NULL;
	
	private function __construct() {}
    private function __clone() {}

	public static function connect() {
		if (!isset(self::$instance)) {
			$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;
			$options = array(
		    	PDO::ATTR_PERSISTENT => true, 
		    	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);

            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);    
        }
        return self::$instance;
    }
}

?>
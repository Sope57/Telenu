<?php

	function db_connect() {

	    static $conn;

	    if(!isset($conn)) {
	        $config = parse_ini_file(dirname($_SERVER['DOCUMENT_ROOT']).'/teleconfig.ini'); 
	        $conn = new PDO('mysql:dbname='.$config['dbname'].';host=96.9.62.147', $config['username'], $config['password']);
	    }

	    return $conn;
	}

?>
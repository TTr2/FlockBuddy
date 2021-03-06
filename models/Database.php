<?php

class Database {

	protected static $instance = null;
	protected $dbh;

	public static function getInstance() {
		$username = 'flockbuddy'; // connection info for helios.csesalford.com
		$password = 'flockbuddy'; // change this to the password provided                                
//                $host = "http://46.101.60.51"; // Do we want remote connection?
		$host = 'localhost';
		$dbname = 'flockbuddy';

		if (self::$instance === null) { //checks if the object exists
			// creates new instance if not, sending in connection info
			self::$instance = new self($username, $password, $host, $dbname);
		}

		return self::$instance;
	}

	private function __construct($username, $password, $host, $database) {
            try {
                // creates the database handler with connection info
                $this->dbh = new PDO("mysql:host=$host;dbname=$database",
                                    $username, $password); 
            } catch (PDOException $e) {
                echo($e->getMessage());
            }
	}

	public function getDbh() {
		return $this->dbh; // returns the database handler to be used elsewhere
	}

	public function __destruct() {
		$this->dbh = null; // destroys the database handler when no longer needed
	}
}

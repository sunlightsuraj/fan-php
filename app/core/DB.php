<?php
/**
 * User: suraj
 * Date: 1/21/15
 * Time: 9:58 AM
 */

 class DB
 {
	 private static  $conn = null;
	 private static $objDB = null;
	 private static $server = '';
	 private static $user = '';
	 private static $pass = '';
	 private static $db = '';
	 private $error = '';

	 /**
	  * constructor, initialize configuration
	  */
	 public function __construct() {
		 static::$server = server;
		 static::$user = user;
		 static::$pass = password;
		 static::$db = database;
	 }

	 /**
	  * @param $dbext
	  * @return mixed
	  */
	 public static function getConnection($dbext) {
		 if(static::$objDB == null) {
			 static::$objDB = new DB();
		 }

		 if(method_exists(static::$objDB,$dbext."_conn")){
			 $func = $dbext."_conn";
			 static::$objDB->$func();
		 }

		 return static::$conn;
	 }

	 /**
	  * method to create mysqli connection
	  */
	 public static function mysqli_conn() {
		 try{
			 if(static::$conn == null) {
				 static::$conn = new mysqli(static::$server, static::$user, static::$pass, static::$db);
				 if (mysqli_connect_errno()) {
					 throw new Exception("Failed to connect: ". mysqli_connect_error());
					 //exit();
				 }
			 }
		 }catch (Exception $e){
			 static::$objDB->setError($e->getMessage());
		 }
	 }

	 /**
	  * pdo connection function
	  */
	 public static function pdo_conn() {
		 $dbhost = static::$server;
		 $dbname = static::$db;
		 $dbuser = static::$user;
		 $dbpass = static::$pass;

		 try {
			 if(static::$conn == null) {
				 static::$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass,[PDO::ATTR_PERSISTENT => true]);
				 static::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			 }
		 } catch (PDOException $e) {
			 static::$objDB->setError($e->getMessage());
			 die(static::$objDB->getError());
		 }
	 }

	 public static function startTransaction() {
		 DB::getConnection(db_extension)->beginTransaction();
	 }

	 public static function commit() {
		 DB::getConnection(db_extension)->commit();
	 }

	 public static function rollback() {
		 DB::getConnection(db_extension)->rollback();
	 }

	 /**
	  * function to set error
	  * @param $error
	  */
	 protected function setError($error) {
		 $this->error = $error;
	 }

	 public function getError() {
		 return $this->error;
	 }
 }

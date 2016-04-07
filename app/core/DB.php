<?php
/**
 * User: suraj
 * Date: 1/21/15
 * Time: 9:58 AM
 */

 class DB
 {
     private  $conn;
     private $server;
     private $user;
     private $pass;
     private $db;
     private $error;

     /**
      * constructor, initialize configuration
      */
     public function __construct() {
         $this->server = server;
         $this->user = user;
         $this->pass = password;
         $this->db = database;
     }

     /**
      * @param $dbext
      * @return mixed
      */
     public function getConnection($dbext) {
         if(method_exists($this,$dbext."_conn")){
             $func = $dbext."_conn";
             $this->$func();
         }

         return $this->conn;
     }

     /**
      * method to create mysqli connection
      */
     public function mysqli_conn(){
         try{
             $this->conn = new mysqli($this->server, $this->user, $this->pass, $this->db);
             if (mysqli_connect_errno()) {
                 throw new Exception("Failed to connect: ". mysqli_connect_error());
                 //exit();
             }
         }catch (Exception $e){
             $this->setError($e->getMessage());
         }
     }

     /**
      * pdo connection function
      */
     public function pdo_conn() {
         $dbhost = $this->server;
         $dbname = $this->db;
         $dbuser = $this->user;
         $dbpass = $this->pass;

         try{
             $this->conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass,[PDO::ATTR_PERSISTENT => true]);
             $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         }catch (Exception $e){
             $this->setError($e->getMessage());
         }
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

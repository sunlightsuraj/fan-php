<?php
/**
 * User: suraj
 * Date: 1/18/15
 * Time: 7:16 PM
 */

class User extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function logInUser($params) {
		try {
			$sql = "select *from user where email = ? and password = ?";
			//$params = [$email,$password];
			$result = $this->fetchAllRecords($sql,$params);
			if($result) {
				$data = ['status'=>true,'result'=>$result[0]];
			} else {
				throw new Exception("Invalid Email or Password");
			}
		} catch(PDOException $e) {
			$this->setError($e->getMessage());
			$data = ['status'=>false];
		} catch(Exception $e) {
			$this->setError($e->getMessage());
			$data = ['status'=>false];
		} finally {
			return $data;
		}
	}

	public function checkEmail($params) {
		try {
			$sql = "select *from user where email = ?";
			//$params = [$email];
			$result = $this->fetchRecord($sql, $params);
			if($result) {
				throw new Exception("Email already exists");
			} else {
				$data = ['status'=>true];
			}
		} catch(PDOException $e) {
			$this->setError($e->getMessage());
			$data = ['status'=>false];
		} catch(Exception $e) {
			$this->setError($e->getMessage());
			$data = ['status'=>false];
		} finally {
			return $data;
		}
	}

	public function registerUser($params) {
		try{
			$sql = "insert into user(firstname,lastname,email,password) value(?,?,?,?)";
			$result = $this->dump($sql, $params);
			if($result) {
				$data = ['status'=>true,'userId'=>$this->conn->lastInsertId()];
			} else {
				throw new Exception("Error Processing Request", 1);
			}
		} catch(PDOException $e) {
			$this->setError($e->getMessage());
			$data = ['status'=>false];
		} catch(Exception $e) {
			$this->setError($e->getMessage());
			$data = ['status'=>false];
		} finally {
			return $data;
		}
	}
}

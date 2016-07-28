<?php
/**
 * User: suraj
 * Date: 8/27/15
 * Time: 10:03 AM
 */

/**
 *
 */
class Model {
	protected $db;
	protected static $conn = null;
	protected $error;

	function __construct() {
		//$this->db = new DB();                            // creating database instance
		if(static::$conn == null) {
			static::$conn = DB::getConnection(db_extension);    // get a pdo connection, use 'mysqli' for mysqli connection
		}
	}

	protected function fetchAllRecords($sql, $params) {
		$qry = static::$conn->prepare($sql);
		$qry->execute($params);
		if($qry->rowCount()) {
			//fetch user Information
			$result = $qry->fetchAll(PDO::FETCH_ASSOC);
			$qry = null;
			return $result;
		} else {
			$qry = null;
			return false;
		}
	}

	protected function fetchRecord($sql, $params) {
		$qry = static::$conn->prepare($sql);
		$qry->execute($params);
		if($qry->rowCount()) {
			$result = $qry->fetch(PDO::FETCH_ASSOC);
			$qry = null;
			return $result;
		} else {
			$qry = null;
			return false;
		}
	}

	protected function insert($sql, $params) {
		$qry = static::$conn->prepare($sql);
		$exec = $qry->execute($params);
		$qry = null;
		if($exec) {
			$id = static::$conn->lastInsertId();
			return $id;
		} else {
			return false;
		}
	}

	protected function dump($sql, $params) {
		$qry = static::$conn->prepare($sql);
		$exec = $qry->execute($params);
		$qry = null;
		if($exec)
			return true;
		else
			return false;
	}

	protected function setError($error = '') {
		$this->error = $error;
	}

	public function getError() {
		return $this->error;
	}
}

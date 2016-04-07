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
  protected $conn;
  protected $error;

  function __construct() {
    $this->db = new DB();                            // creating database instance
    $this->conn = $this->db->getConnection('pdo');    // get a pdo connection, use 'mysqli' for mysqli connection
  }

  protected function fetchAllRecords($sql, $params) {
    $qry = $this->conn->prepare($sql);
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
    $qry = $this->conn->prepare($sql);
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

  protected function dump($sql, $params) {
    $qry = $this->conn->prepare($sql);
    $qry->execute($params);
    $qry = null;
    return true;
  }

  protected function setError($error = '') {
    $this->error = $error;
  }

  public function getError() {
    return $this->error;
  }
}

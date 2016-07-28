<?php
/**
 * User: suraj
 * Date: 1/14/15
 * Time: 7:24 PM
 *
 * Core Controller
 * allows access method like views and models
 */

class Controller
{
    protected $error;
    protected $config;
    protected $isLoggedIn = 0;

    function __construct() {
      $this->lib = new Library();

      if(Session::sessionGet('sess_stat') != null) {
        $this->isLoggedIn = 1;
      }
    }

    public function model($model) {
        require_once 'app/models/'.$model.'.php';
        return new $model();
    }

    public function view($view, $data = []) {
        require_once 'app/views/'.$view.'.php';
    }

	public function redirect($path) {
		header("location: ".site_url.$path);
	}

	protected function setError($error) {
		$this->error = $error;
	}

	protected function getError() {
		return $this->error;
	}
}

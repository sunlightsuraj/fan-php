<?php
/**
 * User: suraj
 * Date: 1/14/15
 * Time: 8:12 PM
 */

class Home extends Controller
{
    public function __construct() {
      parent::__construct();
      $user = $this->model('User');
    }

    public function index($name = '') {
        $this->view('common/head', ['title' => 'MVC Demo']);

        if($this->isLoggedIn) {
          $fullName = Session::sessionGet('sess_fname').' '.Session::sessionGet('sess_lname');
          $this->view('home/home', ['isLoggedIn' => true,'fullName' => $fullName]);
        } else {
          $this->view('home/home', ['isLoggedIn' => false]);
        }

        $this->view('common/foot');
    }
}

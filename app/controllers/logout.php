<?php
/**
 * User: suraj
 * Date: 1/21/15
 * Time: 12:15 PM
 */

class LogOut extends Controller
{
    function __construct() {
      parent::__construct();
      if($this->isLoggedIn) {
        Session::sessionDestroy();
      }
      header("location: ".site_url);
    }

    public function index($name = '') {
      header("location: ".site_url);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: suraj
 * Date: 12/20/17
 * Time: 5:19 PM
 */

class Home extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo 'admin';
    }
}
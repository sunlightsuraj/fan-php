<?php
/**
 * User: suraj
 * Date: 1/14/15
 * Time: 7:19 PM
 *
 * Its the bootstrap file of our mvc
 */

require_once('app/init.php');

Session::init();

$app = new App();

?>

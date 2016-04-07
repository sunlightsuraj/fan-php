<?php
/**
 * User: suraj
 * Date: 1/18/15
 * Time: 7:22 PM
 */

?>

<div class="container">
  <div class="panel panel-default" style="width: 500px; margin: auto; margin-top:50px;">
    <div class="panel-body">
      <div class="row-fluid">
        <h3 class="text-center text-info">
          Hello World!
        </h3>
        <p class="text-center">
          This is custom mvc test.
        </p>
      </div>
      <div class="row-fluid">
        <?php
        if($data['isLoggedIn'] != 0) {
          ?>
          You are logged in as <?php echo $data['fullName']; ?>.
          <br />
          <a href="<?php echo site_url;?>logout">Logout</a>
          <?php
        } else {
          ?>
          <a href="<?php echo site_url; ?>login">Login</a>
          <br />
          <a href="<?php echo site_url; ?>register">Register</a>
          <?php
        }
        ?>
      </div>
    </div>
  </div>

</div>

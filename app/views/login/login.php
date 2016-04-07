<?php
/**
 * User: suraj
 * Date: 1/20/15
 * Time: 7:27 PM
 */
?>

<div class="container">
    <div class="panel panel-default" style="width: 500px; margin: auto; margin-top: 150px">
        <div class="panel-body">
            <form method="post" action="<?php echo site_url?>login">
                <div class="form-group input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                    </div>
                    <input type="text" class="form-control" name="login_email" placeholder="email">
                </div>
                <div class="form-group input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-lock"></span>
                    </div>
                    <input type="password" class="form-control" name="login_pass" placeholder="Password">
                </div>
                <?php
                if(isset($data['error']) && !empty($data['error'])) {
                  ?>
                  <p class="text-danger"><?php echo $data['error']; ?></p>
                  <?php
                }
                ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
                <div class="form-group">
                  <h4 class="text-center text-info">or</h4>
                  <a href="<?php echo site_url; ?>register" class="btn btn-success btn-block">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
    <br />
    <p class="text-center text-info">
      <a href="<?php echo site_url; ?>">Home</a>
    </p>
</div>

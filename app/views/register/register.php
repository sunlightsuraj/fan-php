<?php
/**
 * User: suraj
 * Date: 1/21/15
 * Time: 12:31 PM
 */

?>

<div class="container">
    <div class="panel panel-default" style="width: 500px; margin: auto; margin-top:50px;">
        <div class="panel-body">
            <form method="post" action="register">
                <input type="hidden" name="register" value="1">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="firstname" placeholder="First Name" />
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lastname" placeholder="Last Name" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="pass" placeholder="Password" />
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="c_pass" placeholder="Confirm Password" />
                </div>
                <?php
                if(isset($data['error']) && !empty($data['error'])) {
                    ?>
                    <p class="text-danger"><?php echo $data['error']; ?></p>
                    <?php
                }
                ?>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
                <div class="form-group">
                    <h4 class="text-center text-info">or</h4>
                    <a href="<?php echo site_url;?>login" class="btn btn-success btn-block">Login</a>
                </div>
            </form>
        </div>
    </div>
    <br />
    <p class="text-center text-info">
        <a href="<?php echo site_url; ?>">Home</a>
    </p>
</div>

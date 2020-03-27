<!-- Login form -->
<form class="col-md-4" action="#" method="post">
    <div class="card mb-0  login-card">
        <div class="card-body">
            <div class="text-center mb-3">
                <a href="<?php echo base_url() ?>">
                    <div class=" p-picture"></div>
                </a>
                <h5 class="mb-0" style="color:black">Enter New Password</h5>
                <span class="d-block text-muted"
                      style="color:black">Please enter your new password</span>
            </div>
            <?php get_msg(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="password" id="m_name" name="password" class="form-control empty required"
                               placeholder="New Password">
                        <span id="divor_m_name" style="color:red;"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="password" id="m_name" name="password" class="form-control empty required"
                               placeholder="Confirm Password">
                        <span id="divor_m_name" style="color:red;"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Reset<i
                        class="icon-circle-right2 ml-2"></i></button>
            </div>
			<?PHP include "powered.php"; ?>
        </div>
    </div>
</form>
<!-- /login form -->


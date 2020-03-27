<!-- Login form -->
<form class="col-md-4" action="#" method="post">
    <div class="card mb-0  login-card">
        <div class="card-body">
            <div class="text-center mb-3">
                <a href="<?php echo base_url() ?>">
                    <div class=" p-picture"></div>
                </a>
                <h5 class="mb-0" style="color:black">Enter OTP</h5>
                <span class="d-block text-muted"
                      style="color:black">Please enter OTP sent on your Mobile Number</span>
            </div>

            <?php get_msg(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" id="m_name" name="otp" class="form-control empty required"
                               placeholder="OTP">
                        <span id="divor_m_name" style="color:red;"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Proceed<i
                        class="icon-circle-right2 ml-2"></i></button>
            </div>
			<?PHP include "powered.php"; ?>
        </div>
    </div>
</form>
<!-- /login form -->


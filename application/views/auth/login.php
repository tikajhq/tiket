<div class="page login-page">
    <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
            <div class="row">
                <!-- Logo & Information Panel-->
                <div class="col-lg-6">
                    <div class="info d-flex align-items-center">
                        <div class="content m-auto">
                            <div class="logo">
                                <h1><?= PRODUCT_NAME ?></h1>
                            </div>
                            <p></p>
                        </div>
                    </div>
                </div>
                <!-- Form Panel    -->
                <div class="col-lg-6 bg-white">
                    <div class="form d-flex align-items-center">
                        <div class="content">
                            <form method="post" class="form-validate" action="">
                                <div class="form-group">
                                    <input id="login-username" type="text" name="username" required data-msg="Please enter your username" class="input-material">
                                    <label for="login-username" class="label-material">User Name</label>
                                </div>
                                <div class="form-group">
                                    <input id="login-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                                    <label for="login-password" class="label-material">Password</label>
                                </div>
                                <button type="submit" id="login" href="" class="btn btn-primary">Login</button>
                                <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                            </form>
                            <div>
                                <?= get_msg(); ?>
                            </div>
                            <!-- <a href="#" class="forgot-pass">Forgot Password?</a><br><small>Do not have an account? </small><a href="register.html" class="signup">Signup</a> -->
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights text-center text-dark">
        <p>Powered by <a href="<?= DEV_COMPANY_URL ?>" class="external"><img src="/assets/img/logo-red.png" width="65" alt="TIKAJ"></a></p>
    </div>
</div>
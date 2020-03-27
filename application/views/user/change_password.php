<!-- Dashboard Counts Section-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><i class="fa fa-lock"></i> <?= $title ?></h3>
                    </div>
                    <div class="card-body">
                    <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">Current Password</div>
                                <div class="col-md-4"><input type="password" id="current_password" class="form-control"></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">New Password</div>
                                <div class="col-md-4"><input type="password" id="new_password" class="form-control"></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">Confirm New Password</div>
                                <div class="col-md-4"><input type="password" id="confirm_password" class="form-control" ></div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="form group ">
                                <a href="<?= BASE_URL ?>user/profile" class="btn btn-secondary pull-left mr-3"><i class="fa fa-arrow-left"></i> Back to profile</a>
                                <button href="" class="btn btn-success pull-left" id="change_password">Update Password</button>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="col-md-12 p-0">
                            <div class="row">
                                <div class="col-md-12" id="cp_result"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
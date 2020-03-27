<!-- Dashboard Counts Section-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><i class="fa fa-user"></i> <?= $title ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 p-2">
                            <div class="row ">
                                <div class="col-md-3">Name</div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value=" <?= $user_details['name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3">Email</div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value=" <?= $user_details['email'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3">Mobile</div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value=" <?= $user_details['mobile'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3">Username</div>
                                <div class="col-md-9"><?= $user_details['username'] ?></div>
                            </div>
                        </div>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-3">User Type</div>
                                <div class="col-md-9"><span class="user-type" data-value="<?= $user_details['type'] ?>"></span></div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 p-2">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <button class="btn btn-success pull-left" id="update_profile">Update Profile</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
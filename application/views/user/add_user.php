<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><?= $title ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label">Name</label>
                                        <input type="text" required id="name" placeholder="Name" class="form-control">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label class="form-control-label">Email ID</label>
                                        <input type="email" required id="email" placeholder="email@domain.com" class="form-control">
                                    </div>
                                    <div class="form-group  col-md-6">
                                        <label class="form-control-label">Mobile</label>
                                        <input type="text" id="mobile" placeholder="9999999999" class="form-control">
                                    </div>
                                   
                                    <div class="form-group  col-md-6">
                                        <label class="form-control-label">User Type</label>
                                        <select id="type" class="form-control">
                                            <option value=""> - Select -</option>
                                            <option value="10">User</option>
                                            <option value="60">Agent</option>
                                            <option value="80">Manager</option>
                                        </select>
                                    </div>   
                                    <div class="form-group  col-md-6">
                                        <label class="form-control-label">Password</label>
                                        <input type="password" id="password"  class="form-control">
                                    </div>    
                                    <div class="form-group col-md-12 p-3">
                                        <input type="submit" id="add_user" value="Add User" class="btn btn-primary pull-right">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 1em;">
                            <div class="col-md-12" id="au_result">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
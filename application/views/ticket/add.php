<div class="offset-md-4 col-md-4">
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <div class="caption">
                <h5 class="card-title"><i class="icon icon-ticket"></i> Create Ticket</h5>
            </div>
        </div>
        <div class="container-fluid" id="msg">
            <div class="portlet-body form">
                <form class="form-horizontal" method="post"
                      action="<?php echo base_url(); ?>index.php/user/change_password">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class=" control-label">Category</label>
                                    <select type="text" required class="form-control form-control-select2 select2-hidden-accessible"
                                            name="ticketcategory" id="ticketcategory"  aria-hidden="true">
                                        <option value="">Select Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class=" control-label">Subject</label>
                                    <input type="text" required="" class="form-control blank" name="ticketsubject"
                                           id="ticketsubject"
                                           placeholder="Enter Subject" required value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class=" control-label">Upload Image</label><code>*</code>
                                    <input type="file" name="ticketimage" id="ticketimage"
                                           class="form-input-styled" data-fouc>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class=" control-label">Your Message</label>
                                    <textarea name="ticketmessage" id="ticketmessage" minlength="5" maxlength="50"
                                              class="form-control empty required" required></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions" align="middle">
                            <button type="reset" class="btn btn-danger legitRipple">Reset</button>
                            <input type="submit" class="btn btn-primary legitRipple legitRipple-empty" value="Submit">
                            &nbsp;&nbsp;
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

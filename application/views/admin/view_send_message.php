<!-- xPAGE HEADER -->
<!-- BEGIN PAGE TITLE-->
<!-- xPAGE   Master
    <small>Send Message</small>
 -->
<!-- END PAGE TITLE-->
<div class="col-md-12 px-3">
    <?php get_msg();?>
<div class="row">
<div class="col-md-6 ">
    <div class="card ">
        <div class="card-header header-elements-inline">
            <div class="caption">
             
                <h5 class="card-title">   <i class="icon icon-search4"></i>Search Member</h5>
            </div>

        </div>

        <div class="card-body">
            <form class="form-horizontal" method="post"
                  action="<?php echo base_url(); ?>index.php/master/view_send_message">

                <div class="form-group" id="isplan">
                    <label class="col-md-12 ">Member Without Plan &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"
                 id="ckplan0"
                 name="ckplan0"
                 value="0"
                 onclick="withoutplan(0)"/>
                    </label>
                    <label class="col-md-12 ">Member With Any Plan &nbsp;&nbsp;&nbsp;<input type="checkbox"
                      id="ckplan"
                      name="ckplan"
                      value="1"
                      onclick="withoutplan(1)"/>
                    </label>
                </div>
                <div class="form-group" id="plan">
                    <label class="col-md-12 "><b>Member With Plan</b> </label>
                    <div class="col-md-12">
                        <?php $plan = 0;
                        foreach ($plan_type->result() AS $rowpln) {
                            $plan++; ?> <label class="col-md-4"><input type="checkbox"
                           id="ckplan<?php echo $plan; ?>"
                           name="ckplan<?php echo $plan; ?>"
                           onclick="withplan()"
                           value="<?php echo $rowpln->p_plantype_id; ?>"/> <?php echo $rowpln->p_planname; ?>
                            </label><?php } ?>
                    </div>
                </div>
                <input type="hidden" id="txtplan" name="txtplan"/>
                <input type="hidden" id="txtplantype" name="txtplantype"/>
                <div class="footer m-auto" id="hide" style="display:block" align="middle">
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <input type="submit" class="btn btn-primary" value="Search">
                    &nbsp;&nbsp;
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-6 d-flex">
    <div class="card flex-fill">
        <div class="card-header header-elements-inline">
            <div class="caption">
              
                <h5 class="card-title">  <i class="icon icon-envelop
"></i>Message</h5>
            </div>

        </div>

        <div class="card-body">
            <form class="form-horizontal" method="post" onsubmit="return check4()"
                  action="<?php echo base_url(); ?>index.php/master/send_sms_user">

                <div class="form-group">
                    <label class="col-md-12 ">Mobile Numbers</label>
                    <div class="col-md-12">
                        <input type="text" id="txtquid" name="txtquid" class="form-control" value=""/>
                        <span id="divtxtquid" style="color:red;"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 ">Enter Message & send it to selected members</label>
                    <div class="col-md-12">
                        <textarea class="form-control" id="txtmessage" name="txtmessage"></textarea>
                        <span id="divtxtmessage" style="color:red;"></span>
                    </div>
                </div>
                <div class="footer" id="hide" style="display:block" align="middle">
                  <button type="reset" class="btn btn-danger">Reset</button>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    &nbsp;&nbsp;
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<div class="col-md-12">
<div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="font-weight-semibold"><i class="icon-file-text2 mr-2"></i> Send SMS</h5>
                <div class="header-elements">
                    <b><span style="color:red">*</span> Send MSG Detail  reports order by desc</b>
                </div>
            </div>

    <table class="table datatable-calcun table-striped" id="sample_1">
                <thead>
                <tr>
                    <th>Check Box</th>
                    <th>S. No.</th>
                    <th>Member Name</th>
                    <th>Member ID</th>
                    <th>Mobile No.</th>
                </tr>

                </thead>

                <tbody id="userid">
                <?php
                $sn = 1;
                foreach ($member_detail->result() as $row) {

                    ?>
                    <tr>
                        <td><input type="checkbox" id="<?php echo $sn; ?>" name="<?php echo $sn; ?>"
                                   value="<?php echo $row->or_m_mobile_no; ?>" onClick="chbchecksin()"/></td>
                        <td><?php echo $sn; ?></td>
                        <td><?php echo $row->or_m_name; ?></td>
                        <td><?php echo $row->or_m_member_id; ?></td>
                        <td><?php echo $row->or_m_mobile_no; ?></td>
                    </tr>
                    <?php
                    $sn++;
                } ?>

                </tbody>
            </table>
        </div>
</div>


<script>
    function chbchecksin() {
        quid = "";
        var collection = $("#userid");
        var inputs = collection.find("input[type=checkbox]");
        for (var x = 0; x < inputs.length; x++) {
            var id = inputs[x].id;
            var name = inputs[x].name;
            if ($("#" + id + "").is(':checked')) {
                quid = $("#" + id + "").val() + "," + quid;

            }
        }

        $("#txtquid").val(quid);
    }

    function check4() {
        $("#divtxtquid").html("");
        $("#divtxtmessage").html("");
        if ($("#txtmessage").val() != '') {
            if ($("#txtquid").val() != '') {

                $("#hide").css('display', 'none');
                return confirm('Are you sure want to send SMS');
            }
            else {
                $("#divtxtmessage").html('Please select member or enter mobile number');
                return false;
            }
        }
        else {
            $("#divtxtmessage").html('Please enter your message');
            $("#divtxtquid").html('Please select member or enter mobile number');
            return false;
        }

    }


    function chbcheckall() {
        quid = "";
        var collection = $("#userid");
        var inputs = collection.find("input[type=checkbox]");
        for (var x = 0; x < inputs.length; x++) {
            var id = inputs[x].id;
            var name = inputs[x].name;
            if ($("#checkall").is(':checked')) {
                document.getElementById(id).checked = true;
                quid = $("#" + id + "").val() + "," + quid;
            }
            else {
                document.getElementById(id).checked = false;
                quid = "";
            }
        }
        $("#txtquid").val(quid);
    }

    function withoutplan(value) {
        var collection = $("#plan");
        var inputs = collection.find("input[type=checkbox]");
        for (var x = 0; x < inputs.length; x++) {
            var id = inputs[x].id;
            document.getElementById(id).checked = false;
        }
        $("#txtplantype").val('');
        $("#txtplan").val(value);
    }

    function withplan() {
        quid = "";
        var collection = $("#plan");
        var inputs = collection.find("input[type=checkbox]");
        for (var x = 0; x < inputs.length; x++) {
            var id = inputs[x].id;
            var name = inputs[x].name;
            if ($("#" + id + "").is(':checked')) {
                if (quid != "") {
                    quid = $("#" + id + "").val() + "," + quid;
                }
                else {
                    quid = $("#" + id + "").val();
                }

            }
        }

        $("#txtplantype").val(quid);

        var collection = $("#isplan");
        var inputs = collection.find("input[type=checkbox]");
        for (var x = 0; x < inputs.length; x++) {
            var id = inputs[x].id;
            document.getElementById(id).checked = false;
        }
        $("#txtplan").val('');

    }
</script>

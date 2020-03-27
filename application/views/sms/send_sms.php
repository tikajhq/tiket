<div class="offset-md-0 col-md-12">
<?php get_msg(); ?>
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <div class="caption">
                <h5 class="card-title"><i class="icon icon-ticket"></i>SMS</h5>
            </div>
        </div>
        <div class="container-fluid" id="msg">
            <div class="form">
                <form class="form-horizontal" method="post"
                      action="<?php echo BASE_URL; ?>/sms/send_sms">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class=" control-label">Campaign Name</label>
                                        <input type="text" class="form-control blank" name="sms_campaign"
                                            id="sms_campaign"
                                            placeholder="Enter Campaign Name" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class=" control-label">Numbers</label>
                                        <textarea name="members_to_send" id="members_to_send" minlength="" maxlength=""
                                                class="form-control empty " rows=8 onkeyup="membercountupdate(this.value)" data-role="tagsinput" required ></textarea>
                                        <span id="MembCount" class="">0 Memvers</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="radio-inline">Schedule on</label>
                                        <input type="datetime-local" name="schedule" id="schedule" class="form-control loan-object"  />     
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Members</label>
                                        <select class="form-control form-control-select2" name="to_mobile" id="to_mobile" multiple>
                                            <?php
                                            foreach($members as $member)
                                            {
                                                echo '<option value="'.$member['mobile'].'">&nbsp;&nbsp;'.$member['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class=" control-label">Message</label>
                                        <textarea name="ticketmessage" id="ticketmessage" minlength="" maxlength=""
                                                class="form-control empty required" rows=13 required onkeyup="charcountupdate(this.value)"></textarea>
                                        <span id="charNum" class="">0 out of 160 characters</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-actions" align="middle">
                            <button type="reset" class="btn btn-danger legitRipple">Reset</button>
                            <input type="submit" class="btn btn-primary legitRipple legitRipple-empty" value="Send">
                            &nbsp;&nbsp;
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#to_mobile").change(function(){
        var members = [];
        $.each($("#to_mobile option:selected"), function(){            
            members.push($(this).val());
        });
        var allmembers = members.join("; ");
        $("#members_to_send").val(allmembers);
        var members = allmembers.split(';');
        var total = members.length;
        document.getElementById("MembCount").innerHTML = total + ' Members';
    });

    function charcountupdate(str) {
        var lng = str.length % 160;
        var message_count = Math.floor(str.length/160) + 1;
        document.getElementById("charNum").innerHTML = lng + ' out of 160 characters [ '+message_count+' Messages ]';
    };

    
</script>
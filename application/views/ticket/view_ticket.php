<script>

</script>
<div class="container fluid-content ">
    <div class="row ">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ticket-head custom-border-radius m-0">
                        <div class="d-flex align-content-between">
                            <p style="white-space: nowrap;" class="pr-2">
                                <span class="tik-status text-right" data-value="<?= $info['status'] ?>"></span>
                                <br>
                                <span class="mt-3"><i class="fa fa-ticket"></i>
                                <?= $ticket_no ?></span>
                            </p>
                            <div class="pr-2">
                                <?PHP
                                $tik_attachments = '';
                                $decoded = json_decode($info['data'], true);
                                if($decoded)
                                    $tik_attached = $decoded['attachments'];
                                if ($decoded && $tik_attached)
                                    foreach ($decoded['attachments'] as $tik_attachment) {
                                        $tik_attachments = $tik_attachments . '<p><span class="attachment" data-filename="' . $tik_attachment['file_name'] . '" data-filepath="' . base_url() . $tik_attachment['path'] . '"></p>';
                                    }
                                ?>
                                <h3><?= $info['subject'] ?></h3>
                                <p><?= $info['message'] . $tik_attachments ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="comments-container">
                        <ul id="comments-list" class="comments-list">
                            <?PHP foreach ($messages as $message) {
                                $attachments = '';
                                $decoded = json_decode($message['data'], true);
                                if($decoded)
                                $attached = $decoded['attachments'];
                                if ($decoded && $attached)
                                    foreach ($decoded['attachments'] as $attachment) {
                                        $attachments = $attachments . '<p><span class="attachment" data-filename="' . $attachment['file_name'] . '" data-filepath="' . base_url() . $attachment['path'] . '"></p>';
                                    }
                                if ($message['type'] == 1)
                                    echo '<li>
                                <div class="comment-main-level">
                                    <div class="d-flex align-items-start">
                                        <!-- Avatar -->
                                        <div class="comment-avatar" data-username="' . $message['owner'] . '"></div>
                                        <!-- Comment & Attachments -->

                                        <div class="comment-box">
                                            <div class="comment-head">
                                                <h6 class="comment-name"><a href="#" class="user-name" data-username="' . $message['owner'] . '"></a></h6>
                                                <span class="rel-time" data-value="' . $message['created'] . '000"></span>
                                            </div>
                                            <div class="comment-content">
                                                ' . $message['message'] . $attachments
                                        . '
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>';
                                else
                                    echo ' <li>
                            <!-- Activity-tag -->
                           <div class="activity-tag">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                       <i class="activity-icon" data-type="' . $message['type'] . '"></i>
                                    <div class="activity-text">
                                        <h6 class="comment-name"><a href="#">@' . $message['owner'] . '</a> ' . $message['message'] . ' 
                                            <span class="rel-time" data-value="' . $message['created'] . '000"></span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </li>';
                            } ?>
                        </ul>
                        <div class="col-md-12 add-comment custom-border-radius">
                            <h3>Leave a comment</h3>
                            <!-- <form> -->
                            <div id="comment" style="min-height: 100px;"></div>
                            <br>
                            <div class="row">
                                <label class="col-sm-12 form-control-label" for="fileInput"><i
                                            class="fa fa-paperclip"></i> Attachment</label>
                                <div class="col-sm-12">
                                    <div class="custom-file">
                                        <input id="fileInput" type="file" class="custom-file-input">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <!--uploaded files-->
                                    <ul id="attached_files" class="mt-3">
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <img src="http://localhost:8090/assets/img/avatar-1.jpg" width="35"
                                     alt="Profile of Bradley Jones" title="Bradley Jones"/> -->
                                <div class="col-md-12">
                                    <button class="btn btn-primary" id="reply"
                                            data-ticket-no="<?= $info['ticket_no'] ?>">Reply <i class="fa fa-reply"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4 no-padding-left ticket-details-right">
            <div class="card custom-border-radius sticky-this">
                <div class="card-header d-flex align-items-center custom-border-radius">
                    <h3 class="h4"><i class="fa fa-ticket"></i>Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsiveW">
                            <table class="table">
                                <tr>
                                    <th class="border-0">Ticket Number</th>
                                    <td class="border-0"><?= $info['ticket_no'] ?></td>
                                    <td class="border-0"></td>
                                </tr>
                                <tr>
                                    <th>Created on</th>
                                    <td><span class="rel-time" data-value="<?= $info['created'] . '000' ?>"></span></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Created By</th>
                                    <td><span class="user-label"
                                              data-username="<?= isset($info['owner']) ? $info['owner'] : '' ?>"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Purpose</th>
                                    <td><?= $info['purpose'] ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Ticket Status</th>
                                    <td><span class="tik-status" data-value="<?= $info['status'] ?>"></span></td>
                                    <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                        <div class="col-sm-12 select select-ticket-dropdown hide"
                                             style="position: absolute;right:0; margin-top: -25px;">
                                            <select name="status" id="status_dd" data-id="<?= $info['id'] ?>"
                                                    data-type="4" class="form-control" style="width: 100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ticket Severity</th>
                                    <td><span class="tik-severity" data-value="<?= $info['severity'] ?>"></span></td>
                                    <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                        <div class="col-sm-12 select select-ticket-dropdown hide"
                                             style="position: absolute;right:0; margin-top: -25px;">
                                            <select name="severity" id="severity_dd" data-id="<?= $info['id'] ?>"
                                                    data-type="5" class="form-control selection" style="width: 100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ticket Category</th>
                                    <td><span class="tik-category"
                                              data-value="<?= isset($info['category']) ? $info['category'] : '-' ?>"></span>
                                    </td>
                                    <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                        <div class="col-sm-12 select select-ticket-dropdown hide"
                                             style="position: absolute;right:0; margin-top: -25px;">
                                            <select name="category" id="category_dd" data-id="<?= $info['id'] ?>"
                                                    data-type="7" class="form-control" style="width: 100%">
                                                <option></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Ticket Priority</th>
                                    <td><span class="tik-priority" data-value="<?= $info['priority'] ?>"></span></td>
                                    <?php
                                    if ($privilege) { ?>
                                        <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                            <div class="col-sm-12 select select-ticket-dropdown hide"
                                                 style="position: absolute;right:0; margin-top: -25px;">
                                                <select name="priority" id="priority_dd" data-id="<?= $info['id'] ?>"
                                                        data-type="6" class="form-control " style="width: 100%">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <th>Assigned to</th>
                                    <td><span class="user-label"
                                              data-username="<?= isset($info['assign_to']) ? $info['assign_to'] : '' ?>"></span>
                                    </td>
                                    <?php
                                    if ($privilege) { ?>
                                        <td><a href="Javascript:void(0);" class="edit-ticket-dropdown">Edit</a>
                                            <div class="col-sm-12 select select-ticket-dropdown hide"
                                                 style="position: absolute;right:0; margin-top: -25px;">
                                                <select name="assign_to" id="assign_to_dd" data-id="<?= $info['id'] ?>"
                                                        data-type="8" class="form-control" style="width: 100%">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                    <?php } ?>
                                </tr>

                                <tr>
                                    <th>Assigned on</th>
                                    <td><span class="rel-time" data-value="<?= $info['assign_on'] ?>"></span></td>
                                </tr>
                                <tr>
                                    <th>CC</th>
                                    <td><?php
                                        if (!empty($info['cc'])) {
                                            $ccs = explode(';', $info['cc']);
                                            foreach ($ccs as $cc) {
                                                echo '<span class="user-label" data-username="' . $cc . '"></span>';
                                            }
                                        } else echo '-';

                                        ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Last Updated on</th>
                                    <td><span class="rel-time" data-value="<?= $info['updated'] . '000' ?>"></span></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<script>
    $(document).ready(function () {
        var attached_files = [];

        //call a function to handle file upload on select file
        $('input[type=file]').on('change', function (e) {
            var res = fileUpload(e, BASE_URL + 'API/Ticket/upload_attachment', function (res) {
                console.log(res);
                if (res) {
                    attached_files.push(res);
                    var attached_link = getAttachmentLabel(res.file_name, res.path);
                    $('#attached_files').append('<li>' + attached_link + '<span class="remove-this" data-index="' + attached_files.length + '"><i class="fa fa-close"></i></span></li>')
                    removeAttachment();
                }
            });
        });

        var toolbarOptions = [
            [{'font': []}],
            [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
            [{'header': [1, 2, 3, 4, 5, 6, false]}],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            [{'color': []}, {'background': []}],
            [{'align': []}],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
            [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
            [{'direction': 'rtl'}],                         // text direction
        ];

        var cquill = new Quill('#comment', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        $("#reply").on('click', function (e) {
            e.preventDefault();
            var ticket_no = $(this).attr('data-ticket-no');
            var message = cquill.root.innerHTML;
            var data = {"attachments": attached_files}
            attached_files = [];
            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Ticket/addThreadMessage',
                dataType: 'text',
                data: {'ticket_no': ticket_no, 'message': message, 'data': data, 'type': 1},

                beforeSend: function () {
                    $('#au_result').html('<img src="' + BASE_URL + 'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
                },

                success: function (response) {
                    if (JSON.parse(response)['data']['result']) {
                        showNotification('success', 'Comment added successfully')
                        window.location.reload();
                    } else
                        showNotification('error', 'Some error occured')
                }
            });
        });

        renderDropdowns();

        $('.edit-ticket-dropdown').click(function () {
            let fewSeconds = 2;
            $(this).siblings('.select-ticket-dropdown').toggleClass('hide');
            let id_select = $(this).siblings('.select-ticket-dropdown').children('select').attr('id');
            $("#" + id_select).select2('open');
            let btn = $(this);
            btn.prop('disabled', true);
            setTimeout(function () {
                btn.prop('disabled', false);
            }, fewSeconds * 1000);
        });

        $('.select-ticket-dropdown').focusout(function (e) {
            let fewSeconds = 2;
            $(this).addClass('hide');
            let btn = $(this);
            btn.prop('disabled', true);
            setTimeout(function () {
                btn.prop('disabled', false);
            }, fewSeconds * 1000);
        });

        $('select.form-control').on('change', function () {
            var intfields = ['severity', 'priority', 'category', 'status'];
            var field = $(this).attr('name');
            var value = this.value;
            if (intfields.includes(field))
                value = parseInt(value); // convert to number type for selected fields
            var ticket_id = $(this).attr('data-id');
            var message = "Changed " + field + " to <span class='tik-" + field + "' data-value=" + value + "></span>";
            var plain_txt_message = "Changed " + field + " to " + value + ".";

            var type = parseInt($(this).attr('data-type'));
            var data = {
                'update_data': {'id': ticket_id},
                'meta': {
                    'ticket_no': "<?= $info['ticket_no']?>",
                    'message': message,
                    'type': type,
                    'plain_txt_message': plain_txt_message
                }
            };
            data['update_data'][field] = value;

            if (field === "assign_to") {
                message = data['meta']['message'] = 'Changed assignee to <span class="user-label" data-username="' + value + '"></span>';
                plain_txt_message = data['meta']['plain_txt_message'] = 'Changed assignee to ' + value + '.';
                data['update_data']['assign_on'] = Date.now();
                data['update_data']['status'] = 50; //hardcoded assigned status;
            }

            $.ajax({
                type: 'POST',
                url: BASE_URL + 'API/Ticket/updateTicket',
                dataType: 'text',
                data: data,

                beforeSend: function () {
                    $('#au_result').html('<img src="' + BASE_URL + 'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
                },

                success: function (response) {
                    if (JSON.parse(response)['data']['result']) {
                        showNotification('success', message, {}, function () {
                            window.location.reload();
                        })
                    } else
                        showNotification('error', 'Some error occured.');

                }
            });
        });
    });

    function removeAttachment() {
        $('.remove-this').on('click', function () {
            var index = parseInt($(this).attr('data-index'));
            let attached_files = $("#attached_files");
            attached_files.splice(index, 1);
            console.log(attached_files);
            $(this).parent().remove();
        });
    }
</script>

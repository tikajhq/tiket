<!-- Dashboard Counts Section-->
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card  custom-border-radius">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive" id="tickets">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript">
    $(function () {
        
        var options = {
            datatable: {
                order: [[8, 'desc']],
                columns: [
                    {
                        title: "Ticket No",
                        data: "ticket_no",
                        render: function (data) {
                            return '<a href="' + BASE_URL + 'tickets/view_ticket/' + data + '" style="color: gray; text-decoration:none;">' + data + '</a>'
                        }
                    },
                    {
                        title: "Subject",
                        data: "subject",
                        render: function (data) {
                            return addBrAfterXWords(6,data);
                        }
                    },
                    {
                        title: "Severity",
                       data: "severity",
                        render: function (data) {
                            return '<span class="tik-severity" data-value="'+data+'">';
                        }
                    },
                    {
                        title: "Priority",
                       data: "priority",
                        render: function (data) {
                            return data?'<span class="tik-priority" data-value="'+data+'">':'Not Assigned';
                        }
                    },
                    {
                        title: "Status",
                        data: "status",
                        render: function (data) {
                            return '<span class="tik-status" data-value="'+data+'">';
                        }
                    },
                    {
                        title: "Category",
                        data: "category",
                        render: function (data) {
                            return data?('<span class="tik-category" data-value="'+data+'">'):'-';
                        }
                    },
                    {
                        title: "Created By",
                        data: "owner",
                        render: function (data, type, row) {
                            return data?('<div class="text-left"><span class="user-label" data-username="'+data+'"></span><span class="user-name" data-username="'+data+'"></span></div>'):'-';
                        }
                    },
                    {
                        title: "Assigned To",
                        data: "assign_to",
                        render: function (data, type, row) {
                            return data?('<div class="text-left"><span class="user-label" data-username="'+data+'"></span><span class="user-name" data-username="'+data+'"></span></div>'):'-';
                        }
                    },
                    {
                        title: "Created On",
                        data: "created",
                        render: function (data) {
                            return data?'<span class="rel-time" data-value="'+data+'000">':'-';
                        }
                    },

                    {
                        title: "#",
                        data: "id",
                        render: function (data, type, row) {
                            console.log(row);
                            return ('<a href="' + BASE_URL + 'tickets/view_ticket/' + row['ticket_no'] + '" class="badge bg-blue" title="View Ticket"> <i class="fa fa-eye"></i></a>') +(
                            (parseInt(row['status'])==100)?('<a class="close-ticket badge bg-green" data-ticket-no="'+row['ticket_no']+'" data-id="'+data+'" data-status="0" title="Re-open Ticket"> <i class="fa fa-repeat"></i></a>'):
                            ('<a class="close-ticket badge bg-red" data-ticket-no="'+row['ticket_no']+'" data-id="'+data+'" data-status="100" title="Close Ticket"> <i class="fa fa-check"></i></a>'));
                        }
                    },

                ]
            }
        };
        var my_tik_table =  makeReportPage($('#tickets'), 'list_my_tickets?type=<?= $type?>', options, function(err, data){
            data.table.on('draw', function(){
                renderCustomHTML();
                $('[data-toggle="tooltip"]').tooltip();
                $('.close-ticket').css({"margin-left": '5px', "cursor": 'pointer', 'color' : 'white'});
                $('.close-ticket').on('click', function(e){
                    e.preventDefault();
                   var ticket_no = $(this).attr('data-ticket-no');
                   var id = $(this).attr('data-id');
                   var status = parseInt($(this).attr('data-status'));
                   var message = "Re-opened the ticket";
                   if(status) message = "Closed the ticket";
                   var type = 2; // Re-Opened
                   if(status) type = 3; // Closed
                   var data = {'update_data':  {'status':status, 'id':id}, 'meta':{'ticket_no':ticket_no, 'message':message, 'plain_txt_message' :message, 'type':type}}
                        $.ajax({
                            type      : 'POST',
                            url       : BASE_URL + 'API/Ticket/updateTicket',
                            dataType  : 'text',
                            data      : data,

                            beforeSend: function()
                            {
                                $('#au_result').html('<img src="'+BASE_URL+'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
                            },

                            success: function(response)
                            {
                                if(JSON.parse(response)['data']['result']){
                                    showNotification('success', message+ ' successfully', {}, function(){
                                        window.location.reload();
                                    });
                                }
                                else
                                    showNotification('error', 'Some error occured. Please try again.');
                                
                            }
                        });
                    });
            })
        });

       

    });
</script>

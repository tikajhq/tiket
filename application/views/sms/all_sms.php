<div class="offset-md-0 col-md-12">
<?php get_msg(); ?>
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <div class="caption">
                <h5 class="card-title"><i class="icon icon-ticket"></i>SMS</h5>
            </div>
        </div>
        <div class="container-fluid" id="msg">
            <div class="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">


                            <div id="report-page"></div>
                            <script type="application/javascript">
                                makeReportPage($("#report-page"), "list_sms_campaigns", {
                                    datatable: {
                                        "order": [[0, 'desc']],
                                        columns: [
                                            {
                                                title: "Campaign Name",
                                                data: "campaign_name",
                                                render: function (data) {
                                                    return data;
                                                }
                                            },
                                            {
                                                title: "Created On",
                                                data: "created",
                                                render: function (data) {
                                                    // return getDate(data);
                                                    return getDateTime(data);
                                                }
                                            },
                                            {
                                                title: "Total Receivers",
                                                data: "members",
                                                render: function (data) {
                                                    return data;
                                                }
                                            },
                                            {
                                                title: "Sent SMS Status",
                                                data: "total_sent",
                                                render: function (data, type, row, meta) {
                                                    return row['total_sent']+' out of '+row['members'];
                                                }
                                            },
                                            {
                                                title: "Schedule Cancelled",
                                                data: "schedule_cancelled",
                                                render: function (data, type, row, meta) {
                                                    return row['schedule_cancelled']+' out of '+row['members'];
                                                }
                                            },
                                            {
                                                title: "Action",
                                                data: "camp_id",
                                                render: function (data, type, row, meta) {
                                                    return '<a title="View Details" class="badge badge-primary" href="' + BASE_URL + 'sms/smsDetails/' + data + '"><i class="icon-eye"></i></a>';
                                                }
                                            }
                                        ]
                                    }
                                });
                            </script>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var status_map = [{"value":"SMS Queued"},
{"value":"SMS Send"},
{"value":"SMS Schedule Cancelled"}
];
</script>
<div class="offset-md-0 col-md-12">
<?php get_msg(); ?>
    <div class="card">
        <div class="card-header bg-transparent header-elements-inline">
            <div class="caption">
                <h5 class="card-title"><i class="icon icon-ticket"></i> Details</h5>
            </div>
        </div>
        <div class="container-fluid" id="msg">
            <div class="row">
                <div class="card-body">
                    <div class="row">
                        <table class="table tik-datatable">
                            <tbody>
                                <tr>
                                    <td style="width: 25%;">
                                        <p>
                                            <strong>Campaign Name:</strong><br>
                                            <?= !empty(trim($smsInfo[0]['campaign_name'])) ? $smsInfo[0]['campaign_name'] : "Empty or Not Defined" ?>
                                        </p>
                                    </td>
                                    <td style="width: 25%;">
                                        <p>
                                            <strong>Total Numbers of Receivers:</strong><br>
                                            <?= $smsInfo[0]['receivers'] ?? "Not Defined"  ?>
                                        </p>
                                    </td>
                                    <td style="width: 50%;">
                                        <p>
                                            <strong>Message Body:</strong><br>
                                            <?= $smsInfo[0]['message'] ?? "Not Defined"  ?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <hr> 
                    <div class="row">   
                       
                        <table id="sms_details" class="table tik-datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Created On</th>
                                    <th>Recievers</th>
                                    <th>Send SMS Status</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>

                        <script type="application/javascript">
                            var options = {
                                datatable: {
                                    columns: [
                                        {
                                            title: "Created On",
                                            data: "created",
                                            render: function (data) {
                                                return getDateTime(data);
                                            }
                                        },
                                        {
                                            title: "Recievers",
                                            data: "sentto",
                                            render: function (data) {
                                                return data;
                                            }
                                        },
                                        {
                                            title: "Send SMS Status",
                                            data: "status",
                                            render: function (data, type, row, meta) {
                                               //  return data;
                                                return status_map[parseInt(data)]['value']
                                            }
                                        },
                                        {
                                            title: "Schedule Time",
                                            data: "schedule",
                                            render: function (data, type, row, meta) {
                                                return getDateTime(data) 
                                            }

                                        },
                                        {
                                            title: "Action",
                                            data: "",
                                            render: function (data, type, row, meta) {
                                                if(parseInt(row['status']) < 1)
                                                {
                                                    return "<a href='<?= BASE_URL?>Sms/cancelSchedule?sms="+row['id']+"&camp=<?php echo $smsID ?>'>Cancel Schedule</a>";
                                                }
                                                else
                                                {
                                                    return 'No action required';
                                                }
                                            }

                                        },
                                    ]
                                }};

                            var path = "<?= BASE_URL?>API/sms/Sms/getSMSDetailedView?camp=<?php echo $smsID ?>";
                            console.log(path);
                            $('#sms_details').DataTable(Object.assign({
                                "processing": true,
                                dom: 'Bfrtip',
                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5',
                                    'pdfHtml5'
                                ],
                                paging: true,
                                pageLength: 100,
                                "ajax": {
                                    "type": 'GET',
                                    "url": path,
                                    "dataSrc": function (json) {
                                        return json.data;
                                    }
                                }
                            }, options.datatable));
                        </script>
                            
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <?php echo get_msg();?>
        <?php if($this->session->userdata('sessions_details')['type'] == 100){?>

            <div class="offset-md-2 col-md-4">
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <div class="caption">
                            <h5 class="card-title"><i class="icon icon-piggy-bank"></i>Create New Token</h5>
                        </div>
                    </div>
                    <div class="container-fluid" id="msg">
                        <div class="portlet-body form">
                            <form class="form-horizontal" method="post"   action="<?= BASE_URL ?>gateway/index">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class=" control-label">Username</label>
                                                <input type="text" class="form-control amount" name="username"
                                                        id="username" maxlength="11" placeholder="Enter username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class=" control-label">PIN</label>
                                                <input type="number" class="form-control amount" name="pin"
                                                        id="pin_number" maxlength="11" min="1" placeholder="" value=1  >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class=" control-label">Amount</label>
                                                <input type="text" class="form-control amount" name="amount"
                                                       id="amount" maxlength="11" placeholder="Enter Amount" value="<?= PIN_AMOUNT ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions" align="middle">
                                        <button type="reset" class="btn btn-danger legitRipple">Reset</button>
                                        <input type="submit" class="btn btn-primary legitRipple legitRipple-empty">
                                        &nbsp;&nbsp;
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php }if($this->session->userdata('sessions_details')['type'] == 100){?>
    <div class="offset-md-0 col-md-5">
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <div class="caption">
                    <h5 class="card-title"><i class="icon icon-piggy-bank"></i>App information </h5>
                    <I style="font-size: 10px;color:red">@Auto created by system</I>
                </div>
            </div>
            <div class="container-fluid" id="msg">
                <div class="portlet-body form">
                    <form class="form-horizontal" method="post"
                          action="<?= BASE_URL ?>gateway/index">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 font-weight-semibold">APP ID</label>
                                <div class="col-lg-8">
                                    <button onclick="copyTexts('appid');" type="button"
                                            class="btn bg-success btn-labeled btn-labeled-right">
                                        <b><i class="icon-copy"></i></b><span id="clipappid"><?php echo empty($app_id) ? '' : $app_id ?></span>
                                    </button>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 font-weight-semibold">APP SECRET</label>
                                <div class="col-lg-8">
                                    <button onclick="copyTexts('secret');" type="button"
                                            class="btn bg-success btn-labeled btn-labeled-right">
                                        <b><i class="icon-copy"></i></b><span id="clipsecret"><?php echo empty($app_secret) ? '' : $app_secret ?></span>
                                    </button>
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
<div class="offset-md-2 col-md-9">
<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Tokens Reports</h6>

    </div>

    <div class="card-body">
        <div class="chart" id="sales-heatmap"></div>
    </div>



    <div id="pin-table"></div>
    <script type="application/javascript">
        makeReportPage($("#pin-table"), "getAmountTokens", {
            datatable: {
                "order": [[0, 'desc']],
                columns: [
                    {
                        title: "Token",
                        data: "token",
                        render:function(data){
                            return `
                            <button onclick="copyTexts('${data}');" type="button"
                                    class="btn bg-green btn-labeled btn-labeled-right">
                                <b><i class="icon-copy"></i></b><span id="clip${data}">${data}</span>
                            </button>`;
                        }
                    },
                    {
                        title: "Issued for",
                        data: "uid",
                        render:function(data){
                            return getUsernameFromID(data)
                        }
                    },
                    
                    {
                        title: "Amount",
                        data: "meta",
                        render: function(data){
                            // data = data.split('"');
                            // return data[3];
                            var metadata = JSON.parse(data);
                            return metadata['amount'];
                        }
                    },
                    {
                        title: "Created",
                        data: "created",
                    },
                    {
                        title: "Status",
                        data: "status",
                        render: function (data) {
                            return ['OTH', 'Active'][data];
                        }
                    },
                ]
            }
        });
    </script>



</div>


    </span>
</div>
</div>
<script>
    function copyTexts(id) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('#clip'+id).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    $(document).ready(function(){
        $("#pin_number").change(function(){
            var pin = $(this).val();
            $('#amount').val(pin*200);
            // alert(pin);
        });
    });

</script>

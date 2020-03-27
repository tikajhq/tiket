<?PHP

function view_payment()
{
    $CI = & get_instance();

    $rows = $CI->db->get_where('m42_pay_mode', ['status' => 1])->result();

    $banks = $CI->db->get_where('m13_bank', ['m_bank_status' => 1])->result();
    $ui = '<div class="col-sm-6">
        <div class="form-group">
        <label class=" control-label">Payment Mode</label>
        <select class="col-md-12 form-control opt select-clear" name="ddpayment_mode" id="ddpayment_mode">
            <option value="-1">--Select--</option>';
    foreach ($rows as $row)
    {
        $ui .= '<option value="' . $row->id . '">' . $row->name . '</option>';
    }
    $ui .= '</select>
        <span id="divddpayment_mode" style="color:red;"></span>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label">Payment Date</label>
        <input type="text" class="form-control daterange-single"  name="txtchequedate" id="txtchequedate">
        <span id="divtxtchequedate" style="color:red;"></span>
    </div>
</div>

<div class="col-md-12 p-0 m-0" >

    <div class="card-body  p-0 m-0"  id="hid_cheque" style="display:none;">
        <br>
        <div class="row px-2">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Bank Name</label>
                    <select class="form-control" name="paymentBank" id="paymentBank" >
                        <option value="-1">--Select bank--</option>';
    foreach ($banks as $bank)
    {
        $ui .= '<option value="' . $bank->m_bank_id . '">' . $bank->m_bank_name . ' </option>';
    }

    $ui .= '</select>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Branch Name</label>
                    <input type="text" class="form-control" name="paymentBranch" id="paymentBranch">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label"><span id="paymentTypes"></span> Reference Number</label>
                    <input type="text" class="form-control" name="paymentNumber" id="paymentNumber">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Status</label>
                    <select name="paymentStatus" id="paymentStatus"  class="form-control">
                        <option value="1">Clear</option>
                        <option value="0">Pending</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="row px-2">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Pay Amount</label>
                <input type="text" class="form-control" name="paymentAmount" id="paymentAmount" onkeypress="return isNumber(event)">
                <span id="payAmount" style="color:red;"></span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Payment Narration</label>
                <input type="text" class="form-control" name="paymentNaration" id="paymentNaration">
            </div>
        </div>
    </div>

</div>

';
    echo $ui;
}
?>
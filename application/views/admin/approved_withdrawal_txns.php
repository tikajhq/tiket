<!-- /info alert -->
<?php get_msg(); ?>
<!-- Content area -->
<div class="content">
	<!--    Transaction Table-->
	<div class="row">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="font-weight-semibold"><i class="icon-file-text2 mr-2"></i>Approved Withdrawal Request</h5>
                <a class="badge badge-primary p-2" href="<?= base_url('admin/all_withdrawal_requests')?>">Approved Withdrawal Requests</a>
			</div>
			<div>


				<div class="portlet-body">
					<table id="downline-right" class="table tik-datatable" style="width: 100%;">
						<thead>
						<tr>
<!--							<th>Sr.</th>-->
							<th>TXN ID</th>
							<th>Amount</th>
							<th>Mode</th>
							<th>Description</th>
							<th>Requested By</th>
							<th>Created Date</th>
							<th>Created Date</th>
							<th>Created Date</th>
							<th>Created Date</th>
							<th>Created Date</th>
							<th>Created Date</th>
							<th>Actions</th>
						</tr>
						</thead>
					</table>

					<script type="application/javascript">
						var path = "<?= base_url()?>tabler/txn_requests?type=5&status=100";
						var options = {
							datatable: {
								"ajax": {
									"type": 'POST',
									"url": path,
									"dataSrc": function (json) {
										return json.data;
									}
								},
								columns: [
									{
										title: "TXN ID",
										data: "id",
										render: function (data) {
											return data;
										}
									},
									{
										title: "Request Amount",
										data: "debit",
										render: function (data) {
											return formatMoney(data || '0');
										}
									},
									{
										title: "Mode",
										data: "mode",
										render: function (data) {
											return (data==1)? 'Cash' : 'Via Bank'
										}
									},
									{
										title: "Description",
										data: "description",
										render: function (data) {
											return data || '-';
										}
									},
									{
										title: "Requested By",
										data: "uid",
										render: function (data) {
											return '<a href="admin/member_report/'+data+'">'+ getUsernameFromID(data)+ '</a>';
										}
									},
									{
										title: "Requested On",
										data: "updated",
										render: function (data) {
											return getDateTime(data);
										}
									},
									{
										title: "Account Number",
										data: "account_number",
										render: function (data) {
											return data || '-'
										}
									},
									{
										title: "Account Holder Name",
										data: "account_holder",
										render: function (data) {
											return data || '-';
										}
									},
									{
										title: "IFSC Code",
										data: "ifsc_code",
										render: function (data) {
											return data || '-';
										}
									},
									{
										title: "Bank Name",
										data: "bank_name",
										render: function (data) {
											return data || '-';
										}
									},
									{
										title: "Bank Address",
										data: "bank_address",
										render: function (data) {
											return data || '-';
										}
									},
									{
										title: "Action",
										data: "id",
										render: function (data) {
											return '<a href="<?php echo BASE_URL ?>admin/pending_withdrawal_request/'+ data+'/1">Approve</a>'+
												' | <a href="<?php echo BASE_URL ?>admin/pending_withdrawal_request/'+ data+'/0">Reject</a>'
										}
									}

								]
							}};


						$('#downline-right').DataTable(Object.assign(getDatatableConfig(), options.datatable));
					</script>
				</div>
			</div>
		</div>
	</div>
</div>

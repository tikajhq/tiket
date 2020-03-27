<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<div class="caption">
					<h5 class="card-title"><i class="icon icon-cogs"></i>Withdrawal Request Report</h5>
				</div>
			</div>
			<div class="container-fluid" id="msg">
				<?php get_msg(); ?>

				<div class="portlet-body">
					<table id="downline-right" class="table tik-datatable" style="width: 100%;">
						<thead>
						<tr>
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
							<th></th>
							<th>Actions</th>
						</tr>
						</thead>
					</table>

					<script type="application/javascript">
						var path = "<?= base_url()?>tabler/txn_requests?uid=0&type=5";
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
										title: "Status",
										data: "status",
										render: function (data) {
											return (data==70)?'Approval Pending': (data==100)? 'Approved' : 'Rejected'
										}
									},
									{
										title: "Action",
										data: "id",
										render: function (data, type, row, meta) {
											if(row['status'] == 70)
											return '<a href="<?php echo BASE_URL ?>admin/pending_withdrawal_request/'+ data+'/1">Approve</a>'+
												' | <a href="<?php echo BASE_URL ?>admin/pending_withdrawal_request/'+ data+'/0">Reject</a>';
											else
												return '-'
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




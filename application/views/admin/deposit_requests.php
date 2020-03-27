<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<div class="caption">
					<h5 class="card-title"><i class="icon icon-cogs"></i>Deposit Request Report</h5>
				</div>
			</div>
			<div class="container-fluid" id="msg">
				<?php get_msg(); ?>

				<div class="portlet-body">
					<table id="downline-right" class="table tik-datatable" style="width: 100%;">
						<thead>
						<tr>
							<th>Username</th>
							<th>Name</th>
							<th>Requested By</th>
							<th>Sponser Name</th>
						</tr>
						</thead>
					</table>

					<script type="application/javascript">
						var path = "<?= base_url()?>tabler/txn_requests?uid=0&type=1";
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
										title: "Request Amount",
										data: "debit",
										render: function (data) {
											return formatMoney(data || '0');
										}
									},
									{
										title: "Requested By",
										data: "uid",
										render: function (data) {
											return getUsernameFromID(data);
										}
									},
									{
										title: "Date",
										data: "updated",
										render: function (data) {
											return getDateTime(data) || '-';
										}
									},

									{
										title: "Status",
										data: "status",
										render: function (data) {
											return (data==70)?'Approval Pending': (data==100)? 'Approved' : 'Rejected'
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




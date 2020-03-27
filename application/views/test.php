<div class="col-xs-offset-3 col-xs-4">
	<div class="card">
		<div class="card-header header-elements-inline">
			<div class="caption">
				<h5 class="card-title"><i class="icon icon-cogs"></i>Test Page</h5>
			</div>
		</div>
		<div class="container-fluid" id="msg">
			<div class="portlet-body form">
				<div id="report-page"></div>

				<script type="application/javascript">
					makeReportPage($("#report-page"), "list_transactions", {
						datatable: {
							columns: [
								{
									title: "Username",
									data: "uid",
									render: function (data) {
										return getUsernameFromID(data);
									}
								},
								{
									title: "Amount",
									data: "credit",
									render: function (data, type, row, meta) {
										return formatMoney((row['credit'] || 0) - (row['debit'] || 0))
									}
								},
								{
									title: "Type",
									data: "type",
									render: function (data, type, row, meta) {
										return TIK_PAGE_RESPONSE['TRANSACTION_TYPES'][data] || 'Unknown Type';
									}
								},
								{
									title: "Description",
									data: "description",
									defaultContent: " - "
								},
								{
									title: "Time",
									data: "updated",
									defaultContent: " - "
								},
							]
						}
					});
				</script>
			</div>
		</div>
	</div>
</div>

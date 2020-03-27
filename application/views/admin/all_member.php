<div class="col-md-12">
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="font-weight-semibold"><i class="icon-file-text2 mr-2"></i> All Member </h5>
			<div class="header-elements">
				<b><span style="color:red">*</span> Member reports order by desc</b>
			</div>
		</div>
		<div>
			<div id="report-page"></div>
			<script type="application/javascript">
				makeReportPage($("#report-page"), "list_members", {

					datatable: {
						"order": [[0, 'desc']],
						columns: [
							{
								title: "User ID",
								data: "id",
								render: function (data) {
									return getUsernameFromID(data);
								}
							},
							{
								title: "Member Name",
								data: "name",
							},
							{
								title: "Father/Spouse",
								data: "father",
							},
							{
								title: "Mobile",
								data: "mobile",
							},
							{
								title: "Email",
								data: "email",
							},
							{
								title: "Gender",
								data: "gender",
								render: function (data) {
									return ['Male', 'Female'][data];
								}
							},
							{
								title: "City",
								data: "city",
							},
							{
								title: "State",
								data: "state",
							},
							{
								title: "Status",
								data: "status",
								render: function (data) {
									return ['<div class="badge badge-danger">Pending</div>', '<div class="badge badge-success">Approved</div>'][data]
								}
							},
							{
								title: "#",
								data: "id",
								render: function (data) {
									return [
										'<a title="View Profile" class="badge badge-primary" href="' + BASE_URL + '/user/profile/' + data + '"><i class="icon-eye"></i></a>',
										'<a title="Member Tree" class="badge badge-success" href="' + BASE_URL + '/network/tree?uid=' + data + '"><i class="icon-tree7"></i></a>',
										'<a title="View Member Report" class="badge badge-info" href="' + BASE_URL + '/user/member_report/' + data + '"><i class="icon-file-stats"></i></a>',
										'<a title="E Certificate" class="badge badge-danger" href="' + BASE_URL + '/user/view_certificate/' + data + '"><i class="icon-book"></i></a>',
										'<a title="ADF Report" class="badge badge-verified" href="' + BASE_URL + '/wallet/adf_report/' + data + '"><i class="icon-cash"></i></a>'
									].join(' ');
								}
							},

						]
					}
				});
			</script>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<div class="caption">
					<h5 class="card-title"><i class="icon icon-cogs"></i>Active Id's List</h5>
				</div>
			</div>
			<div id="joining-report"></div>
			<script type="application/javascript">
				makeReportPage($("#joining-report"), "joining_report", {

					datatable: {
						"order": [[0, 'desc']],
						columns: [
							{
								title: 'Name',
								data: 'name',
							},
							{
								title: 'Mobile',
								data: 'mobile',
							},
							{
								title: 'Email Id',
								data: 'email',
							},
							{
								title: 'Date of Joining',
								data: 'created',
							},
							{
								title: "User ID",
								data: "username",
							},
							{
								title: 'Sponser id',
								data: 'sponserid',
								render: function(data){
									return getUsernameFromID(data)
								}
							}
							
						]
					}
				});
			</script>
		</div>
	</div>
</div>




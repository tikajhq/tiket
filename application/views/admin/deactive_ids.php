<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<div class="caption">
					<h5 class="card-title"><i class="icon icon-cogs"></i>Deactive Id's List</h5>
				</div>
			</div>
			<div id="deactive-id"></div>
			<script type="application/javascript">
				makeReportPage($("#deactive-id"), "list_deactive_id", {

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




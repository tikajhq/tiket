<div class="card mb-0 ">
	<div class="card-body">
		<?php get_msg(); ?>
		<form method="post">
			<div class="row">
				<div class="col-md-10">
					<div class="form-group">
						<label class=" control-label">Member ID</label>
						<input type="text" id="member_id" name="member" class="form-control empty" placeholder="Member ID"  required>
					</div>
                </div>
                <div class="col-md-2">
					<div class="form-group">
                    <label class=" control-label">&nbsp;</label>
                        <button type="button" class="btn btn-primary btn-block" id="get_team_report">Get Team Report <i class = "icon-circle-right2 ml-2" ></i></button>
					</div>
				</div>
            </div>
            
		</form>
	</div>
</div>

<div class="card mb-0 ">
	<div class="card-body">    
		<div id="team_report_view">
			<h5>Please provide user id to view team record</h5>
		</div>	
		<script>
		$('#get_team_report').click(function(){
			var memberid = $("#member_id").val();
			makeReportPage($("#team_report_view"), "get_team_report?m="+memberid, {
			datatable: {
				"order": [[0, 'desc']],
				columns: [
					{
							title: "Member Name",
							data: "name",
						},
						{
							title: "Mobile",
							data: "mobile",
						},
						{
							title: "Email",
							data: "mailid",
						},
						{
							title: "Date of Joining",
							data: "doj",
						},
						{
							title: "User ID",
							data: "userid",
						},
						{
							title: "Sponsor Id",
							data: "sponsorid",
						}

					]
				}
			});

		});
		</script>
				
	</div>
</div>
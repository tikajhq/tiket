<!-- /info alert -->
<?php get_msg(); ?>
<!-- Content area -->
<div class="content">
	<!--    Transaction Table-->
	<div class="row">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="font-weight-semibold"><i class="icon-file-text2 mr-2"></i>All KYC </h5>
				<div class="header-elements">
					<b><span style="color:red">*</span> Approved Kyc</b>
				</div>
			</div>
			<div>
				<table class="table datatable-calcun">
					<thead>
					<tr role="row">
						<th>Sr.</th>
						<th>User ID</th>
						<th>Name</th>
						<th>Approved documents numbers</th>
						<th>Approved documents name</th>
						<th>View</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$sr=1;
					if(count($data))
						foreach($data as $d)
						{
							?>
							<tr role="row" style="height: 0px;">

								<td><?php echo $sr;?></td>
								<td><?php echo $d["username"]; ?></td>
								<td><?php echo $d["name"]; ?></td>
								<td><?php echo $d["verified"]; ?></td>
								<td><?php echo ucwords(str_replace(",", ", ", str_replace("_", " ", $d["types"]))); ?></td>
								<td><a href = "<?php echo BASE_URL.'user/kyc/'.$d['id']; ?>">View</a></td>
							</tr>
							<?php
							$sr++;
						}
					else {
						?>
						<tr><td>No Data Available</td></tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

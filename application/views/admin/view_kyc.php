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
					<b><span style="color:red">*</span> Kyc reports order by desc</b>
				</div>
			</div>
			<div>
				<table class="table datatable-calcun">
					<thead>
					<tr role="row">
						<th>Sr.</th>
						<th>Username</th>
						<th>Adhar Card</th>
						<th>Pan Card</th>
						<th>Voter Id</th>
						<th>Status</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$sr = 1;
					foreach ($result as $res) {
						?>
						<tr role="row" style="height: 0px;">

							<td><?php echo $sr; ?></td>
							<td><?php echo $res->username; ?></td>
							<td><?php echo $res->u_adhar; ?></td>
							<td><?php echo $res->u_pan; ?></td>
							<td><?php echo $res->u_voter; ?></td>
							<td>
								<?php if ($res->status == 0) {
									?>
									<a href="<?php echo base_url(); ?>index.php/admin/approve_kyc/<?php echo $res->id; ?>/1">Approve</a>
									<a href="<?php echo base_url(); ?>index.php/admin/approve_kyc/<?php echo $res->id; ?>/2">Decline</a>
									<?php
								} else {
									echo $res->status == 1 ? 'Approve' : 'Decline';
								}
								?>

							</td>
						</tr>
						<?php
						$sr++;
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

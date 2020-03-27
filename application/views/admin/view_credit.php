<div class="col-md-12">
	<div class="card">
		<div class="card-header header-elements-inline">
			<h5 class="font-weight-semibold"><i class="icon-file-text2 mr-2"></i>Credit or Debit Balence</h5>
			<div class="header-elements">
				<b><span style="color:red">*</span>Credit or Debit Balence reports</b>
			</div>
		</div>
		<div>
			<table class="table table-striped dataTable no-footer">
				<thead>
				<tr>
					<th>Sr.</th>
					<th>By User Name</th>
					<th>Member Name</th>
					<th>Decription</th>
					<th>Credit Balance</th>
					<th>Debit Balance</th>
					<th>Total Balance</th>
					<th>Action</th>
					<th>Date</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sr = 1;
				foreach ($data as $res) {
					?>
					<tr>
						<td><?php echo $sr; ?></td>
						<td><?php echo $this->session->userdata('name'); ?></td>
						<td><?php echo $res->or_m_name; ?></td>
						<td><?php echo $res->description; ?></td>
						<td><?php echo $res->credit_amt; ?></td>
						<td><?php echo $res->debit_amt; ?></td>
						<td><?php echo $res->total_amt; ?></td>
						<td>
							<?php
							if ($res->status == 0) {
								?>
								<a href="<?php echo base_url(); ?>index.php/admin/accept/<?php echo $res->id; ?>/1">Approved</a> /
								<a href="<?php echo base_url(); ?>index.php/admin/accept/<?php echo $res->id; ?>/2">Reject</a>
								<?php
							} else
								echo $res->status == 1 ? 'Approved' : 'Reject';
							?>
						</td>
						<td><?php echo $res->created; ?></td>
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
</div>

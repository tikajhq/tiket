<!-- /info alert -->
<?php get_msg(); ?>
<!-- Content area -->
<div class="content">
	<!--    Transaction Table-->
	<div class="row">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="font-weight-semibold"><i class="icon-file-text2 mr-2"></i>Pending Deposit Request</h5>
                <a class="badge badge-primary p-2" href="<?= base_url('admin/all_deposit_requests')?>">All Deposit Requests</a>
			</div>
			<div>
				<table class="table datatable-calcun">
					<thead>
					<tr role="row">
						<th>Sr.</th>
						<th>TXN ID</th>
						<th>Amount</th>
						<th>Description</th>
						<th>Requested By</th>
						<th>Created Date</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$sr = 1;
					if(count($txns))
					foreach ($txns as $txn) { ?>
						<tr role="row" style="height: 0px;">

							<td><?php echo $sr ?></td>
							<td><?php echo $txn['id'] ?></td>
							<td><?php echo $txn['credit'] ?></td>
							<td><?php echo $txn['description'] ?></td>
							<td><a href="<?php echo base_url('admin/member_report/').$txn['uid'] ?>"><?php echo formatUserID($txn['uid']) ?></td>
							<td><?php echo date($txn['updated']) ?></td>
							<td><a href="<?php echo base_url('admin/pending_deposit_request/').$txn['id'].'/1'?>">Approve</a>
								| <a href="<?php echo base_url('admin/pending_deposit_request/').$txn['id'].'/0'?>">Reject</a>
							</td>
						</tr>
					<?php $sr++; } else {  ?>
						<tr>
							<td>
								No Pending Deposit Requests
							</td>
						</tr>
					<?php  }?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

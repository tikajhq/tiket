<!-- /info alert -->
<?php get_msg(); ?>
<!-- Content area -->
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="row px-1">
				<!--Total Users-->
				<div class="col-md-4 text-center">
					<div class="widget-card widget-card-red">
						<div class="media">
							<div class="widget-icon">
								<i class="icon-users icon-3x opacity-75"></i>
							</div>
							<div class="media-body text-right">
								<h3 class="font-weight-semibold mb-0"><?php echo $stats['total_members'] ? $stats['total_members'] : '0'; ?></h3>
								<span class="text-uppercase font-size-sm ">Total Members</span>
							</div>
						</div>
					</div>
				</div>
				<!--Pending Approvals-->
				<div class="col-md-4 text-center">
					<div class="widget-card widget-card-yellow">
						<div class="media">
							<div class="widget-icon">
								<i class="icon-sort-time-desc icon-3x opacity-75"></i>
							</div>
							<br>
							<div class="media-body text-right">
								<h3 class="font-weight-semibold mb-0"><?php echo $stats['pending_kyc_approvals'] ? $stats['pending_kyc_approvals'] : '0'; ?></h3>
								<span class="text-uppercase font-size-sm">Pending KYC Approval</span>
							</div>
						</div>
					</div>
				</div>
				<!--Recent Members-->
				<!--				<div class="col-md-4 text-center">-->
				<!--					<div class="card card-body bg-warning-300 has-bg-image">-->
				<!--						<div class="media d-block">-->
				<!--							<div class="align-self-center">-->
				<!--								<i class="icon-user-plus icon-3x opacity-75"></i>-->
				<!--							</div>-->
				<!--							<br>-->
				<!--							<div class="media-body d-block">-->
				<!--								<h1 class="mb-0">--><?php //echo $stats['recent'] ? $stats['recent'] : '0.0'; ?><!--</h1>-->
				<!--								<span class="text-uppercase font-size-sm">Recent Members</span>-->
				<!--							</div>-->
				<!--						</div>-->
				<!--					</div>-->
				<!--				</div>-->
				<!--Net Balance-->
				<div class="col-md-4 text-center">
					<div class="widget-card widget-card-orange">
						<div class="media">
							<div class="widget-icon">
								<i class="icon-cash4 icon-3x opacity-75"></i>
							</div>
							<br>
							<div class="media-body text-right">
								<h3 class="font-weight-semibold mb-0"><?php echo $stats['total_balance'] ? $stats['total_balance'] : '0.0'; ?></h3>
								<span class="text-uppercase font-size-sm">Net Balance</span>
							</div>
						</div>
					</div>
				</div>
				<?php foreach ($level_map as $key=>$level){
					if (array_key_exists($key, $per_level)){?>
						<!--Dynamic Cards-->
						<div class="col-md-4 text-center">
							<div class="widget-card <?php echo ['widget-card-blue','widget-card-orange','widget-card-pink','widget-card-green','widget-card-skyblue','widget-card-slategreen','widget-card-hotpink','widget-card-purple','widget-card-brightblue','widget-card-darkpurple','widget-card-magento'][$key]?> has-bg-image">
								<div class="media">
									<div class="widget-icon">
										<i class="<?php echo ['icon-circle-small','icon-stars','icon-medal-third','icon-medal-second','icon-medal-first','icon-medal2','icon-trophy4','icon-cube','icon-cube4','icon-pyramid2','icon-crown'][$key]?> icon-3x opacity-75"></i>
									</div>
									<br>
									<div class="media-body text-right">
										<h3 class="font-weight-semibold  mb-0"><?php echo $per_level[$key]?></h3>
										<span class="text-uppercase font-size-sm">Level <?= $level['title']?></span>
									</div>
								</div>
							</div>
						</div>
					<?php }}?>
			</div>
		</div>
		<div class="col-xl-4">
			<div class="row">

			</div>
		</div>
		<!--    Transaction Table-->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header header-elements-inline">
					<div class="caption">
						<h5 class="card-title"><i class="icon icon-cogs"></i><?= $report_title ?></h5>
					</div>
				</div>
				<div class="container-fluid" id="msg">
					<div class="portlet-body form">
						<div id="report-page"></div>

						<script type="application/javascript">
							makeReportPage($("#report-page"), "list_transactions?t=<?=$type ?>", {
								datatable: {
									dom: 'Brftip',
									"order": [[ 4, 'desc' ]],
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
											render: function(data){
												return getDateTime(data)
											},
											defaultContent: " - "
										},
									]
								}
							},function(err,data){
								console.log()
								TIK_PAGE_RESPONSE = data['page'];
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

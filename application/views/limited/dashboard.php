<!-- /info alert -->
<?php get_msg(); ?>

<div class="container-fluid">
	<!-- Content area -->
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-warning">
					<h4>Please Note:</h4>
					<h6>&#10004; Complete all 3 steps to activate your account and access of Dashboard.</h6>
					<h6>&#10004; Admin will approve from his end.</h6>
					<h6>&#10004; Once you complete these steps, Login again to get your Dashboard.</h6>
				</div>
			</div>

			<div class="col-md-4">
				<!-- Profile info -->
				<div class="card">
					<div class="card-header bg-transparent header-elements-inline">
						<h5 class="card-title">STEP 1: Upline Donation</h5>
					</div>
					
					<div class="card-body">
						<?php
						if(isset($uplineDonationStatus) && $uplineDonationStatus == TX_STATUS_APPROVE)
						{
						?>
						 <div class="col-md-12">
							<div class="card">
								<div class="card bg-primary-400 p-3">
									<p>
										<h1>Donated</h1>
									</p>
								</div>

								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<div class="media-title font-weight-semibold">Status</div>
											<span class="text-muted">Pending for Approval</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						else if(isset($uplineDonationStatus) && $uplineDonationStatus == TX_STATUS_DONE)
						{
						?>
						 <div class="col-md-12">
							<div class="card">
								<div class="card bg-success-400 p-3">
									<p>
										<h1>Donated</h1>
									</p>
								</div>

								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<div class="media-title font-weight-semibold">Status</div>
											<span class="text-muted">Donation Approved</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						else
						{
						?>
							<div class="col-md-12">
								<div class="card">
									<div class="card bg-danger-400 p-3">
										<p>
											<h1>Pending</h1>
										</p>
									</div>
	
									<div class="card-body">
										<div class="media">
											<div class="media-body">
												<div class="media-title font-weight-semibold">Status</div>
												<span class="text-muted">Donation Pending</span>
											</div>
										</div>
										<br><br>
										<a href="<?= BASE_URL ?>donation/donation2upline" class="btn btn-primary">Donate</a>
									</div>
								</div>
							</div>
						<?php

						}
						?>
					</div>
				</div>
				<!-- /profile info -->
			</div>


			<div class="col-md-4">
				<!-- Profile info -->
				<div class="card">
					<div class="card-header bg-transparent header-elements-inline">
						<h5 class="card-title">STEP 2: Upperline Donation</h5>
					</div>


					<div class="card-body">
						<?php
						if(isset($upperlineDonationStatus) && $upperlineDonationStatus == TX_STATUS_APPROVE)
						{
						?>
						 <div class="col-md-12">
							<div class="card">
								<div class="card bg-primary-400 p-3">
									<p>
										<h1>Donated</h1>
									</p>
								</div>

								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<div class="media-title font-weight-semibold">Status</div>
											<span class="text-muted">Pending for Approval</span>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<?php
						}
						else if(isset($upperlineDonationStatus) && $upperlineDonationStatus == TX_STATUS_DONE)
						{
						?>
						 <div class="col-md-12">
							<div class="card">
								<div class="card bg-success-400 p-3">
									<p>
										<h1>Donated</h1>
									</p>
								</div>

								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<div class="media-title font-weight-semibold">Status</div>
											<span class="text-muted">Donation Approved</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						else
						{
						?>
							<div class="col-md-12">
								<div class="card">
									<div class="card bg-danger-400 p-3">
										<p>
											<h1>Pending</h1>
										</p>
									</div>
	
									<div class="card-body">
										<div class="media">
											<div class="media-body">
												<div class="media-title font-weight-semibold">Status</div>
												<span class="text-muted">Donation Pending</span>
											</div>
										</div>
										<br><br>
										<a href="<?= BASE_URL ?>donation/donation2upperline" class="btn btn-primary">Donate</a>
									</div>
								</div>
							</div>
						<?php

						}
						
						?>
					</div>
				</div>
				<!-- /profile info -->
			</div>


			<div class="col-md-4">
				<!-- Profile info -->
				<div class="card">
					<div class="card-header bg-transparent header-elements-inline">
						<h5 class="card-title">STEP 3: KYC</h5>
					</div>
					
					<div class="card-body">
						<?php
						if(isset($kycStatus) && $kycStatus < 4)
						{
						?>
						 <div class="col-md-12">
							<div class="card">
								<div class="card bg-primary-400 p-3">
									<p>
										<h1>Submitted</h1>
									</p>
								</div>

								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<div class="media-title font-weight-semibold">Status</div>
											<span class="text-muted">Pending for Approval</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						else if(isset($kycStatus) && $kycStatus == 4)
						{
						?>
						 <div class="col-md-12">
							<div class="card">
								<div class="card bg-success-400 p-3">
									<p>
										<h1>Submitted</h1>
									</p>
								</div>

								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<div class="media-title font-weight-semibold">Status</div>
											<span class="text-muted">KYC Approved</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						else
						{
						?>
						<div class="col-md-12">
							<div class="card">
								<div class="card bg-danger-400 p-3">
									<p>
										<h1>Pending</h1>
									</p>
								</div>

								<div class="card-body">
									<div class="media">
										<div class="media-body">
											<div class="media-title font-weight-semibold">Status</div>
											<span class="text-muted">KYC not submitted</span>
										</div>
									</div>
									<br><br>
									<a href="<?= BASE_URL ?>user/kyc" class="btn btn-primary">Upload KYC</a>
								</div>
							</div>
						</div>
						<?php
						}
						?>
					</div>
				</div>
				<!-- /profile info -->
			</div>

		</div>
		<!-- /content area -->
	</div>
</div>

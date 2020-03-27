<?php
function generateID($id)
{
	return $var = str_replace(' ', '_', $id);
}


function getStatus($docs, $doc_name){
	if(isset($docs[$doc_name])){
		if($docs[$doc_name]['status']==1) return 1; //verified
		elseif ($docs[$doc_name]['status']==-1) return -1; // rejected
		elseif($docs[$doc_name]['path']) return 0; // pending
		else return -3; //
	}
	else
		return -2; //first entry

}

$status_cards = array(1=>'verified_card', 0=>'waiting_card', -1=>'rejected_card', -2 => 'upload_doc', -3 =>'upload_doc');
?>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<form class="form-horizontal" method="post" action="<?php echo BASE_URL;; ?>admin/view_user_kyc/<?php echo $uid?>"
				  enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="card screen">
							<div class="" style="text-align: center">
								<?php
								$status = getStatus($docs, 'aadhar_front');
								$status_cards[$status]() ?>
								<h4><b>Aadhaar-Front</b></h4>
								<?php if(in_array($status, array(1,-1,0))){ ?>
									<div class="form-group  px-5">
										<a target="_blank" href="<?php echo base_url($docs['aadhar_front']['path']) ?>" class="badge badge-primary"
										   title="View">View <i class="icon-arrow-right22"></i></a>
										<a  href="<?php echo base_url($docs['aadhar_front']['path']) ?>" class="badge badge-primary" title="View">Download<i
												class="icon-arrow-right22"></i></a>

									</div>
								<?php } ?>

								<?php if(in_array($status, array(-1,0,-2, -3))){
										$meta = isset($docs['aadhar_front']['meta'])?json_decode($docs['aadhar_front']['meta'], true):array("aadhar_front_name"=>'');
									?>
									<div class="form-group  px-5">
										<label>Name</label><input required name="aadhar_front_name" class="form-control empty required"
																  placeholder="Enter Name" value="<?php echo $meta['aadhar_front_name']?>">
										<label>Aadhar Number</label><input required name="aadhar_front_primary_aadhar_no" class="form-control empty required"
																		   placeholder="Enter Aadhar No" value="<?php echo $docs['aadhar_front']['title'] ?>">

									</div>

								<?php }?>
								<?php if(in_array($status, array(-1,0))){ ?>
								<div class="form-check form-check-switchery form-check-switchery-double pt-2">
									<label class="form-check-label">
										Pending
										<input type="checkbox" name="aadhar_front" class="form-check-input-switchery"  data-fouc>
										Verified
									</label>
								</div>
									<?php }?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card screen">
							<div class="" style="text-align: center">
								<?php
								$status = getStatus($docs, 'aadhar_back');
								$status_cards[$status]() ?>
								<h4><b>Adhaar-Back</b></h4>
								<?php if(in_array($status, array(1,-1,0))){ ?>
									<div class="form-group  px-5">
										<a target="_blank" href="<?php echo base_url($docs['aadhar_back']['path']) ?>" class="badge badge-primary"
										   title="View">View <i class="icon-arrow-right22"></i></a>
										<a  href="<?php echo base_url($docs['aadhar_front']['path']) ?>" class="badge badge-primary" title="View">Download<i
												class="icon-arrow-right22"></i></a>

									</div>
								<?php } ?>
								<?php if(in_array($status, array(-1,0,-2,-3))){ ?>

								<?php }?>
								<?php if(in_array($status, array(-1,0))){ ?>
									<div class="form-check form-check-switchery form-check-switchery-double pt-2">
										<label class="form-check-label">
											Pending
											<input type="checkbox" name="aadhar_back" class="form-check-input-switchery"  data-fouc>
											Verified
										</label>
									</div>
								<?php }?>

							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="card screen">
							<div class="" style="text-align: center">
								<?php
								$status = getStatus($docs, 'pan_card');
								$status_cards[$status]() ?>
								<h4><b>PAN Card</b></h4>
								<?php if(in_array($status, array(1,-1,0))){ ?>
									<div class="form-group  px-5">
										<a target="_blank" href="<?php echo base_url($docs['pan_card']['path']) ?>" class="badge badge-primary"
										   title="View">View <i class="icon-arrow-right22"></i></a>
										<a  href="<?php echo base_url($docs['aadhar_front']['path']) ?>" class="badge badge-primary" title="View">Download<i
												class="icon-arrow-right22"></i></a>

									</div>
								<?php } ?>

								<?php if(in_array($status, array(-1,0,-2,-3))){
										$meta = isset($docs['pan_card']['meta'])?json_decode($docs['pan_card']['meta'], true):array("pan_card_name"=>'', "pan_card_dob"=>'');
									?>
									<div class="form-group  px-5">
										<label>Name</label><input required name="pan_card_name"
																  class="form-control empty required" value="<?php echo $meta['pan_card_name']?>"/>
										<label>PAN Card No</label><input required name="pan_card_primary_card_no"
																		 class="form-control empty required" value="<?php echo $docs['pan_card']['title'] ?>"/>
										<label>Date of Birth</label><input required name="pan_card_dob" type="date"
																		   class="form-control empty required" value="<?php echo $meta['pan_card_dob']?>"/>

									</div>
								<?php }?>
								<?php if(in_array($status, array(-1,0))){ ?>
									<div class="form-check form-check-switchery form-check-switchery-double pt-2">
										<label class="form-check-label">
											Pending
											<input type="checkbox" name="pan_card" class="form-check-input-switchery"  data-fouc>
											Verified
										</label>
									</div>
								<?php }?>
							</div>

						</div>
					</div>

					<div class="col-md-6">
						<div class="card screen">
							<div class="" style="text-align: center">
								<?php
								$status = getStatus($docs, 'bank_doc');
								$status_cards[$status]() ?>
								<h4><b>Bank Documents</b></h4>
								<?php if(in_array($status, array(1,-1,0))){ ?>
									<div class="form-group  px-5">
										<a target="_blank" href="<?php echo base_url($docs['bank_doc']['path']) ?>" class="badge badge-primary"
										   title="View">View <i class="icon-arrow-right22"></i></a>
										<a  href="<?php echo base_url($docs['aadhar_front']['path']) ?>" class="badge badge-primary" title="View">Download<i
												class="icon-arrow-right22"></i></a>

									</div>
								<?php } ?>
							</div>
							<?php if(in_array($status, array(-1,0,-2,-3))){
									$meta = isset($docs['bank_doc']['meta'])?json_decode($docs['bank_doc']['meta'], true):array("bank_doc_name"=>'', "bank_doc_ifsc"=>'');
								?>
								<div class="form-group  px-5">
									<label>Name</label><input required name="bank_doc_name" class="form-control empty required"
															  placeholder="Enter Name" value="<?php echo $meta['bank_doc_name']?>"
									/>
									<label>Account Number</label><input required name="bank_doc_primary_acc_no" class="form-control empty required"
																		placeholder="Enter Account Number" value="<?php echo $docs['bank_doc']['title'] ?>"
									/>
									<label>IFSC</label><input required name="bank_doc_ifsc" class="form-control empty required"
															  placeholder="Enter IFSC Code" value="<?php echo $meta['bank_doc_ifsc']?>"
									/>

								</div>
							<?php }?>
							<?php if(in_array($status, array(-1,0))){ ?>
								<div class="form-check form-check-switchery form-check-switchery-double pt-2">
									<label class="form-check-label">
										Pending
										<input type="checkbox" name="bank_doc" class="form-check-input-switchery"  data-fouc>
										Verified
									</label>
								</div>
							<?php }?>
						</div>
					</div>
				</div>


				<div class="offset-10 col-md-2 mt-2 pr-3">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Submit<i
								class="icon-circle-right2 ml-2"></i></button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-4">
			<!-- Simple inline block with icon and button -->
			<div class="card card-body ">
				<div class="media align-items-center align-items-md-start flex-column flex-md-row">
					<a href="#" class="text-teal mr-md-3 mb-3 mb-md-0">
						<i class="icon-question7 text-success-400 border-success-400 border-2 rounded-round p-2"></i>
					</a>

					<div class="media-body text-center text-md-left">
						<h6 class="media-title font-weight-semibold">Guideline for KYC Verification</h6>
						<ul class="list list-unstyled mb-0">
							<li>
								<i class="icon-primitive-dot text-success mr-2"></i>
								Aadhaar Image Required.
							</li>
							<li>
								<i class="icon-primitive-dot text-success mr-2"></i>
								Pan Card Image Required.
							</li>
							<li>
								<i class="icon-primitive-dot text-success mr-2"></i>
								Bank Document Required.
							</li>
							<li>
								<i class="icon-primitive-dot text-success mr-2"></i>
								All images must be clear and ledgible.
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


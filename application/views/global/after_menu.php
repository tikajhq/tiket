<!-- Main content -->
<div class="content-wrapper">
	<!-- Page header -->
	<?php
	$level1 = str_replace('_', ' ', ucfirst($this->uri->segment(2)));
	$level2 = str_replace('_', ' ', ucfirst($this->uri->segment(1)));
	?>
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h1><i class="icon-price-tag2 mr-2"></i> <span
						class="font-weight-semibold"><?PHP echo strtoupper($title); ?></span></h1>

			</div>
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="<?php echo URL_LANDING ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>
					</a>
					<span class="breadcrumb-item active"><?php echo $level2 . ' / ' . $title; ?></span>
				</div>


			</div>
		</div>
	</div>
	<br/>
	<div class="container-fluid" align="center" id="msg">
		<?php if ($this->session->flashdata('msg')): ?>
			<p style="color: darkgreen;background:rgba(0,255,0,0.3);border: 1px solid green;border-radius: 5px 5px 5px 5px"><?php echo $this->session->flashdata('msg'); ?></p>
		<?php endif; ?>
	</div>
	<script type="text/javascript">
		$(document).ready(function () {
			setTimeout(function () {
				$('#msg').fadeOut('fast');
			}, 10000);
		});
	</script>

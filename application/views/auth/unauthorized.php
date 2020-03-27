<style>
	h6 {
		margin-bottom: 0;
	}
</style>
<form class="col-md-4" action="#" method="post">
	<div class="card mb-0  login-card">
		<div class="card-body">
			<div class="row">
				<div class="modalbox error col-lg-12  col-xs-12 center animate text-dark">
					<div class="icon">
						<span class="icon-cross"></span>
					</div>
					<h2>Unfortunately, you cannot access this feature as your permission level doesn't allow it.</h2>
					<?= (isset($_GET['m']) ? ('<h5>' . escapeXSS($_GET['m']) . '</h5>') : '') ?>

					<br/>
					<?= (isset($_GET['from']) ? ('<h6>You tried to access <a href="' . escapeXSS($_GET['from']) . '">' . escapeXSS($_GET['from']) . '</a></h6>') : '') ?>
					<h6>Please contact site admin for more details.</h6>
					<h6 class="change">It is possible the feature is not enabled for this version, if you are product
						owner please contact sales.</h6>


					<?PHP
					//Echo permissions required.
					if (isset($_GET['p'])) {
						echo('<h6 class="change">Permissions Required: ');
						$permissions = (explode(";", $_GET['p']));
						foreach ($permissions as $p)
							echo getConstantsByPrefix("PERMISSION_", intval($p)).'; ';
					}
					?>

				</div>
			</div>

			<?PHP include "powered.php"; ?>
		</div>
	</div>
</form>


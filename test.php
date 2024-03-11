<?php

require_once 'session.php';

$page_group = 'account';

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include '../includes/styles.php'; ?>
	<title>DATALOG - CHANGE PASSWORD</title>
</head>


<body>
	<div id="body_content">
		<?php include '../includes/navmenu.php'; ?>

		<div id="page_header">
			<div class="widget-box" style="margin-top:5px">
				<div class="widget-title">
					<span class="icon">
						<i class="fa  fa-user-o"></i>
					</span>
					<h5>CHANGE PASSWORD</h5>
				</div>
			</div>
		</div>
		<div class="container-fluid" id="page_content">
			<?php include '../includes/alerts.php'; ?>
			<div class="form-cotainer">
				<form class="form-horizontal" method="post" action="../actions/changepass_act.php">
					<div class="row">
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label">Previous Password</label>
								<input type="password" class="form-control" name="ppass" required>

							</div>
						</div>
						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label">New Password </label>
								<input type="password" class="form-control" name="npass" required>

							</div>
						</div>

						<div class="col-md-3 col-sm-12">
							<div class="form-group">
								<label class="control-label">Re-Enter New Password</label>
								<input type="password" class="form-control" name="cpass" required>
							</div>
						</div>

					</div>

					<div class="form-actions">
						<input type="submit" name="save_btn" value="SAVE" class="btn btn-success">
					</div>

				</form>
			</div>
		</div>
	</div>


	<?php include '../includes/scripts.php'; ?>

	<script>
		$(document).ready(function() {
			myresize();
		});
	</script>

</body>

</html>
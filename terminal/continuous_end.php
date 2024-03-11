<?php
require_once 'session.php';
$length = $_GET['length'];
$defect_id = $_GET['defect_id'];
$defect_name = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defect_id'");
$defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defect_id'");

$screen_title = $defect_shortname . ' : ' . $defect_name;

$cd_id = $_GET['cd_id'];
$start_length = GFV("CURDEFECTS", "CD_STARTLENGTH", "CD_ID='$cd_id'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	include 'styles.php';
	header("Content-type: text/html; charset=utf-8");

	?>
	<title>DATALOG FABRIC INSPECTION SYSTEM</title>

	<style>
		.ui_container {
			font-size: 22px;
			font-weight: bold;
		}
	</style>

</head>

<body>

	<div class="full_container">
		<?php include 'fixedblock.php';  ?>
		<div class="ui_container">
			<div class="vertical_center">
				<div class="card" style="width:50vw; margin:0 auto;">
					<div class="card-body">
						<?php
						if (!empty($length) && !empty($defect_id) && !empty($cd_id)) {
						?>
							<form class="form-horizontal" method="POST" action="inspect_entry_act.php">
								<input type="hidden" name="length" value="<?php echo $length; ?>" />
								<input type="hidden" name="inspect_entry_act" value="continuous_end" />
								<input type="hidden" name="defect_id" value="<?php echo $defect_id; ?>" />
								<input type="hidden" name="cd_id" value="<?php echo $cd_id; ?>" />
								<div style="padding:0px 25px;">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label class="screen_title"><?php echo $screen_title; ?></label>
											</div>
											<div class="form-group">
												<label>STARTED AT : <b><?php echo $start_length; ?> M</b></label>
												<br />
												<label><b>END DEFECT?</b></label>
											</div>
										</div>
										<div class="col-6">
											<a href="continuous.php" style="text-align:center;">
												<div class="option_key" style="background-color:red; border-color:red">
													<i class="fa fa-close" style="font-size:40px; padding:10px 30px;"></i>
												</div>
											</a>
										</div>
										<div class="col-6">
											<button class="option_key" type="submit" style="background-color:green; border-color:green">
												<i class="fa fa-check" style="font-size:40px; padding:10px 30px;"></i>
											</button>
										</div>
									</div>
								</div>
							</form>
						<?php
						} else {
						?>
							<div class="apparent-message warning-message" style="width:915px; margin:0 auto;">
								<div class="message-container">
									<div class="apparent-message-icon fa fa-fw fa-2x fa-exclamation-triangle">
									</div>
									<div class="content-container">
										<div class="message-header">
											<span>WRONG INPUT</span>
										</div>
										<div class="message-body">PLEASE GO TO DASHBOARD</div>
									</div>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php include 'scripts.php';  ?>
</body>

</html>
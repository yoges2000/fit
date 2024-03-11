<?php
require_once 'session.php';
$length = round(GFV("STD_MACHINES", "MC_LENGTH", "MC_ID='$glob_mcid'"), 2);

$screen_title = "SHIFT CHNAGE";
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
						if (!empty($length)) {
						?>
							<form class="form-horizontal" method="POST" action="inspect_entry_act.php">
								<input type="hidden" name="length" value="<?php echo $length; ?>" />
								<input type="hidden" name="inspect_entry_act" value="shift_change" />
								<div style="padding:0px 25px;">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label class="screen_title"><?php echo $screen_title; ?></label>
											</div>
											<div class="form-group">
												<label class="control-label required-field"><b>DATE</b></label>
												<input type="date" class="form-control" name="cd_shiftdate" style="font-size:30px; border-color: #007BFF; padding:10px;margin:10px;" required>
											</div>
											<div class="form-group">
												<label class="control-label required-field"><b>SHIFT</b></label>
												<input type="radio" class="defect_radio_option point1 defect_radio_input" name="cd_shiftchange" value="A/C" style="margin-left:5px;" required> A/C </input>
												<input type="radio" class="defect_radio_option point1 defect_radio_input" name="cd_shiftchange" value="C/B" style="margin-left:40px;"> C/B </input>
												<input type="radio" class="defect_radio_option point1 defect_radio_input" name="cd_shiftchange" value="B/A" style="margin-left:40px;"> B/A </input>
											</div>
										</div>
									</div>
									<br />
									<div class="row">
										<div class="col-6">
											<a href="home.php" style="text-align:center;">
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

</body>

<?php include 'scripts.php';  ?>


</html>
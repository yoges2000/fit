<?php
require_once 'session.php';

if (isset($_GET['length'])) {
	$length = $_GET['length'];
} else {
	$length = round(GFV("STD_MACHINES", 'MC_LENGTH', "MC_ID='$glob_mcid'"), 2);
}
$defect_id = $_GET['defect_id'];
$defect_name = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defect_id'");
$defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defect_id'");

$screen_title = $defect_shortname . ' - ' . $defect_name;
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
		<d />iv class="ui_container">
			<div class="vertical_center">
				<div class="card" style="width:70vw; margin:0 auto;">
					<div class="card-body">
						<?php
						if (!empty($length) && !empty($defect_id)) {
						?>
							<form class="form-horizontal" method="POST" action="inspect_entry_act.php">
								<input type="hidden" name="length" value="<?php echo $length; ?>" />
								<input type="hidden" name="inspect_entry_act" value="defect" />
								<input type="hidden" name="defect_id" value="<?php echo $defect_id; ?>" />

								<div class="row">
									<div class="col-8">
										<div style="padding:0px 25px;">
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<label class="screen_title"><?php echo $screen_title; ?></label>
													</div>
													<div class="form-group">
														<label><b>DEFECT POINT</b></label>
														<br />
														<input type="radio" class="defect_radio_option point1 defect_radio_input" name="point" value="1" required>1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</input>
														<input type="radio" class="defect_radio_option point2 defect_radio_input" name="point" value="2">2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</input>
														<input type="radio" class="defect_radio_option point3 defect_radio_input" name="point" value="3">3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</input>
														<input type="radio" class="defect_radio_option point4 defect_radio_input" name="point" value="4">4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</input>
													</div>
													<div class="form-group">
														<label for="width" class="control-label"><b>WIDTH</b></label>
														<input type="text" class="form-control number-input" id="width" name="width" min="0" step="0.01" style="border-color: #007BFF; font-size: 22px; margin:15px;padding:15px">
													</div>
												</div>
												<div class="col-6">
													<a href="defects.php" style="text-align:center;">
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
									</div>
									

									<div class="col-8">
										<div class="right-panel" id="righe-panel">
											<ul id="keypad">
												<li class="letter" data-number="1"><i>1</i></li>
												<li class="letter" data-number="2"><i>2</i></li>
												<li class="letter" data-number="3"><i>3</i></li>

												<li class="letter clearl" data-number="4"><i>4</i></li>
												<li class="letter" data-number="5"><i>5</i></li>
												<li class="letter" data-number="6"><i>6</i></li>

												<li class="letter clearl" data-number="7"><i>7</i></li>
												<li class="letter" data-number="8"><i>8</i></li>
												<li class="letter" data-number="9"><i>9</i></li>


												<li class="letter clearl" data-number="."><i>.</i></li>
												<li class="letter" data-number="0"><i>0</i></li>
												<li class="letter delete"><i class="fa fa-arrow-left"></i></li>
											</ul>
										</div>
									</div>
								</div>
							</form>
						<?php
						} else {
						?>
							<div class="apparent-message warning-message" style="margin:0 auto;">
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
	<script>
		$("[data-number]").on('click', function() {
			var inputNumber = $(".number-input").val() + $(this).data("number");
			$(".number-input").val(inputNumber);
		});

		$(".delete").on('click', function() {
			var inputNumber = $(".number-input").val().slice(0, -1);
			$(".number-input").val("");
			$(".number-input").val(inputNumber);
		});
	</script>
</body>

</html>
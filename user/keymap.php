<?php

require_once 'session.php';
$title = 'Keymap';
$page_group = 'Assignments';
$filename = 'keymap.php';

if (isset($_POST['editbtn'])) {
	$keynumber = $_POST['keynumber'];
	$defect_id = $_POST['defect_id'];

	$kqry = "select KEY_NUMBER from KEYMAP where defect_id='$defect_id'";
	$kres = mysqli_query($fit, $kqry);
	if (mysqli_num_rows($kres) > 0) {
		$krow = mysqli_fetch_assoc($kres);
		$okey = $krow['KEY_NUMBER'];
	}

	$dqry = "select DEFECT_ID from KEYMAP where KEY_NUMBER='$keynumber'";
	$dres = mysqli_query($fit, $dqry);
	if (mysqli_num_rows($dres) > 0) {
		$drow = mysqli_fetch_assoc($dres);
		$odef = $drow['DEFECT_ID'];
	}
	if (isset($okey) && isset($odef)) {

		$qry = "UPDATE KEYMAP SET DEFECT_ID='$odef' WHERE KEY_NUMBER='$okey'";
		$res = mysqli_query($fit, $qry);

		$qry = "UPDATE KEYMAP SET DEFECT_ID='$defect_id' WHERE KEY_NUMBER='$keynumber'";
		$res = mysqli_query($fit, $qry);
	}
}

?>

<!doctype html>

<html lang="en">

<head>

	<?php include '../includes/styles.php'; ?>
	<title><?php echo $title; ?></title>
	<style>
		/* CSS for Fabric Inspector Module*/
		.complete-panel {
			margin: 2px 2px 2px 2px;
			padding: 2px 2px 2px 2px;
			/*height: 560px;
	width:  1000px;*/
			width: 98%;
		}

		.left-panel {
			padding-right: 0px;
		}

		.right-panel {
			padding-left: 0px;
		}

		.batch-display-container {
			background-color: #454545;
			border-radius: 20px;
			padding: 2px 2px 2px 2px;
			height: 100px;
		}

		.batch-display-content {
			padding: 2px;
			color: #fff;
			text-align: center;
			font-size: 15px;
			font-weight: bold;
		}

		.borderless-table td,
		.borderless-table th {
			border: none;
			color: #fff;
			text-align: left;
		}

		.defect-display-container {
			background-color: #454545;
			border-radius: 20px;
			padding: 2px 2px 2px 2px;
			margin-top: 3px;
			height: 450px;
			overflow: auto;

		}

		.defect-display-content {
			padding: 2px;
			color: #fff;
			text-align: center;
			position: relative;
			font-size: 14px;
			font-weight: bold;
		}

		.length-display-container {
			background-color: #454545;
			border-radius: 20px;
			padding: 2px 2px 2px 2px;
			height: 100px;
			vertical-align: middle;
			text-align: center;
		}

		.length-display-content {
			padding: 2px;
			color: #fff;
			text-align: center;
			text-transform: uppercase;
			font-weight: bold;
			vertical-align: middle;
		}

		.defect-key-container {
			border-left: inset;
			border-top: inset;
			border-right: outset;
			border-bottom: outset;
			border-color: #0000cc;
			border-radius: 20px;
		}

		.defect-key-content {
			padding: 0px;
			margin: 0px;
			text-align: center;
		}

		.option-key {
			color: #fff;
			background-color: #007bff;
			margin: 1px 0px;
			border-color: #007bff;
			border-radius: 10px;
			width: 100%;
			min-height: 70px;
			max-height: 75px;
		}

		.defect-key {
			color: #fff;
			background-color: #007bff;
			margin: 0px 0px 2px 0px;
			padding: 0px;
			border-color: #007bff;
			border-radius: 10px;
			min-width: 120px;
			max-width: 120px;
			min-height: 75px;
			max-height: 80px;
		}

		.defect-abbrv {
			text-transform: uppercase;
			vertical-align: middle;
			text-align: center;
			font-size: 16px;
			font-weight: bold;
		}

		.defect-name {
			vertical-align: middle;
			text-align: center;
			font-size: 14px;
			font-weight: bold;
		}

		a.disabled {
			pointer-events: none;
			cursor: default;
		}

		.input-append .add-on:last-child,
		.input-append .btn:last-child {
			border-radius: 0px;
			padding: 6px 5px 2px;
		}

		.input-prepend input,
		.input-append input,
		.input-prepend input[class*="span"],
		.input-append input[class*="span"] {
			width: none;
		}

		.input-append input,
		.input-append select,
		.input-prepend span,
		.input-prepend input {
			border-radius: 0px !important;
		}
	</style>
</head>

<body>
	<div class="page">
		<?php include '../includes/navmenu.php'; ?>
		<div class="page-wrapper">
			<div class="container-fluid">
				<!-- Page title -->
				<div class="page-header d-print-none">
					<div class="row align-items-center">
						<div class="col">
							<!-- Page pre-title -->

							<h2 class="page-title">
								<?php echo $title; ?>

							</h2>
						</div>
						<!-- Page title actions -->
						<div class="col-auto ms-auto d-print-none">
							<div class="btn-list">

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="page-body">
				<div class="container-fluid">
					<?php
					if (!isset($_GET['more']) && !isset($_GET['continuous'])) {
					?>
						<center>
							<div class="complete-panel" id="element">
								<div class="row">
									<!-- Display Panel Area -->
									<div class="col-6">
										<div class="left-panel" id="left-panel">
											<div class="info-content" id="info-content">
												<div class="row">
													<div class="col-4">
														<div class="length-display-container">
															<div class="length-display-content">
																<div class="row">
																	<div class="col-12">
																		<h4>Length</h4>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-8">
														<div class="batch-display-container">
															<div class="batch-display-content">
																<h4>Short/Batch Details</h4>
															</div>
														</div>
													</div>
												</div>

												<div class="defect-display-container">
													<div class="defect-display-content">
														<h4>Defect Details</h4>
													</div>
												</div>
											</div>
										</div>
									</div>


									<div class="col-6">
										<div class="right-panel" id="righe-panel">
											<?php
											// Code For defect Button Arrangments
											$per_row = 4; //No of Keys Per Row
											$no_of_rows = 6;
											$row_no = 1;

											for ($i = 1; $i <= $no_of_rows; $i++) {
												$row_start = ($row_no - 1) * $per_row;
												$query = "SELECT * FROM KEYMAP ORDER BY KEY_NUMBER ASC LIMIT $row_start,$per_row";
												$res = mysqli_query($fit, $query);
												echo '<div class="defect-key-content">';
												echo '<div class="row">';
												while ($row = mysqli_fetch_assoc($res)) {
													$defect_id1 = $row['DEFECT_ID'];
													if ($defect_id1 == 0 || $defect_id1 == '' || $defect_id1 == NULL) {
														echo '<div class="col-3">';
														echo '<button class="key_edit defect-key" data-id="' . $row['KEY_NUMBER'] . '"><h5 class="defect-abbrv">' . $row["KEY_NUMBER"] . '</h5><small  class="defect-name">' . $row["KEY_NAME"] . '</small></button>';
														echo '</div>';
													} else {
														$query1 = "SELECT * FROM STD_DEFECTS WHERE DEFECT_ID='$defect_id1'";
														$res1 = mysqli_query($fit, $query1);
														while ($row1 = mysqli_fetch_assoc($res1)) {
															echo '<div class="col-3">';
															echo '<button class="key_edit defect-key" style="background-color: ' . $row1["DEFECT_COLOR"] . ';border-color: ' . $row1["DEFECT_COLOR"] . ';" data-id="' . $row['KEY_NUMBER'] . '"><h5 class="defect-abbrv">' . $row1["DEFECT_SHORTNAME"] . '</h5><small  class="defect-name">' . $row1["DEFECT_NAME"] . '</small></button>';
															echo '</div>';
														}
													}
												}
												$row_no = $row_no + 1;
												echo '</div>';
												echo '</div>';
											}

											?>
											<div class="row">
												<div class="col-3" style="padding:5px 0px 0px 20px;">
													<button class="option-key">
														<div class="defect-abbrv"></div><span class="defect-name"></span>
													</button>
												</div>
												<!--
											<div class="col-6" style="padding:5px 0px 0px 20px;">
												<button class="option-key">
													<div class="defect-abbrv"></div><span  class="defect-name"></span>
												</button>
											</div>
											-->
												<div class="col-3" style="padding:5px 0px 0px 20px;">
													<button class="option-key">
														<div class="defect-abbrv"></div><span class="defect-name"></span>
													</button>
												</div>
												<div class="col-3" style="padding:5px 0px 0px 20px;">
													<a href="keymap.php?continuous=1" class="button">
														<button class="option-key">
															<div class="defect-abbrv">CONTINUOUS DEFECTS</div><span class="defect-name"></span>
														</button>
													</a>
												</div>
												<div class="col-3" style="padding:5px 0px 0px 20px;">
													<a href="keymap.php?more=1">
														<button class="option-key">
															<div class="defect-abbrv">MORE</div><span class="defect-name"></span>
														</button>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</center>
					<?php
					} else if (isset($_GET['more']) && !isset($_GET['continuous'])) {
					?>
						<center>
							<div class="complete-panel" id="element">
								<div class="row">

									<?php
									// Code For defect Button Arrangments
									$per_row = 6; //No of Keys Per Row
									$no_of_rows = 9; // First Four rows neglected						
									$row_no = 5;

									for ($i = 5; $i <= $no_of_rows; $i++) {
										$row_start = ($row_no - 1) * $per_row;
										if ($i == $no_of_rows) {
											$per_row = 5;
										}
										$query = "SELECT * FROM KEYMAP ORDER BY KEY_NUMBER ASC LIMIT $row_start,$per_row";
										$res = mysqli_query($fit, $query);
										while ($row = mysqli_fetch_assoc($res)) {
											$defect_id1 = $row['DEFECT_ID'];
											if ($defect_id1 == 0 || $defect_id1 == '' || $defect_id1 == NULL) {
												echo '<div class="col-2">';
												echo '<button class="key_edit defect-key" data-id="' . $row['KEY_NUMBER'] . '"><h5 class="defect-abbrv">' . $row["KEY_NUMBER"] . '</h5><small  class="defect-name">' . $row["KEY_NAME"] . '</small></button>';
												echo '</div>';
											} else {
												$query1 = "SELECT * FROM STD_DEFECTS WHERE DEFECT_ID='$defect_id1' AND DEFECT_TYPE=1";
												$res1 = mysqli_query($fit, $query1);
												while ($row1 = mysqli_fetch_assoc($res1)) {
													echo '<div class="col-2">';
													echo '<button class="key_edit defect-key" style="background-color: ' . $row1["DEFECT_COLOR"] . ';border-color: ' . $row1["DEFECT_COLOR"] . ';" data-id="' . $row['KEY_NUMBER'] . '"><h5 class="defect-abbrv">' . $row1["DEFECT_SHORTNAME"] . '</h5><small  class="defect-name">' . $row1["DEFECT_NAME"] . '</small></button>';
													echo '</div>';
												}
											}
										}
										$row_no = $row_no + 1;
									}

									?>
									<div class="col-2">
										<a href="keymap.php" class="button">
											<button class="option-key">
												<div class="defect-abbrv">BACK</div><span class="defect-name"></span>
											</button>
										</a>
									</div>
								</div>
							</div>
						</center>
					<?php
					} else {
					?>
						<center>
							<div class="complete-panel" id="element">
								<div class="row">

									<?php
									// Code For defect Button Arrangments
									$per_row = 6; //No of Keys Per Row
									$no_of_rows = 16; // First two rows neglected						
									$row_no = 9;

									for ($i = 10; $i <= $no_of_rows; $i++) {
										$row_start = ($row_no - 1) * $per_row;
										if ($i == $no_of_rows) {
											$per_row = 5;
										}
										$query = "SELECT * FROM KEYMAP ORDER BY KEY_NUMBER ASC LIMIT $row_start,$per_row";
										$res = mysqli_query($fit, $query);
										while ($row = mysqli_fetch_assoc($res)) {
											$defect_id1 = $row['DEFECT_ID'];
											if ($defect_id1 == 0 || $defect_id1 == '' || $defect_id1 == NULL) {
												echo '<div class="col-2">';
												echo '<button class="key_edit defect-key" data-id="' . $row['KEY_NUMBER'] . '"><h5 class="defect-abbrv">' . $row["KEY_NUMBER"] . '</h5><small  class="defect-name">' . $row["KEY_NAME"] . '</small></button>';
												echo '</div>';
											} else {
												$query1 = "SELECT * FROM STD_DEFECTS WHERE DEFECT_ID='$defect_id1'";
												$res1 = mysqli_query($fit, $query1);
												while ($row1 = mysqli_fetch_assoc($res1)) {
													echo '<div class="col-2">';
													echo '<button class="key_edit defect-key" style="background-color: ' . $row1["DEFECT_COLOR"] . ';border-color: ' . $row1["DEFECT_COLOR"] . ';" data-id="' . $row['KEY_NUMBER'] . '"><h5 class="defect-abbrv">' . $row1["DEFECT_SHORTNAME"] . '</h5><small  class="defect-name">' . $row1["DEFECT_NAME"] . '</small></button>';
													echo '</div>';
												}
											}
										}
										$row_no = $row_no + 1;
									}

									?>
									<div class="col-2">
										<a href="keymap.php" class="button">
											<button class="option-key">
												<div class="defect-abbrv">BACK</div><span class="defect-name"></span>
											</button>
										</a>
									</div>
								</div>
							</div>
						</center>
					<?php
					}
					?>
				</div>
			</div>

		</div>
	</div>
	<!-- THIS MODEL IS FOR KEYMAP-->

	<div class="modal modal-blur fade" id="keymap" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">ASSIGN KEY FOR DEFECT</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="editform" class="form-horizontal" method="POST" action="">
					<div class="modal-body">

						<div class="mb-3">


							<select class="selct2box" id="defect_select" name="defect_id">
								<option value="">Select defect Name</option>
								<?php
								if (isset($_GET['continuous'])) {
									$where_qry = 'DEFECT_TYPE = 2';
								} else {
									$where_qry = 'DEFECT_TYPE = 1';
								}
								$qry = "SELECT * FROM STD_DEFECTS WHERE $where_qry ORDER BY DEFECT_ID ASC";
								$res = mysqli_query($fit, $qry);
								if ($res && mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {

										echo '<option value="' . $row['DEFECT_ID'] . '">' . $row['DEFECT_SHORTNAME'] . ' : ' . $row['DEFECT_NAME'] . '</option>';
									}
								} else {
									echo '<option value="">defect available</option>';
								}
								?>

							</select>
						</div>
						<div class="mb-3">
							<label class="form-label">Key Number</label>
							<input type="text" class="form-control" id="keynumber" name="keynumber" readonly="readonly">
						</div>
					</div>

					<div class="modal-footer">
						<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal"> Cancel</a>
						<button type="submit" class="btn btn-theme" name="editbtn"><i class="fa fa-save"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>





	<?php include '../includes/scripts.php'; ?>
	<script>
		//$("#defect_select").select2();
		$('.key_edit').click(function(e) {
			e.preventDefault();
			$('#keymap').modal('show');
			var key_number = $(this).data('id');
			$('#keynumber').val(key_number);
		});
	</script>
</body>

</html>
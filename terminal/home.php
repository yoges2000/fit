<?php
require_once 'session.php';
$screen_title = "DASHBOARD";
$mc_name = GFV("STD_MACHINES", "MC_NAME", "MC_ID='$glob_mcid'");
$glob_scanner_running=true;
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

	</style>
</head>

<body>
	<div class="full_container">
		<?php include 'fixedblock.php';  ?>
		<div class="ui_container">
			<?php
			$roll_id = GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
			$parentid = GFV("STD_MACHINES", "MC_PARENTID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
			if ($glob_scanner_running == true && !empty($roll_id) && intval($roll_id) > 0) {
			?>
				<div class="total_sections_area">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="single_section_area">
									<div class="after_start_content" id="after_start_content">
										<div class="info_container">
											<div class="info_content">
												<div class="row">
													<div class="col-3">
														<div class="length_container">
															<div class="length_content">
																<div class="row">
																	<div class="col-12">
																		<div class="length_title">
																			<strong>Length</strong>
																		</div>
																		<div class="length_value">
																			<strong id="getlength" style="display:none;"></strong>
																			<input type="number" name="storelen" id="storelen" value="" style="width: 115px;height: 46px;background: none;color: #fff;border: none;" onchange="uplen(this.value)"/>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-9">
														<div class="batch_container">
															<div class="batch_content">
																<?php
																$qry1 = "SELECT * FROM ROLL INNER JOIN STDSTYLE ON ROLL_BATCHID=STYLE_ID WHERE ROLL_ID ='$parentid'";
																$res1 = mysqli_query($fit, $qry1);
																if ($res1 && mysqli_num_rows($res1) > 0) {
																	while ($row1 = mysqli_fetch_assoc($res1)) {
																		$style = $row1['STYLE'];
																		$ppi = $row1['PPCM'];
																		$width = $row1['WIDTH'];
																		$descr = $row1['DESCR'];
																		$roll_number= $row1['ROLL_NUMBER'];
																		$roll_loom_no = $row1['ROLL_LOOM_NO'];
																		
																		$roll_inspid = $row1['ROLL_INSP_ID'];
																		$roll_doff_date = $row1['ROLL_DOFF_DATE'];
																		$roll_doff_shift = $row1['ROLL_DOFF_SHIFT'];
																		$roll_doff_length = $row1['ROLL_DOFF_LENGTH'];
																		
																		
																		$bal_length=$roll_doff_length - GFV("ROLL", "sum(ROLL_LENGTH)", "'$parentid' in (`ROLL_ID`,`ROLL_PARENTID`)");
																		//$bal_length=$roll_doff_length - GFV("STD_MACHINES", "sum(MC_LENGTH)", "'$parentid' in (`MC_ROLL_ID`,`MC_PARENTID`)");
																		if ($bal_length<0){
																		    $bal_length=0;
																		}
																	}
																	echo '<table class="borderless_table" width="100%">';
																	echo '<tr>';
																	echo '<td>SORT</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . $style . '</td>';
																	echo '<td>Cons</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . $descr . '</td>';
																	echo '</tr>';

																	echo '<tr>';
																	echo '<td>ROLL</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . $roll_number . '</td>';
																	echo '<td>SUBROLL</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . GFV("ROLL", "ROLL_NUMBER", "ROLL_ID='$roll_id'") . '</td>';
																	echo '</tr>';

																	echo '<tr>';
																	echo '<td colspan="1"> ROLL LENGTH :</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . $roll_doff_length . '</td>';
																	echo '<td>WIDTH</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . round($width) . '</td>';
																	echo '</tr>';
																	echo '<tr>';
																	echo '<td colspan="1"> BAL LENGTH :</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td id="ballength">' . round($bal_length,2) . '</td>';
																	echo '<td>Total Points</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . GFV("curdefects", "sum(CD_POINT)", "CD_ROLL_ID='$roll_id'") . '</td>';
																	echo '</tr>';
																	echo '<tr>';
																	echo '<td>Loom No.</td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td>' . $roll_loom_no . '</td>';
																	echo '<td></td>';
																	echo '<td>&nbsp;:&nbsp;</td>';
																	echo '<td></td>';
																	echo '</tr>';
																	
																	echo '</table>';
																} else {
																	echo '<div>ROLL Details Not Found</div>';
																}

																?>

															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="defect_container">
											<div class="defect_content">
												<div class="row">
													<div class="col-12">
														<?php
														$qry2 = "SELECT * FROM CURDEFECTS INNER JOIN ROLL ON CD_ROLL_ID=ROLL_ID WHERE (CD_PARENTID='$parentid' OR CD_ROLL_ID=$roll_id) ORDER BY CD_ID DESC";
														$res2 = mysqli_query($fit, $qry2);
														if ($res2 && mysqli_num_rows($res2) > 0) {
															echo '<table class="table borderless_table" style="font-size: 11px;">';
															echo '<thead>';
															echo '<tr>';
															echo '<th style="text-align:center;">Particulars</th>';
															echo '<th style="text-align:center;">Detail</th>';
															echo '<th style="text-align:center;">Roll</th>';
															echo '<th style="text-align:center;">Length</th>';
															echo '<th style="text-align:center;">End</th>';
															echo '<th style="text-align:center;">Points</th>';
															echo '<th style="text-align:center;">Width</th>';
															echo '<th style="text-align:center;">SYMBOL</th>';
															echo '<th style="text-align:center;">Action</th>';
															echo '</tr>';
															echo '</thead>';
															echo '<tbody>';
															while ($row2 = mysqli_fetch_assoc($res2)) {
																
																$cd_id = $row2['CD_ID'];
																$cd_type = $row2['CD_TYPE'];
																$cd_startlength = round($row2['CD_STARTLENGTH']);
																$defect_id = $row2['CD_DEFECT'];
																$point = $row2['CD_POINT'];
																$width = $row2['CD_WIDTH'];
																$defect_symbol = GFV("std_defects", "DEFECT_SYMBOL", "DEFECT_ID='$defect_id'");
																$defect_color = GFV("std_defects", "DEFECT_COLOR", "DEFECT_ID='$defect_id'");
																$subroll = !empty($row2['ROLL_SUBNUMBER']) ? $row2['ROLL_SUBNUMBER'] : '-';
																switch ($cd_type) {
																	case 1:
																		$defect_name = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defect_id'");
																		$defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defect_id'");
																		$cd_endlength =  '-';
																		break;
																	case 2:
																		$defect_name = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defect_id'");
																		$defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defect_id'");
																		$cd_endlength =  round($row2['CD_ENDLENGTH']);
																		if (empty($cd_endlength)) {
																			$cd_endlength = '<span style="color:red; font-weight:bold">ACTIVE</span>';
																		}
																		break;
																	
																	case 4:
																		$scissors = '<span>--</span><i class="fa fa-scissors" aria-hidden="true"></i><span>--</span>';
																		$defect_name = $scissors;
																		$defect_shortname = $scissors;
																		//$point = $scissors;
																		$cd_endlength = '<span class="text-primary">' . $row2['CD_BATCHROLL'] . '</span>';;
																		$defect_symbol = 'scissors';
																		break;
																}

																echo '<tr>';
																echo '<td>' . $defect_name . '</td>';
																echo '<td style="text-align:center;">' . $defect_shortname . '</td>';
																echo '<td style="text-align:center;">' . $subroll . '</td>';
																echo '<td style="text-align:center;">' . $cd_startlength . '</td>';
																echo '<td style="text-align:center;">' . $cd_endlength . '</td>';
																if ($defect_symbol == 'scissors') {
																	echo '<td style="text-align:center;">' . $scissors . '</td>';
																} else {
																echo '<td style="text-align:center;">' . $point . '</td>';
																}
																if ($defect_symbol == 'scissors') {
																	echo '<td style="text-align:center;">' . $scissors . '</td>';
																} else {
																echo '<td style="text-align:center;">' . $width . '</td>';
																}
																echo '<td style="text-align:center;">';
																if ($defect_symbol == 'scissors') {
																	echo $scissors;
																} else {
																	echo '<i class="fa ' . $defect_symbol . '" style="color:' . $defect_color . '; font-size:15px;" aria-hidden="true"></i>';
																}
																echo '</td>';
																echo '<td style="text-align:center;">';
																if ($defect_symbol == 'scissors') {
																	//echo $scissors;
																} else { ?>
																	<a href="defect_delete.php?defect_id=<?php echo $cd_id; ?>" onclick="return confirm('Are you sure you want to delete this Defect?');"><i class='fa fa-trash-o' aria-hidden='true' style='color: red;font-size: 15px;' ></i></a>
																<?php }
																echo '</td>';
																
																echo '</tr>';
															}
															echo '</tbody>';
															echo '</table>';
														} else {
															echo '<div>Defect Not Found</div>';
														}
														?>
													</div>
												</div>
											</div>
										</div>

										<div class="action_container">
											<div class="action_content">
												<div class="row">
													<div class="col-3">
														<a href="defects.php">
															<button class="home_option_key">
																<div class="home_option_key_text">DEFECTS</div></span>
															</button>
														</a>
													</div>
													<div class="col-3">
														<a href="continuous.php">
															<button class="home_option_key">
																<div class="home_option_key_text">CONTINUOUS DEFECTS</div></span>
															</button>
														</a>
													</div>
													<div class="col-3">
														<a href="rollcut.php">
															<button class="home_option_key">
																<div class="home_option_key_text">ROLL CUT</div></span>
															</button>
														</a>
													</div>
													<div class="col-3">
														<a href="rollend.php">
															<button class="home_option_key" style="background: red;">
																<div class="home_option_key_text">ROLL END</div>
															</button>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="defect_key_container1" >
									<div class="defect_key_content" style="padding: 0px auto">
										<div class="row">
										
											<div class="col-6">
											
												<Strong class="inspector-name"><?php echo GFV("INSPECTORS", "INSP_NAME", "INSP_ID ='" . $glob_inspid . "'");; ?></strong>
											</div>
											<div class="col-6">
												<h6 style="color:#FFFFFF">
													
												<a href="entry.php"  class="btn btn-primary">Entry</a>
												<a href="logout.php" class="btn btn-primary">LOGOUT</a>

												</h6>
											</div>
										</div>
									</div>
								</div>

								<div class="defect_key_container">
									<div class="defect_key_content">
										<div class="row">
											<?php
											// Code For defect Button Arrangments
											$per_row = 5; //No of Keys Per Row
											$no_of_rows = 8; // First two rows neglected						
											$row_no = 1;

											for ($i = 1; $i <= $no_of_rows; $i++) {
												$row_start = ($row_no - 1) * $per_row;
												$query = "SELECT *, STD_DEFECTS.DEFECT_ID FROM KEYMAP INNER JOIN STD_DEFECTS ON KEYMAP.DEFECT_ID=STD_DEFECTS.DEFECT_ID WHERE DEFECT_VALID=1 AND DEFECT_TYPE=1 ORDER BY KEY_NUMBER ASC LIMIT $row_start,$per_row";
												$res = mysqli_query($fit, $query);

												while ($row = mysqli_fetch_assoc($res)) {
													$defect_id1 = $row['DEFECT_ID'];
													if ($defect_id1 == 0 || $defect_id1 == '' || $defect_id1 == NULL) {
														//echo '<div class="col-2">';
														//echo '<button class="defect_key" id="'.$row["KEY_NAME"].'" disabled><div class="defect_abbrv"></div><span  class="defect_name"></span></button>';
														//echo '</div>';
													} else {
														$query1 = "SELECT * FROM STD_DEFECTS WHERE DEFECT_ID='$defect_id1'";
														$res1 = mysqli_query($fit, $query1);
														while ($row1 = mysqli_fetch_assoc($res1)) {
															echo '<div class="col-3" style="width: 20%;">';
															echo '<a href="defect_point.php?defect_id=' . $row1['DEFECT_ID'] . '">';
															echo '<button class="defect_key" style="background-color: ' . $row1["DEFECT_COLOR"] . ';border-color: ' . $row1["DEFECT_COLOR"] . ';" data-id="' . $row1['DEFECT_ID'] . '"><div class="defect_abbrv">' . $row1["DEFECT_SHORTNAME"] . '</div><span  class="defect_name">' . $row1["DEFECT_NAME"] . '</span></button>';
															echo '</a>';
															echo '</div>';
														}
													}
												}
												$row_no = $row_no + 1;
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			} else if($glob_scanner_running == true ){
			?>
				<div class="vertical_center">
					<div class="card" style="width:50vw; margin:0 auto;">
						<div class="card-body">
							<div class="new_roll_btn_container">
								<a href="rollstart.php">
									<button class="new_roll_btn">START A NEW ROLL</button>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="fixed-bottom">
					<div class="row">
						<div class="col-12">
							<div class="text-center" style="padding-bottom:10px;">
								<h3 style="margin-top: 15px; color:#FFFFFF">
									<strong class="inspector-welcome">Logged in as: </strong>
									<Strong class="inspector-name"><?php echo GFV("INSPECTORS", "INSP_NAME", "INSP_ID ='" . $glob_inspid . "'"); ?></strong>
								</h3>
								<a href="logout.php">
									<button class="defect_key">
										<div class="defect_abbrv">LOGOUT</div></span>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php
			}else{
			?>
    			<div class="vertical_center">
    				<div class="apparent-message warning-message">
    				<div class="message-container">
    					<div class="apparent-message-icon fa fa-fw fa-2x fa-exclamation-triangle">
    					</div>
    					<div class="content-container">
    						<div class="message-header">
    							<span>SCANNER ERROR</span>
    						</div>
    						<div class="message-body">THE SCANNER IS CLOSED. PLEASE RUN THE SCANNER</div>
    					</div>
    				</div>
    			 </div>
    			</div>
			
			<?php 
			//header("Refresh:3");
			}?>

		</div>
	</div>

	
	<?php include 'scripts.php';  ?>
</body>



<script>

</script>

</html>
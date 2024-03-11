<?php
require_once 'session.php';

$length = round(GFV("STD_MACHINES", "MC_LENGTH", "MC_ID='$glob_mcid'"), 2);

$childid = GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
$parentid = GFV("STD_MACHINES", "MC_PARENTID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
$screen_title = GFV("ROLL", "ROLL_NUMBER", "ROLL_ID='$parentid'") . " - " . GFV("ROLL", "ROLL_NUMBER", "ROLL_ID='$childid'");
$entry_screen = false;

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
		.vertical_inner {
			font-size: 22px;
			font-weight: bold;
			width: 90vw;
		}

		.defect_radio_lable {
			font-size: 20px;
			padding-right: 30px;
		}


		.funkyradio div {
			clear: both;
			overflow: hidden;
		}

		.funkyradio label {
			width: 100%;
			border-radius: 3px;
			border: 1px solid #D1D3D4;
			font-weight: normal;
		}

		.funkyradio input[type="radio"]:empty {
			display: none;
		}

		.funkyradio input[type="radio"]:empty~label {
			position: relative;
			line-height: 2em;
			text-indent: 3.25em;
			margin-top: 0.25em;
			cursor: pointer;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		.funkyradio input[type="radio"]:empty~label:before {
			position: absolute;
			display: inline-block;
			top: 0;
			bottom: 0;
			left: 0;
			content: '';
			width: 2.5em;
			background: #D1D3D4;
			border-radius: 3px 0 0 3px;
		}

		.funkyradio input[type="radio"]:hover:not(:checked)~label {
			color: #888;
		}

		.funkyradio input[type="radio"]:hover:not(:checked)~label:before {
			content: '\2714';
			text-indent: .9em;
			color: #C2C2C2;
		}

		.funkyradio input[type="radio"]:checked~label {
			color: #337ab7;
		}

		.funkyradio input[type="radio"]:checked~label:before {
			content: '\2714';
			text-indent: .9em;
			color: #333;
			background-color: #ccc;
		}

		.funkyradio input[type="radio"]:focus~label:before {
			box-shadow: 0 0 0 3px #999;
		}


		.funkyradio-primary input[type="radio"]:checked~label:before {
			color: #fff;
			background-color: #337ab7;
		}
	</style>


	<style>
		#keyboard-container {
			margin: 10px auto;
			width: 950px;
			padding-left: 20px;
		}

		#keyboard {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		#keyboard li {
			float: left;
			margin: 0 5px 5px 0;
			width: 52px;
			height: 60px;
			line-height: 60px;
			text-align: center;
			background: #fff;
			border: 1px solid #f9f9f9;
			border-radius: 5px;
			-webkit-border-radius: 5px;
		}

		.capslock,
		.tab,
		.left-shift {
			clear: left;
		}

		#keyboard .tab,
		#keyboard .delete {
			width: 70px;
		}

		#keyboard .capslock {
			width: 100px;
		}

		#keyboard .return {
			width: 95px;
		}

		#keyboard .left-shift {
			width: 130px;
		}

		#keyboard .right-shift {
			width: 130px;
		}

		.lastitem {
			margin-right: 0;
		}

		.uppercase {
			text-transform: uppercase;
		}

		#keyboard .space {
			clear: left;
			width: 830px;
		}

		.on {
			display: none;
		}

		#keyboard li:hover {
			position: relative;
			top: 1px;
			left: 1px;
			border-color: #e5e5e5;
			cursor: pointer;
		}
	</style>

</head>

<body>

	<div class="full_container">
		<?php include 'fixedblock.php';  ?>
		<div class="ui_container">
			<div class="vertical_center">
				<div class="card" style="width:90vw; margin:0 auto;">
					<div class="card-body">
						<?php
						if (!empty($length)) {
							//Check weather any active defects avalable
							$roll_id = GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
							$qry2 = "SELECT * FROM CURDEFECTS INNER JOIN ROLL ON CD_ROLL_ID=ROLL_ID WHERE CD_ROLL_ID='$roll_id' AND CD_TYPE=2 AND (ROUND(CD_ENDLENGTH)=0 OR ROUND(CD_POINT)=0) ORDER BY CD_ID DESC";
							$res2 = mysqli_query($fit, $qry2);
							if ($res2 && mysqli_num_rows($res2) > 0) {
						?>
								<div style="text-align:center;">
									<?php
									while ($row2 = mysqli_fetch_assoc($res2)) {
										$cd_id = $row2['CD_ID'];
										$start_length = round($row2['CD_STARTLENGTH']);
										$defectid = $row2['CD_DEFECT'];
										$defectname = GFV("std_defects", "DEFECT_NAME", "DEFECT_ID='$defectid'");
										$defect_shortname = GFV("std_defects", "DEFECT_SHORTNAME", "DEFECT_ID='$defectid'");
										echo '<div>' . $defectname . '(' . $defect_shortname . ')</div>';
									}
									?>
									</br>
									<div style="font-weight:300; font-size:16px;">PLEASE CLOSE THE DEFECTS MENTIONED ABOVE BEFORE ROLL END</div>
									</br>
									<a href="continuous.php">
										<div class="btn btn-primary">
											<div class="option_key_text">GO TO CONTINUOUS DEFECTS</div>
										</div>
									</a>
								</div>
							<?php
							} else {
								$entry_screen = true;
							?>
								<form class="form-horizontal" id="rollend_form" method="POST" action="rollend_act.php">
									<input type="hidden" name="length" value="<?php echo $length; ?>" />
									<input type="hidden" name="rollend_act" value="rollend" />
									<input type="hidden" name="roll_id" value="<?php echo $roll_id; ?>" />
									<div style="padding:5px 25px;">
										<div class="row">
											<div class="col-6">
												<div class="funkyradio">
												<div class="form-group">
													<span class="screen_title">ROLL END- <?php echo $screen_title; ?></span>
												</div>
													<div class="funkyradio-primary">
														<input type="radio" name="remark" id="radio1" value="Pass" required />
														<label for="radio1">
															Pass
														</label>
													</div>
													
													<div class="funkyradio-primary">
														<input type="radio" name="remark" id="radio3" value="Rejected" />
														<label for="radio3">
															Rejected
														</label>
													</div>
													
												</div>
											</div>
											

											<div class="col-6">
												<label><b>NOTE</b></label>
												<textarea class="form-control focus" id="note" name="note" rows="4"></textarea>
												</br>
												<div class="row">
													<div class="col-6">
														<a href="home.php" style="text-align:center;">
															<div class="option_key" style="background-color:red; border-color:red">
																<i class="fa fa-close" style="font-size:40px; padding:10px 30px;"></i>
															</div>
														</a>
													</div>
													<div class="col-6">
														<div class="option_key" id="rollend_btn" data-bs-toggle="modal" data-bs-target="#confirmmodal" style="text-align:center; background-color:green; border-color:green">
															<i class="fa fa-check" style="font-size:40px; padding:10px 30px;"></i>
														</div>
													</div>
													<button type="submit" style="display:none;"></button>
												</div>
											</div>
										</div>
								</form>
							<?php
							}
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
			<?php
			if ($entry_screen == true) {
			?>
				<div id="keyboard-container">
					<ul id="keyboard">
						<li class="symbol"><span class="off">`</span><span class="on">~</span></li>
						<li class="symbol"><span class="off">1</span><span class="on">!</span></li>
						<li class="symbol"><span class="off">2</span><span class="on">@</span></li>
						<li class="symbol"><span class="off">3</span><span class="on">#</span></li>
						<li class="symbol"><span class="off">4</span><span class="on">$</span></li>
						<li class="symbol"><span class="off">5</span><span class="on">%</span></li>
						<li class="symbol"><span class="off">6</span><span class="on">^</span></li>
						<li class="symbol"><span class="off">7</span><span class="on">&amp;</span></li>
						<li class="symbol"><span class="off">8</span><span class="on">*</span></li>
						<li class="symbol"><span class="off">9</span><span class="on">(</span></li>
						<li class="symbol"><span class="off">0</span><span class="on">)</span></li>
						<li class="symbol"><span class="off">-</span><span class="on">_</span></li>
						<li class="symbol"><span class="off">=</span><span class="on">+</span></li>
						<li class="delete lastitem">delete</li>
						<li class="tab">tab</li>
						<li class="letter">q</li>
						<li class="letter">w</li>
						<li class="letter">e</li>
						<li class="letter">r</li>
						<li class="letter">t</li>
						<li class="letter">y</li>
						<li class="letter">u</li>
						<li class="letter">i</li>
						<li class="letter">o</li>
						<li class="letter">p</li>
						<li class="symbol"><span class="off">[</span><span class="on">{</span></li>
						<li class="symbol"><span class="off">]</span><span class="on">}</span></li>
						<li class="symbol lastitem"><span class="off">\</span><span class="on">|</span></li>
						<li class="capslock">caps lock</li>
						<li class="letter">a</li>
						<li class="letter">s</li>
						<li class="letter">d</li>
						<li class="letter">f</li>
						<li class="letter">g</li>
						<li class="letter">h</li>
						<li class="letter">j</li>
						<li class="letter">k</li>
						<li class="letter">l</li>
						<li class="symbol"><span class="off">;</span><span class="on">:</span></li>
						<li class="symbol"><span class="off">'</span><span class="on">&quot;</span></li>
						<li class="return lastitem">return</li>
						<li class="left-shift">shift</li>
						<li class="letter">z</li>
						<li class="letter">x</li>
						<li class="letter">c</li>
						<li class="letter">v</li>
						<li class="letter">b</li>
						<li class="letter">n</li>
						<li class="letter">m</li>
						<li class="symbol"><span class="off">,</span><span class="on">&lt;</span></li>
						<li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
						<li class="symbol"><span class="off">/</span><span class="on">?</span></li>
						<li class="right-shift lastitem">shift</li>
						<li class="space lastitem" style="color:red; font-weight:bold;">&nbsp;DATALOG&nbsp;</li>
					</ul>
				</div>
			<?php
			}
			?>

		</div>
	</div>


	<!-- Modal -->
	<div class="modal fade" id="confirmmodal" tabindex="-1" aria-labelledby="confirmmodalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-danger" id="confirmmodalLabel">
						<i class="fa fa-step-forward " aria-hidden="true"></i> ROLL END <i class="fa fa-step-forward " aria-hidden="true"></i>
					</h5>
				</div>
				<div class="modal-body">
					Do you really want to end this roll?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-success" id="confirm_btn"><i class="fa fa-step-forward " aria-hidden="true"></i> Confirm</button>
				</div>
			</div>
		</div>
	</div>



	<?php include 'scripts.php';  ?>
	<script>
	</script>

	<script>
		var $write = $(':focus');
		$(".focus").focus(function() {
			$write = $(this);
		});

		$(function() {
			shift = false,
				capslock = false;

			$('#keyboard li').click(function() {
				var $this = $(this),
					character = $this.html(); // If it's a lowercase letter, nothing happens to this variable

				// Shift keys
				if ($this.hasClass('left-shift') || $this.hasClass('right-shift')) {
					$('.letter').toggleClass('uppercase');
					$('.symbol span').toggle();

					shift = (shift === true) ? false : true;
					capslock = false;
					return false;
				}

				// Caps lock
				if ($this.hasClass('capslock')) {
					$('.letter').toggleClass('uppercase');
					capslock = true;
					return false;
				}

				// Delete
				if ($this.hasClass('delete')) {
					var html = $write.val();
					$write.val(html.substr(0, html.length - 1));
					return false;
				}

				// Special characters
				if ($this.hasClass('symbol')) character = $('span:visible', $this).html();
				if ($this.hasClass('space')) character = ' ';
				if ($this.hasClass('tab')) character = "\t";
				if ($this.hasClass('return')) character = "\n";

				// Uppercase letter
				if ($this.hasClass('uppercase')) character = character.toUpperCase();

				// Remove shift once a key is clicked.
				if (shift === true) {
					$('.symbol span').toggle();
					if (capslock === false) $('.letter').toggleClass('uppercase');

					shift = false;
				}
				//console.log("DO IT ", character);
				// Add the character
				$write.val($write.val() + character);
			});
		});


		

		$('#confirm_btn').click(function(e) {
			e.preventDefault();
			$("#confirmmodal").modal('hide');
			
			var errorexist = false;
			
			$('#rollend_form').find('input, select, textarea').each(function() {
				var thisinput = $(this);
				if ($(thisinput).prop('required') == true) {
					if (($('input[name=remark]:checked').attr('id') == undefined) || ($('input[name=remark]:checked').val() == undefined)) {
						errorexist = true;
					} else if ($(thisinput).val() == '') {
						errorexist = true;
					}
				}
				
			});

			if (errorexist == true) {
				
					var errortxt = "Please fill out all required fields correctly.";
				
				Swal.fire({
					position: 'top',
					icon: 'error',
					title: 'ERROR!',
					text: errortxt,
					showConfirmButton: false,
					timer: 2500
				})
			} else {
				$('#rollend_form').find('[type="submit"]').trigger('click');
			}
		});

	</script>
</body>

</html>
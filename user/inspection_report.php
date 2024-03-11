<?php
error_reporting(E_ALL);
require_once 'session.php';

$page_group = 'reports';
$title = 'Inspection Report ';
?>

<!doctype html>

<html lang="en">

<head>

	<?php include '../includes/styles.php'; ?>
	<title><?php echo $title; ?></title>

</head>
<style>
	table.dataTable tbody th,
	table.dataTable tbody td {
		padding: 1px 1px;
	}

	.responsiveTbl tr:nth-of-type(even) {
		background: white;
	}

	@page {
		size: A4;
		margin: 0;
	}

	@media print {
		body * {
			visibility: hidden;
		}


		#displayreport,
		#displayreport * {
			visibility: visible;
		}


	}
</style>

<body>
	<div class="page">
		<?php include '../includes/navmenu.php'; ?>

		<div class="page-wrapper">

			<div class="page-body">
				<div class="container-fluid">
					<div class="card">
						<div class="card-header">
							<strong class="card-title">
								<?php echo $title; ?>
							</strong>
							<div class="card-actions">
								<a href="javascript:void(0);" id="pdf_btn" title="Print" style="color:red;font-size: 20px;margin: 1px 5px;display:none" onClick="printData('displayreport')">
									<i class="fa fa-print" aria-hidden='true'></i>
								</a>

								<a href="javascript:void(0);" id="excel_btn" title="Export Excel" style="color:green;font-size: 20px;margin: 1px 5px;display:none" onClick="cleanTableExcel('displayreport','Inspection Report');">
									<i class="fa fa-file-excel" aria-hidden='true'></i>
								</a>

								<a href="javascript:void(0);" onclick="filter_toggle();" title="Filter Report" style="color:blue;font-size: 20px;margin: 1px 5px;">
									<i class="fa fa-filter" aria-hidden='true'></i>
								</a>

							</div>

						</div>
						<div class="card-body">
							<?php include '../includes/alert.php'; ?>

							<div id="reportfilter" class="form-cotainer" style="display:none">

								<div class="row">

									<div class="col-md-4 col-sm-12">

										<label class="form-label">Select Period</label>
										<select class="form-control" name="period" id="period">
											<option value="date">Date</option>
											<option value="from_to">From To</option>
										</select>
									</div>

									<div class="col-md-4 col-sm-12" id="from_date">
										<label class="form-label">Date</label>
										<input type="text" class="form-control mb-2" placeholder="Select a date" id="date1" name="date1" onchange="datechange()" />
									</div>
									<div class="col-md-4 col-sm-12" id="to_date" style="display:none">
										<label class="form-label">Date</label>
										<input type="text" class="form-control mb-2" placeholder="Select a date" id="date2" name="date2" onchange="datechange()" />
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 col-sm-12">

										<label class="form-label">Select</label>
										<select class="form-control select2-icon" name="sortby" id="sortby" onchange="getsortby()">
											<option value="Machine" <?php if ($sortby == 'Machine') {
																		echo 'selected';
																	} ?>>Machine</option>
											<option value="Style" <?php if ($sortby == 'Style') {
																		echo 'selected';
																	} ?>>Style</option>
											<option value="Inspector" <?php if ($sortby == 'Inspector') {
																			echo 'selected';
																		} ?>>Inspector</option>
											<option value="Roll" <?php if ($sortby == 'Roll') {
																		echo 'selected';
																	} ?>>Roll</option>
										</select>
									</div>

									<div class="col-md-4 col-sm-12">
										<label class="form-label">Select <span id="seldisp"></span></label>
										<span id="selectdatadisp">

										</span>
									</div>


								</div>
								<div class="form-footer">
									<button id="formsubmit" class="btn btn-success" style="font-weight:bold" onclick="loadreport()">Submit</button>

								</div>

							</div>

							<div id="displayreport">




							</div>


						</div>
					</div>
				</div>
			</div>

		</div>
	</div>


	<?php include '../includes/scripts.php'; ?>
	<script>
		$(document).ready(function() {
			$('#date1').datepicker({
				format: 'dd-mm-yyyy',
				autoHide: true,
			});
			$('#date2').datepicker({
				format: 'dd-mm-yyyy',
				autoHide: true,
			});

			$("#date1").val('<?php echo $mdate; ?>');
			$("#date2").val('<?php echo $mdate; ?>');
		});

		function open_defects(e, id) {

			var display = e.className;
			if (display == 'show1') {
				$('#' + id).attr('class', 'hide_tr');
				$('.defects_' + id).show(500);
			} else {
				$('#' + id).attr('class', 'show1');
				$('.defects_' + id).hide(500);
			}


		}

		function loadreport() {

			var period = $("#period").val();
			var date1 = $("#date1").val();
			var date2 = $("#date2").val();
			var sortby = $("#sortby").val();
			var selectdata = $("#selectdata").val();
			$('#displayreport').hide();
			$.ajax({

				type: "POST",

				url: "../ajax/inspection_report_data.php",

				data: {
					'period': period,
					'date1': date1,
					'date2': date2,
					'sortby': sortby,
					'selectdata': selectdata
				},

				success: function(data) {
					filter_toggle();
					$('#displayreport').html(data);
					$('#displayreport').show();
				}
			});

		}


		function getsortby() {
			var sortby = $("#sortby").val();
			$("#seldisp").html(sortby);

			$.ajax({

				type: "POST",

				url: "../ajax/getdetails.php",

				data: {
					'sortby': sortby
				},

				success: function(data) {

					$('#selectdatadisp').html(data);

					$('#selectdata').select2();
				}
			});

		}


		getsortby();
		$('#period').change(function(e) {
			e.preventDefault();
			periodchange();
		});

		function datechange() {
			var period = $('#period').val();
			if (period == 'date') {
				var date1 = $('#date1').val();
				var date2 = '';
			} else if (period == 'from_to') {
				var date1 = $('#date1').val();
				var date2 = $('#date2').val();
			}

		}


		function periodchange() {
			var period = $('#period').val();
			if (period == 'date') {
				$('#from_date').show();
				$('#to_date').hide();
				var date1 = $('#date1').val();
				var date2 = '';

			} else if (period == 'from_to') {
				$('#from_date').show();
				$('#to_date').show();

				var date1 = $('#date1').val();
				var date2 = $('#date2').val();

			}
		}
	</script>

</body>

</html>
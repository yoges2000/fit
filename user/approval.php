<?php

require_once 'session.php';


$title = 'Roll Approval';
$page_group = 'Assignments';

?>
<!doctype html>

<html lang="en">

<head>

	<?php include '../includes/styles.php'; ?>
	<title><?php echo $title; ?></title>

</head>

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
						</div>
						<div class="card-body">
							<?php include '../includes/alert.php'; ?>


							<table id="example" class="responsiveTbl">

								<thead>
									<tr>

										<th>Loom No</th>
										<th>Piece No</th>
										<th>Style Name</th>
										<th>Style Description</th>
										<th>Doff Meter</th>										
										<th>Remark</th>										
										<th>Approval</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$qry = "SELECT * FROM ROLL where ROLL_END=0 AND ROll_APPROVE = 0 ORDER BY ROLL_INSP_DATE DESC LIMIT 1000";
									$res = mysqli_query($fit, $qry);
									if ($res && mysqli_num_rows($res) > 0) {
										while ($row = mysqli_fetch_assoc($res)) {
											$roll_id = $row['ROLL_ID'];
											$roll_style_id = $row['ROLL_STYLE_ID'];
											$ROLL_BATCHID = $row['ROLL_BATCHID'];
											$roll_number = $row['ROLL_NUMBER'];
											$roll_subnumber = $row['ROLL_SUBNUMBER'];
											$roll_doff_loom = $row['ROLL_LOOM_NO'];
											$roll_doff_date = $row['ROLL_DOFF_DATE'];
											$roll_doff_shift = $row['ROLL_DOFF_SHIFT'];
											$roll_length = $row['ROLL_DOFF_LENGTH'];
											$roll_remark = $row['ROLL_REMARK'];
											$roll_weftlot = $row['ROLL_WEFTLOT'];

											if ($roll_subnumber > 0) {
												$rollnumber = $roll_number . "-" . $roll_subnumber;
											} else {
												$rollnumber = $roll_number;
											}
									?>
											<td><?php echo $roll_doff_loom; ?></td>

											<td><?php echo $rollnumber; ?></td>
											
											<td><a  href="std_stylechg.php?edit_id=<?php echo $roll_id; ?>&etype=style"><?php echo GFV("STDSTYLE", "style", "STYLE_ID='$ROLL_BATCHID'"); ?></a></td>
											<td><?php echo GFV("STDSTYLE", "descr", "STYLE_ID='$ROLL_BATCHID'"); ?></td>
											<td><?php echo $roll_length; ?></td>
											<td><?php echo $roll_remark; ?></td>
											<td class="center">
												<div id="approve_btn" data-id="<?php echo $roll_id; ?>" class="btn btn-success btn-mini">Approve</div>
											</td>
											
											</tr>
									<?php
										}
									} else {
										//echo '<td colspan="20">No Data Available</td> ';
									}
									?>

								</tbody>
							</table>


						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
	<div class="modal fade" id="confirmBox">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" style="text-transform:uppercase;"></h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button class="btn btn-danger no">Cancel</button>
					<button class="btn btn-success yes">Confirm</button>
				</div>

			</div>
		</div>
	</div>

	<?php include '../includes/scripts.php'; ?>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();

		});

		function formatText(icon) {
			return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
		};

		$('.select2-icon').select2({
			width: "50%",
			templateSelection: formatText,
			templateResult: formatText
		});

		function doConfirm(title, msg, yesFn, noFn) {
			var confirmBox = $('#confirmBox').modal({
				backdrop: 'static',
				keyboard: false
			});
			confirmBox.find(".modal-title").text(title);
			confirmBox.find(".modal-body").text(msg);
			confirmBox.find(".yes,.no").unbind().click(function() {
				confirmBox.modal('show');
			});
			confirmBox.find(".yes").click(yesFn);
			confirmBox.find(".no").click(noFn);
			confirmBox.modal('show');
		}

		$(document).on('click', '#approve_btn', function(e) {
			e.preventDefault();
			var id = $(this).attr("data-id");
			doConfirm("Approval?", "Are you sure want to approve.", function yes() {
				//alert(id);
				$.ajax({
					type: "POST",
					url: '../actions/approval_act.php',
					data: {
						"roll_id": id,
						"action": '1'
					},
					success: function(result) {
						var response = JSON.parse(result);
						if (response.success) {
							$(e.target).closest('tr').remove();
							alert('Roll approved successfully');
						} else {
							alert('Failed to approve roll');
						}
						location.reload();
					},
					error: function(xhr, status, error) {
						console.error(xhr.responseText);
					}
				});
			}, function no() {
				var confirmBox = $("#confirmBox");
				confirmBox.modal('hide');
			});
		});
	</script>
</body>

</html>
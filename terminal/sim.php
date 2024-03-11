<?php
require_once '../includes/connection.php';
require_once '../includes/functions.php';

$mcid = '1';

$query = "SELECT * FROM std_machines WHERE MC_ID='$mcid'";
$res = mysqli_query($fit, $query);
while ($row = mysqli_fetch_assoc($res)) {
	$cl_length = $row['MC_LENGTH'];

	$cl_time = date("Y-m-d h:i:s", strtotime($row['MC_PRETIME']));
	$cur_time = date("Y-m-d h:i:s");

	$arr = array(9, 15, 22, 30);
	$arr_ind = mt_rand(0, 3);

	$add_length1 = $arr[$arr_ind];
	$add_length = $add_length1 / 100;
	$new_length = $cl_length + $add_length;

	if ($add_length == 0) {
		$mc_status = 0;
	} else {
		$mc_status = 1;
	}

	if ($new_length != $cl_length) {
		$runtime = strtotime($cur_time) - strtotime($cl_time);
		$stoptime = 0;
	} else {
		$runtime = 0;
		$stoptime = strtotime($cur_time) - strtotime($cl_time);
	}
}
$query1 = "UPDATE std_machines SET MC_LENGTH = '$new_length', MC_PRETIME = NOW() WHERE MC_ID='$mcid'";
mysqli_query($fit, $query1);

$rsec = mt_rand(2, 3);
?>
<!DOCTYPE html>
<html>

<head>
	<?php
	include 'styles.php';
	?>
	<title>Datalog Simulation</title>
	<style>
		html,
		body {
			height: 100%;
			width: 100%;
		}

		body {
			background: #2a2a2a;
			color: #fafafa;
			font-family: sans-serif;
			font-weight: 300;
			font-size: 6rem;
			margin: 0;
			text-align: center;
			padding-top: 100px;
		}

		#play-pause {
			display: none;
		}

		label {
			cursor: pointer;
		}

		#play-pause:checked+#play-pause-label::after {
			content: '❙❙';
		}

		#play-pause-label::after {
			content: '►';
		}
	</style>
</head>

<body>
	<input type="checkbox" id="play-pause" />
	<label for="play-pause" id="play-pause-label" class="win-button"></label>
	<br />
	<h1>Test</h1>

	<?php include 'scripts.php';  ?>
	<script>
		$('input[type="checkbox"]').change(function() {
			if ($(this).is(":checked")) {
				window.setTimeout(function() {
					window.location.reload();
				}, 1000);
				return;
			} else {
				// Do Nothing
			}
		});
	</script>
</body>

</html>
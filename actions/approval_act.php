<?php
require_once '../includes/connection.php';
require_once '../includes/functions.php';

if (isset($_POST['roll_id'])) {
    $roll_id = $_POST['roll_id'];
	$action = $_POST['action'];
	$remark = $_POST['remark'];
	if ($action == '1'){
		$approval_query = "UPDATE ROLL SET ROLL_APPROVE = 1 WHERE ROLL_ID = '$roll_id'";
	} elseif ($action == '0') {
		$approval_query = "UPDATE ROLL SET ROLL_APPROVE = 0,ROLL_REMARK='$remark' WHERE ROLL_ID = '$roll_id'";
	}
    mysqli_query($fit, $approval_query);

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Roll ID not provided"]);
}

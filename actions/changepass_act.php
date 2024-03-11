<?php

require_once '../includes/connection.php';
if (isset($_POST['ppass']) || isset($_POST['npass']) || isset($_POST['cpass'])) {
	$ppass = md5($_POST['ppass']);
	$npass = md5($_POST['npass']);
	$cpass = md5($_POST['cpass']);
	if ($npass == $cpass) {
		$qry = "SELECT * FROM USERS WHERE USER_ID='{$_SESSION['dlog_userid']}'";
		$res = mysqli_query($fit, $qry);
		$row = mysqli_fetch_assoc($res);
		if ($row['USER_PASSWORD'] == $ppass) {
			$qry0 = "UPDATE USERS SET USER_PASSWORD='$npass' WHERE USER_ID='{$_SESSION['dlog_userid']}'";
			if ($fit->query($qry0)) {
				$_SESSION['SUCCESS'] = 'Password Changed Successfully';
			} else {
				$_SESSION['ERROR'] = $fit->error;
			}
		} else {
			$_SESSION['ERROR'] = 'Old Password is Invalid';
		}
	} else {
		$_SESSION['ERROR'] = 'Re-entered Password should match with the New Password';
	}
} else {
	$_SESSION['ERROR'] = 'Please enter the user name and password ';
}
header('location: ../user/changepass.php');

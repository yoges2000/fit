<?php

require_once 'session.php';

if (isset($_POST['ppass']) || isset($_POST['npass']) || isset($_POST['cpass'])) {
	$ppass = md5($_POST['ppass']);
	$npass = md5($_POST['npass']);
	$cpass = md5($_POST['cpass']);
	if ($npass == $cpass) {
		$qry = "SELECT * FROM INSPECTORS WHERE INSPECTOR_ID='$glob_insid'";
		$res = mysqli_query($fit, $qry);
		$row = mysqli_fetch_assoc($res);
		if ($row['INSPECTOR_PASSWORD'] == $ppass) {
			$qry0 = "UPDATE INSPECTORS SET INSPECTOR_PASSWORD='$npass' WHERE INSPECTOR_ID='$glob_insid'";
			if ($fit->query($qry0)) {
				$_SESSION['success'] = 'Password Changed Successfully';
			} else {
				$_SESSION['error'] = $fit->error;
			}
		} else {
			$_SESSION['error'] = 'Old Password is Invalid';
		}
	} else {
		$_SESSION['error'] = 'Re-entered Password should match with the New Password';
	}
} else {
	$_SESSION['error'] = 'Please enter the Inspector name and Password ';
}
header('location: changepass.php');

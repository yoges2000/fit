<?Php
	//session_start();
	require_once '../includes/connection.php';
	require_once '../includes/functions.php';

	if(!isset($_SESSION['dlog_userid']) || trim($_SESSION['dlog_userid']) == ''){
		header("location:../index.php");
		}else{
		$query1 = "SELECT * FROM USERS WHERE USER_ID = '".$_SESSION['dlog_userid']."'";
		$res1 = mysqli_query($fit, $query1);
		$row1 = mysqli_fetch_array($res1);

		$_SESSION['dlog_user_id'] = $row1['USER_ID'];
		$_SESSION['user_firstname'] = $row1['USER_FIRSTNAME'];
		$_SESSION['user_lastname'] = $row1['USER_LASTNAME'];
		$_SESSION['user_loginname'] = $row1['USER_LOGINNAME'];
		$_SESSION['user_logintime'] = $row1['USER_LOGINTIME'];
		
		$query = "SELECT * FROM std_mill";
		$res = mysqli_query($fit, $query);
		$row = mysqli_fetch_array($res);

		$_SESSION['millname'] = $row['MILL_NAME'];
	}
		
		
	$mdate= date("Y-m-d");
	$mshift= 1;
	$update_stdmill = "UPDATE `std_mill` SET `MDATE`='$mdate', `MSHIFT`='$mshift' WHERE 1";
	mysqli_query($fit,$update_stdmill);
?>

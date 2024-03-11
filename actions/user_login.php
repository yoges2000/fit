<?php
	
	require_once '../includes/connection.php';

	if (isset($_POST['username']) || isset($_POST['password'])){	
		$username = $_POST['username'];
		$password = md5($_POST['password']);		
		$qry 		= "SELECT * FROM USERS WHERE USER_LOGINNAME='$username'";
		$res = mysqli_query($fit,$qry);
		if (mysqli_num_rows($res) < 1) {
			$_SESSION['error'] = 'The username is not Registered';
			}else{
			$row = mysqli_fetch_assoc($res);
			if($row['USER_VALID'] == '1'){
				if($row['USER_PASSWORD']==$password){
						$_SESSION['dlog_userid'] = $row['USER_ID'];				
						$_SESSION['dlog_userlvl'] = $row['USER_LEVEL'];				
						}else{
						$_SESSION['error'] = 'Invalid Password';
					}
				}else{
				$_SESSION['error'] = 'Your Account is Deactivated';
			}			
		}
		}else{
		$_SESSION['error'] = 'Please enter the user name and password ';
	}
	header('location: ../index.php');
?>

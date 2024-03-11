<?php	
	require_once '../includes/connection.php';	
	
	if (isset($_POST['save_btn'])){
		$mill_name=$_POST['mill_name'];
		$noofs=$_POST['noofs'];
		$waste=$_POST['waste'];
		if($noofs == '3'){
			$shift1=$_POST['shift1'];
			$shift2=$_POST['shift2'];
			$shift3=$_POST['shift3'];
		}
		else if($noofs == '2'){
			$shift1=$_POST['shift1'];
			$shift2=$_POST['shift2'];
			$shift3=NULL;
		}
		else if($noofs == '1'){
			$shift1=$_POST['shift1'];
			$shift2=NULL;
			$shift3=NULL;
		}		
		
		$sql_edit = "UPDATE STD_MILL SET mill_name = '$mill_name', noofs='$noofs', shift1='$shift1', shift2='$shift2', shift3='$shift3' WHERE 1";		
		$res_edit = mysqli_query($fit, $sql_edit);
		if($res_edit){
		 	$_SESSION['SUCCESS'] = 'Data Updated successfully';
		}
		else{
			$_SESSION['ERROR'] = $fit->error;
		}
	}
	header('location: ../user/std_mill.php');
?>

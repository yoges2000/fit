<?php

require_once 'session.php';


if(isset($_GET['add']) || isset($_GET['edit_id'])){
    if(isset($_GET['add'])){
        $title = 'ADD USER ';
    }else{
        $title = 'EDIT USER ';
    }
}
else{
    $title = 'Users ';
}
$filename ='std_users.php';


if(isset($_GET['edit_id'])){
    $edit_id = $_GET['edit_id'];
    $qry = "select * from USERS where USER_ID='$edit_id'";
    $res = mysqli_query($fit, $qry);
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $user_id=$row['USER_ID'];
            $user_name=$row['USER_NAME'];
            
            $user_loginname=$row['USER_LOGINNAME'];
            $user_valid=$row['USER_VALID'];
        }
    }
}else{
    $user_id='';
    $user_firstname='';
    $user_lastname='';
    $user_loginname='';
    $user_valid=1;
}
?>
<!doctype html>

<html lang="en">

<head>

<?php include '../includes/styles.php'; ?>
  <title><?php echo $title;?></title>
 
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
						<?php echo $title;?>
						</strong>
						<div class="card-actions"> 
						<?php if(isset($_GET['add']) || isset($_GET['edit_id'])){?>
						
								<a href="<?php echo $filename;?>" class="btn btn-danger btn-sm" style="color:white; float:right"><i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;BACK</a>
							<?php }else{?>
							 	<a href="<?php echo $filename;?>?add=1" class="btn btn-info btn-sm" ><i class="fa fa-plus"></i>&nbsp;&nbsp;NEW</a>
							<?php }?>
						
						</div>
						
						
						
					</div>
                  <div class="card-body">
                  <?php include '../includes/alert.php'; ?>		
                  <?php
							if(isset($_GET['edit_id']) || isset($_GET['add'])){
							?>
                  
                        <div class="form-cotainer">
							<form class="form-horizontal" method="post" action="../actions/std_users_act.php">
								
								<div class="row">
								    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" >
									
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">User Name</label>
                              			<input type="text" class="form-control" name="user_name" value="<?php echo $user_name; ?>" required>
                            		</div>
                            		
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">User Login name</label>
                              			<input type="text" class="form-control" name="user_loginname" value="<?php echo $user_loginname; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			
                              			<div class="form-label">User Valid</div>
                              			<select class="form-select" name="user_valid">
                              		 		  <option value="1" <?php if($user_valid == '1'){echo 'selected';} ?>>Yes</option>
                               				  <option value="0" <?php if($user_valid == '0'){echo 'selected';} ?>>No</option>
                                         </select>
                            		</div>
                            		<?php 
											if(isset($_GET['add'])){							
											?>
											<div class="col-md-2 col-sm-12">
												<label class="form-label">Password </label>
													<input type="password" class="form-control" name="npass"  required>									
											</div>
											
											<div class="col-md-2 col-sm-12">
												<label class="form-label">Re-Enter Password </label>
													<input type="password" class="form-control" name="cpass"  required>									
											</div>							
										<?php } ?>
                            	
        						<div class="form-footer">
                              		<button type="submit" class="btn btn-success" style="font-weight:bold">Submit</button>
                              		
                            	</div>
                            	
        							
							</form>
						</div>
						<?php }else{ ?>
							<table id="example" class="responsiveTbl">
								
									
								<thead class="">
								<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Login Name</th>
								<th>Enabled</th>
								<th>Action</th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$qry = "select * from USERS order by USER_ID ";
								$res = mysqli_query($fit, $qry);
								if ($res && mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
									    $user_id=$row['USER_ID'];
									    $user_name=$row['USER_NAME'];
									    
									    $user_loginname=$row['USER_LOGINNAME'];
									    $user_valid=$row['USER_VALID'];
									    
										?>
										<tr class="gradeX">
										<td><?php echo $user_id;?></td>
										<td><?php echo $user_name;?></td>
										<td><?php echo $user_loginname;?></td>
										
										
										<td>
										<?php if($user_valid=='1'){?>
											<i class="fa fa-check" style="color:green"></i>
											<?php }else{?>
											<i class="fa fa-times" style="color:red"></i>
										<?php }?>
										</td>
										
										
										<td> <a href="std_users.php?edit_id=<?php echo $user_id;?>" class="btn btn-primary btn-mini">Edit</a></td>
										</tr>
									<?php }
								}
								?>
								
								
									</tbody>
								</table>
							
						<?php 
						 }?>
                  </div>
                </div>
      
        </div>
      </div>

    </div>
  </div>

 <?php include '../includes/scripts.php'; ?>
	<script>
	
	$(document).ready(function () {
	    $('#example').DataTable();

	});

	function formatText (icon) {
	    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
	};

	$('.select2-icon').select2({
	    width: "50%",
	    templateSelection: formatText,
	    templateResult: formatText
	});
	</script>
</body>

</html>
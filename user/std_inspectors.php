<?php

require_once 'session.php';

if(isset($_GET['add']) || isset($_GET['edit_id'])){
    if(isset($_GET['add'])){
        $title = 'Add Inspector ';
    }else{
        $title = 'Edit Inspector ';
    }
}
else{
    $title = 'Inspector Standard ';
}
$filename ='std_inspectors.php';

if(isset($_GET['edit_id'])){
    $edit_id = $_GET['edit_id'];
    $qry = "select * from INSPECTORS where INSP_ID='$edit_id'";
    $res = mysqli_query($fit, $qry);
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $insp_id=$row['INSP_ID'];
            $insp_name=$row['INSP_NAME'];
            
            $insp_loginname=$row['INSP_LOGINNAME'];
            $insp_valid=$row['INSP_VALID'];
            $insp_empid=$row['INSP_EMPID'];
            
        }
    }
}else{
    $insp_id='';
    $insp_name='';
    
    $insp_loginname='';
    $insp_valid=1;
    $insp_empid='';
    $insp_grade='';
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
							<form class="form-horizontal" method="post" action="../actions/std_inspectors_act.php">
								
								<div class="row">
								    <input type="hidden" name="insp_id" value="<?php echo $insp_id; ?>" >
									<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Inspector Employee Id</label>
                              			<input type="text" class="form-control" name="insp_empid" value="<?php echo $insp_empid; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Inspector Name</label>
                              			<input type="text" class="form-control" name="insp_name" value="<?php echo $insp_name; ?>" required>
                            		</div>
                            		
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Inspector Login name</label>
                              			<input type="text" class="form-control" name="insp_loginname" value="<?php echo $insp_loginname; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			
                              			<div class="form-label">INSP Valid</div>
                              			<select class="form-select" name="insp_valid">
                              		 		  <option value="1" <?php if($insp_valid == '1'){echo 'selected';} ?>>Yes</option>
                               				  <option value="0" <?php if($insp_valid == '0'){echo 'selected';} ?>>No</option>
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
								<th>Employee ID</th>
								<th>Name</th>
								<th>Login Name</th>
								<th>Enabled</th>
								<th>Action</th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$qry = "select * from INSPECTORS order by INSP_ID ";
								$res = mysqli_query($fit, $qry);
								if ($res && mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
									    $insp_id=$row['INSP_ID'];
									    $insp_name=$row['INSP_NAME'];
									    
									    $insp_loginname=$row['INSP_LOGINNAME'];
									    $insp_valid=$row['INSP_VALID'];
									    $insp_empid=$row['INSP_EMPID'];
									    
									    $insp_logintime=$row['INSP_LOGINTIME'];
									    $inspector_logouttime=$row['INSP_LOGOUTTIME'];
									    
									    
										?>
										<tr class="gradeX">
										<td><?php echo $insp_id;?></td>
										<td><?php echo $insp_empid;?></td>
										<td><?php echo $insp_name;?></td>
										<td><?php echo $insp_loginname;?></td>
										
										
										<td>
										<?php if($insp_valid=='1'){?>
											<i class="fa fa-check" style="color:green"></i>
											<?php }else{?>
											<i class="fa fa-times" style="color:red"></i>
										<?php }?>
										</td>
										
										
										<td> <a href="std_inspectors.php?edit_id=<?php echo $insp_id;?>" class="btn btn-primary btn-mini">Edit</a></td>
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
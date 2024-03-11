<?php

require_once 'session.php';

$page_group = 'standards';
$filename ='std_machines.php';
if(isset($_GET['add']) || isset($_GET['edit_id'])){
    if(isset($_GET['add'])){
        $title = 'ADD INSPECTION TABLE';
    }else{
        $title = 'EDIT INSPECTION TABLE';
    }
}
 else{
        $title = 'INSPECTION TABLES';
 }



if(isset($_GET['edit_id']) ){
    $edit_id = $_GET['edit_id'];
    $qry = "select * from std_machines where MC_ID='$edit_id'";
    $res = mysqli_query($fit, $qry);
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $mc_id=$row['MC_ID'];
            $mc_name=$row['MC_NAME'];
            $mc_type=$row['MC_TYPE'];
            $mc_valid=$row['MC_VALID'];
        }
    }
}
else{
    $mc_id='';
    $mc_name='';
    $mc_type='';
    $mc_valid='';
    
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
                  
                  
                  <?php
                   include '../includes/alert.php'; 
							if(isset($_GET['edit_id']) || isset($_GET['add'])){
							?>
                  
                        <div class="form-cotainer">
							<form class="form-horizontal" method="post" action="../actions/std_machines_act.php">
								
								<div class="row">
								     <input type="hidden" class="form-control" name="mc_id" value="<?php echo $mc_id; ?>">
								    
									<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Inspection Table Name</label>
                              			<input type="text" class="form-control" name="mc_name" value="<?php echo $mc_name; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			
                              			<div class="form-label">Valid</div>
                              			<select class="form-select" name="mc_valid">
                              		 		  <option value="1" <?php if($mc_valid == '1'){echo 'selected';} ?>>Yes</option>
                               				  <option value="0" <?php if($mc_valid == '0'){echo 'selected';} ?>>No</option>
                                         </select>
                            		</div>
                            		
								</div>
								
        						<div class="form-footer">
                              		<button type="submit" class="btn btn-success"  style="font-weight:bold">Submit</button>
                              		
                            	</div>
                            	
        									
							</form>
						</div>
						<?php }else{
						
						 ?>
					
								<table id="example" class="responsiveTbl">
								<thead class="">
								<tr>
								<th>ID</th>
								<th>Name</th>
								
								<th>Enabled</th>
								<th>Action</th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$qry = "select * from STD_MACHINES order by MC_ID ";
								$res = mysqli_query($fit, $qry);
								if ($res && mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
										$mc_id=$row['MC_ID'];
										$mc_name=$row['MC_NAME'];
										$mc_type=$row['MC_TYPE'];
										$mc_valid=$row['MC_VALID'];
										
										?>
										<tr class="gradeX">
										<td><?php echo $mc_id;?></td>
										<td><?php echo $mc_name;?></td>
										
										
										<td>
										<?php if($mc_valid=='1'){?>
											<i class="fa fa-check" style="color:green"></i>
											<?php }else{?>
											<i class="fa fa-times" style="color:red"></i>
										<?php }?>
										</td>
										
										
										<td> <a href="std_machines.php?edit_id=<?php echo $mc_id;?>" class="btn btn-primary btn-mini">Edit</a></td>
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
	
	</script>
</body>

</html>
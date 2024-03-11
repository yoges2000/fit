<?php

require_once 'session.php';

if(isset($_GET['add']) || isset($_GET['edit_id'])){
    if(isset($_GET['add'])){
        $title = 'ADD Roll ';
    }else{
        $title = 'EDIT Roll ';
    }
}
else{
    $title = 'Roll Standards';
}
$filename ='std_roll.php';


if(isset($_GET['edit_id']) || isset($_GET['add'])){
    if(isset($_GET['edit_id'])){
        $edit_id = $_GET['edit_id'];
        $qry = "select * from ROLL where ROLL_ID='$edit_id'";
        $res = mysqli_query($fit, $qry);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $roll_id=$row['ROLL_ID'];
			$ROLL_BATCHID = $row['ROLL_BATCHID'];
            $roll_style_id=$row['ROLL_STYLE_ID'];
            $roll_number=$row['ROLL_NUMBER'];
            $roll_doff_loom=$row['ROLL_LOOM_NO'];
            $roll_doff_date=$row['ROLL_DOFF_DATE'];
            $roll_doff_shift=$row['ROLL_DOFF_SHIFT'];
            $roll_length=$row['ROLL_DOFF_LENGTH'];
            $roll_warplot=$row['ROLL_WARPLOT'];
            $roll_weftlot=$row['ROLL_WEFTLOT'];
        }
    }
    else{
        $roll_id = '';
		$ROLL_BATCHID = '';
        $roll_style_id = '';
        $roll_number = '';
        $roll_doff_loom = '';
        $roll_length = '';
        $roll_doff_date = '';
        $roll_doff_shift = '';
        $roll_length='';
        $roll_activity='';
        $roll_warplot=='';
        $roll_weftlot='';
    }
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
							<form class="form-horizontal" method="post" action="../actions/std_roll_act.php">
								
								<div class="row">
								    <input type="hidden" name="roll_id" value="<?php echo $roll_id; ?>" >
									<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Select Style</label>
                              			<select class="form-control select2-icon" name="roll_style_id" id="roll_style_id" >
                              			<?php 
                                          			$qry = "SELECT STYLE_ID, STYLE FROM STDSTYLE WHERE 1 ORDER BY STYLE_ID ASC ";
                                          			$res = mysqli_query($fit, $qry);
                                          			if ($res && mysqli_num_rows($res) > 0) {
                                          			    while ($row = mysqli_fetch_assoc($res)) {
                                          			        if($roll_style_id == $row['STYLE_ID']){
                                          			            $selected = 'selected';
                                          			        }
                                          			        else{
                                          			            $selected = '';
                                          			        }
                                          			        
                                          			        echo '<option value="'.$row['STYLE_ID'].'" '.$selected.'>'.$row['STYLE'].'</option>';
                                          			    }
                                          			}
                                          			else{
                                          			    echo '<option value="">style not available</option>';
                                          			} 
													?>
                              			  </select>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Piece/Roll Number</label>
                              			<input type="text" class="form-control" name="roll_number" value="<?php echo $roll_number; ?>" required>
                            		</div>
                            		
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Loom Number</label>
                              			<input type="text" class="form-control" name="roll_doff_loom" value="<?php echo $roll_doff_loom; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Total Meters</label>
                              			<input type="number" class="form-control" name="roll_doff_length" value="<?php echo $roll_length; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                                      <div class="form-label">Doff Datet</div>
                                      <input type="date" class="form-control" name="roll_doff_date" id="roll_doff_date" value="<?php echo $roll_doff_date; ?>">	
                                    </div>
                            		<div class="col-md-2 col-sm-12">
                                      <div class="form-label">Doff Shift</div>
                                      <input type="number" class="form-control" name="roll_doff_shift" id="roll_doff_shift" value="<?php echo $roll_doff_shift; ?>" min="1" max="3" required>	
                                    </div>
                            		
                            		
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Warp Lot No.</label>
                              			<input type="text" class="form-control" name="roll_warplot" value="<?php echo $roll_warplot; ?>" required>
                            		</div>
                            		
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Weft Lot No.</label>
                              			<input type="text" class="form-control" name="roll_weftlot" value="<?php echo $roll_weftlot; ?>" required>
                            		</div>
                            	
        						<div class="form-footer">
                              		<button type="submit" class="btn btn-success" style="font-weight:bold">Submit</button>
                              		
                            	</div>
                            	
        							
							</form>
						</div>
						<?php }else{ ?>
							<table id="example" class="responsiveTbl">
								
									<thead>
										<tr>
											    
											<th>Roll No.</th>
											<th>Loom Number</th>
											<th>Length</th>
											<th>Doffed Date & Shift</th>
											<th>Style</th>
											<th>Warplot</th>
											<th>Weftlot</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 											
											$qry = "SELECT * FROM ROLL where ROLL_END=0 ORDER BY ROLL_STYLE_ID";
											$res = mysqli_query($fit, $qry);
											if ($res && mysqli_num_rows($res) > 0) { 
												while ($row = mysqli_fetch_assoc($res)) {				
													$roll_id=$row['ROLL_ID'];
													$ROLL_BATCHID = $row['ROLL_BATCHID'];
													$roll_style_id=$row['ROLL_STYLE_ID'];
													$roll_number=$row['ROLL_NUMBER'];
													$roll_doff_loom=$row['ROLL_LOOM_NO'];
													$roll_doff_date=$row['ROLL_DOFF_DATE'];
													$roll_doff_shift=$row['ROLL_DOFF_SHIFT'];
													$roll_length=$row['ROLL_DOFF_LENGTH'];	
													$roll_warplot=$row['ROLL_WARPLOT'];
													$roll_weftlot=$row['ROLL_WEFTLOT'];
												?>		
												<td><?php echo $roll_id; ?></td>
												
												<td><?php echo $roll_doff_loom; ?></td>   
												<td><?php echo $roll_length; ?></td>
												<td>
													<?php
														if(!empty_datetime($roll_doff_date)){
															echo date("d/m/y", strtotime($roll_doff_date));
														} else{ echo ' NIL '; }
														
														echo ' & ';
														if(!empty($roll_doff_shift)){ echo $roll_doff_shift; } else{ echo ' NIL '; }
													?>
												</td>
												<td><?php echo GFV("STDSTYLE", "descr", "STYLE_ID='$ROLL_BATCHID'"); ?></td>
												<td><?php echo $roll_warplot; ?></td>   
												  
												
												
												<td><?php echo $roll_weftlot; ?></td>
												<td class="center">
													<a href="std_roll.php?edit_id=<?php echo $roll_id;  ?>" class="btn btn-success btn-mini">Edit</a>												
												</td>
											</tr>
											<?php 
											}
										}
										else{
											//echo '<td colspan="20">No Data Available</td> ';
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
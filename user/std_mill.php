<?php
	
	require_once 'session.php';
	$title="Mill Standards";
	$page_group = 'standards';
	
	$qry = "select * from STD_MILL where 1";
	$res = mysqli_query($fit, $qry);
	if ($res && mysqli_num_rows($res) > 0) { 
		while ($row = mysqli_fetch_assoc($res)) {
			$mill_name = $row['MILL_NAME'];
			$noofs = $row['NOOFS'];	
			$shift1 = $row['SHIFT1'];				
			$shift2 = $row['SHIFT2'];
			$shift3 = $row['SHIFT3'];
			
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
                    <h3 class="card-title"><?php echo $title;?></h3>
                    
                    <!-- <div class="card-actions">
                      <a href="#" class="btn btn-primary">
                        new
                      </a>
                    </div> -->
                  </div>
                  <div class="card-body">
                        <div class="form-cotainer">
							<form class="form-horizontal" method="post" action="../actions/std_mill_act.php">
								
								<div class="row">
									<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Mill Name</label>
                              			<input type="text" class="form-control" name="mill_name" value="<?php echo $mill_name; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                                      <div class="form-label">Shifts</div>
                                      <input type="number" class="form-control" name="noofs" id="noofs" value="<?php echo $noofs; ?>" min="1" max="3" required>	
                                    </div>
									
									<div class="col-md-2 col-sm-12" id="shift1">
										<div class="form-group">
											<div class="form-label">Shift 1</div>									
											<input type="time" class="form-control" name="shift1" value="<?php echo $shift1; ?>" step="1" required>											
										</div>
									</div>
									<div class="col-md-2 col-sm-12" id="shift2">
										<div class="form-group">
											<div class="form-label">Shift 2</div>									
											<input type="time" class="form-control" name="shift2" value="<?php echo $shift2; ?>" step="1" >											
										</div>
									</div>
									<div class="col-md-2 col-sm-12" id="shift3">
										<div class="form-group">
											<div class="form-label">Shift 3</div>										
											<input type="time" class="form-control" name="shift3" value="<?php echo $shift3; ?>" step="1" >											
										</div>
									</div>
								</div>
								
        						<div class="form-footer">
                              		<button type="submit" class="btn btn-success" name="save_btn" style="font-weight:bold">Submit</button>
                              		
                            	</div>
                            	
        						<?php include '../includes/alert.php'; ?>			
							</form>
						</div>
                  </div>
                </div>
      
        </div>
      </div>

    </div>
  </div>

 <?php include '../includes/scripts.php'; ?>
	<script>
		$(document).ready(function(){
			var beg=true;
			if(beg==true){
				var noofs = $('#noofs').val();
				if(noofs == '3'){
					$('#shift1').show();
					$('#shift2').show();
					$('#shift3').show();
				}
				else if(noofs == '2'){
					$('#shift1').show();
					$('#shift2').show();
					$('#shift3').hide();	
				}	
				else if(noofs == '1'){
					$('#shift1').show();
					$('#shift2').hide();
					$('#shift3').hide();	
				}
				var beg=false;
			}
		});
	
	$('#noofs').change(function(e){
	e.preventDefault();				
	var noofs = $('#noofs').val();
	
	if(noofs == '3'){
	$('#shift1').show();
	$('#shift2').show();
	$('#shift3').show();
	}
	else if(noofs == '2'){
	$('#shift1').show();
	$('#shift2').show();
	$('#shift3').hide();	
	}	
	else if(noofs == '1'){
	$('#shift1').show();
	$('#shift2').hide();
	$('#shift3').hide();	
	}				
	});
	
	</script>
</body>

</html>
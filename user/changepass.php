<?php

require_once 'session.php';
$title="Change Password";
$page_group = 'account';

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
							<form class="form-horizontal" method="post" action="../actions/changepass_act.php">
								
								<div class="row">
									<div class="col-md-2 col-sm-12">
                              			<label class="control-label">Previous Password</label>
										<input type="password" class="form-control" name="ppass" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                                      <label class="control-label">New Password </label>
									  <input type="password" class="form-control" name="npass" required>
                                    </div>
									
									<div class="col-md-2 col-sm-12" id="shift1">
										<div class="form-group">
											<label class="control-label">Re-Enter New Password</label>
											<input type="password" class="form-control" name="cpass" required>									
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
	
</body>

</html>
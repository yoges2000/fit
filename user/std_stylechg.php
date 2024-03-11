<?php

require_once 'session.php';

$page_group = 'standards';

if(isset($_GET['add']) || isset($_GET['edit_id'])){
    if(isset($_GET['add'])){
        $title = 'ADD STYLES ';
    }else{
        $title = 'EDIT STYLES ';
    }
}
else{
    $title = 'Style Standards ';
}
$filename ='std_style.php';


if(isset($_GET['edit_id'])){
    $edit_id = $_GET['edit_id'];
    $etype = $_GET['etype'];
    $qry = "select * from STDSTYLE where STYLE_ID='$edit_id'";
    $res = mysqli_query($fit, $qry);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        extract($row);
        $style_id=$row['STYLE_ID'];
        $style=$row['STYLE'];
        $descr=$row['DESCR'];
        $width=$row['WIDTH'];
        
        $epi=$row['EPI'];
        $ppcm=$row['PPCM'];
        
    }
}else{
    $style_id='';
    $style='';
    $descr='';
    $width='';
    $epi='';
    $ppcm='';
}
if ($etype=='style'){
	$title = 'EDIT STYLES ';
}elseif ($etype=='weight'){
	$title = 'Weight Entry ';
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
						
								<a href="weight.php" class="btn btn-danger btn-sm" style="color:white; float:right"><i class="fa fa-angle-double-left"></i>&nbsp;&nbsp;BACK</a>
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
							<form class="form-horizontal" method="post" action="../actions/std_stylechg_act.php">
								
								<div class="row">
								<?php if ($etype=='style'){ ?>
								    <input type="hidden" name="style_id" value="<?php echo $edit_id; ?>" >
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
								<?php }?>
								<?php if ($etype=='weight'){ ?>
									<input type="hidden" name="style_id" value="<?php echo $edit_id; ?>" >
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Weight</label>
                              			<input type="text" class="form-control" name="weight" value="" required>
                            		</div>
                            	<?php }?>	
                            		<!--<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Width</label>
                              			<input type="number" class="form-control" name="width" value="<?php echo $width; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">PPI</label>
                              			<input type="number" class="form-control" name="ppcm" value="<?php echo $ppcm; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">EPI</label>
                              			<input type="number" class="form-control" name="epi" value="<?php echo $epi; ?>" required>
                            		</div>-->
                            	
        						<div class="form-footer">
                              		<button type="submit" class="btn btn-success" style="font-weight:bold">Submit</button>
                              		
                            	</div>
                            	
        							
							</form>
						</div>
						<?php }else{ ?>
							<table id="example" class="responsiveTbl">
								
									<thead>
										<tr>
											<th>Sort No.</th> 
											<th>Construct</th>	
											<th>Width</th>                  
											
											<th>PPI</th>																						
											<th>EPI</th>
											
											
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 											
											$qry = "select * from STDSTYLE order by STYLE_ID DESC";
											$res = mysqli_query($fit, $qry);
											if ($res && mysqli_num_rows($res) > 0) { 
												while ($row = mysqli_fetch_assoc($res)) {	
												extract($row);
												$style_id=$row['STYLE_ID'];
												$style=$row['STYLE'];
												$construct=$row['DESCR'];
												$width=$row['WIDTH'];
												
												$epi=$row['EPI'];
												$ppcm=$row['PPCM'];
												?>	
												<tr>
													<td><?php echo $style; ?></td>   
													<td><?php echo $construct; ?></td> 
													
													<td><?php echo $width; ?></td>
													<td><?php echo $ppcm; ?></td>
													<td><?php echo $epi; ?></td>
													
													
													
													<td class="center">
														<a href="std_style.php?edit_id=<?php echo $style_id;  ?>" class="btn btn-success btn-mini">Edit</a>												
													</td>
												</tr>
												<?php 
												}
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
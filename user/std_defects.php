<?php

require_once 'session.php';

$page_group = 'Defect Standards';

if(isset($_GET['add']) || isset($_GET['edit_id'])){
    if(isset($_GET['add'])){
        $title = 'ADD DEFECTS ';
    }else{
        $title = 'EDIT DEFECTS ';
    }
}
else{
    $title = 'DEFECTS ';
}
$filename ='std_defects.php';


if(isset($_GET['edit_id'])){
    $edit_id = $_GET['edit_id'];
    $qry = "select * from STD_DEFECTS where DEFECT_ID='$edit_id'";
    $res = mysqli_query($fit, $qry);
    if ($res && mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $defect_id=$row['DEFECT_ID'];
            $defect_type=$row['DEFECT_TYPE'];
            $defect_name=$row['DEFECT_NAME'];
            $defect_shortname=$row['DEFECT_SHORTNAME'];
            $defect_valid=$row['DEFECT_VALID'];
            $defect_desc=$row['DEFECT_DESC'];
            $defect_color=$row['DEFECT_COLOR'];
            $defect_symbol=$row['DEFECT_SYMBOL'];
            $defect_order=$row['DEFECT_ORDER'];
            
        }
    }
}else{
    $defect_id='';
    $defect_type='';
    $defect_name='';
    $defect_name='';
    $defect_shortname='';
    $defect_valid='';
    $defect_desc='';
    $defect_color='';
    $defect_symbol='';
    $defect_order='';
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
							<form class="form-horizontal" method="post" action="../actions/std_defects_act.php">
								
								<div class="row">
								    <input type="hidden" name="defect_id" value="<?php echo $defect_id; ?>" >
									<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Defect Name</label>
                              			<input type="text" class="form-control" name="defect_name" value="<?php echo $defect_name; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Defect Short Name</label>
                              			<input type="text" class="form-control" name="defect_shortname" value="<?php echo $defect_shortname; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			
                              			<div class="form-label">Defect Type</div>
                              			<select class="form-select" name="defect_type">
                              		 		 <option value="1" <?php if($defect_type=='1'){echo 'selected';} ?> >4_POINT</option>
											 <option value="2" <?php if($defect_type=='2'){echo 'selected';} ?> >CONTINUOUS</option>
                                         </select>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Defect Order</label>
                              			<input type="number" class="form-control" name="defect_order" value="<?php echo $defect_order; ?>" required>
                            		</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Defect Color</label>
                              			<input type="color"  class="form-control" value="#e0ffee" id="colorPicker" >
                              			
</div>
                            		<div class="col-md-2 col-sm-12">
                              			<label class="form-label">Symbols</label>
                              			<select class="form-control select2-icon" name="defect_symbol" id="defect_symbol" >
                              			<?php 
														$qry = "SELECT * FROM STD_SYMBOLS ORDER BY SYMBOL_NAME";
														$res = mysqli_query($fit, $qry);
														if ($res && mysqli_num_rows($res) > 0) { 
															while ($row = mysqli_fetch_assoc($res)) {
																$selected = ($defect_symbol == $row['SYMBOL_FONT']) ? 'selected' : '';
																$symbol_id=$row['SYMBOL_ID'];
																$symbol_font=$row['SYMBOL_FONT'];
																$symbol_html=$row['SYMBOL_HTML'];
																$symbol_valid=$row['SYMBOL_VALID'];
																$symbol_name=$row['SYMBOL_NAME'];
																
																
																echo '<option value="'.$symbol_font.'" '.$selected.' data-icon='.$symbol_font.'>'.$symbol_name.'</option>';
															}
														}
													?>
                              			  </select>
                            		
								</div>
								<div class="col-md-2 col-sm-12">
                              			
                              			<div class="form-label">Valid</div>
                              			<select class="form-select" name="defect_valid">
                              		 		  <option value="1" <?php if($defect_valid== '1'){echo 'selected';} ?>>Yes</option>
                               				  <option value="0" <?php if($defect_valid == '0'){echo 'selected';} ?>>No</option>
                                         </select>
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
											<th>Order</th>
											<th>Type</th> 
											<th>Defects</th> 
											<th>Sort Name</th>
											
											<th>Valid</th>										
											<th>Color</th>                  
											<th>Symbol</th>                  
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 											
											$qry = "SELECT * FROM STD_DEFECTS ORDER BY DEFECT_TYPE, DEFECT_ORDER";
											$res = mysqli_query($fit, $qry);
											if ($res && mysqli_num_rows($res) > 0) { 
												while ($row = mysqli_fetch_assoc($res)) {				
													$defect_id=$row['DEFECT_ID'];
													$defect_type=$row['DEFECT_TYPE'];
													$defect_name=$row['DEFECT_NAME'];
													
													$defect_shortname=$row['DEFECT_SHORTNAME'];
													$defect_valid=$row['DEFECT_VALID'];
													
													$defect_color=$row['DEFECT_COLOR'];
													$defect_symbol=$row['DEFECT_SYMBOL'];	
													$defect_order=$row['DEFECT_ORDER'];				
												?>
												
												<tr class="gradeX">
													<td><?php echo $defect_order; ?></td>
													<td><?php if($defect_type=='2'){echo 'CONTINUOUS';} else{ echo '4_POINT';} ?></td>
													
												
													<td><?php echo $defect_name; ?></td>
													<td><?php echo $defect_shortname; ?></td>
													
													<td>
														<?php
															if($defect_valid==1){
																echo '<i class="fa fa-check" style="color:green"></i>';
																echo 'YES';
															}
															else{
																echo '<i class="fa fa-times" style="color:red"></i>';
																echo 'NO';
															}
														?>
													</td>
													
													
													<td><span class="btn" style="width: 20px; height: 20px; margin: 1px 5px; background-color:<?php echo $defect_color; ?>"></span></td>
													<td><i class="fa <?php echo $defect_symbol; ?>" style="color:red"></i></td>
													<td class="center">
														<a href="std_defects.php?edit_id=<?php echo $defect_id;  ?>" class="btn btn-success btn-mini">Edit</a>												
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
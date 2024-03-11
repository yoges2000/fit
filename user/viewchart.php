<?php

require_once 'session.php';
$title = 'Inspection Chart';
$page_group = 'reports';
$roll_parentid = $_GET['roll_parentid'];

$roll_start_date=GFV("ROLL", "ROLL_INSP_DATE", "ROLL_ID='$roll_parentid'");
$defectable = $mth_db . ".DEFECT_" . date('mY', strtotime($roll_start_date));


 $query = "SELECT ROLL_NUMBER, ROLL_WIDTH as total_width, ROLL_LENGTH as total_length FROM ROLL WHERE ROLL_ID='$roll_parentid' ";
$res = mysqli_query($fit, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $total_length = $row['total_length'];
     $total_width = $row['total_width'];
    $rollno = $row['ROLL_NUMBER'];
}

if($total_width<100){
    $total_width=100;
}



?>

<!doctype html>

<html lang="en">

<head>

<?php include '../includes/styles.php'; ?>
  <title><?php echo $title;?></title>
 <style>
	table tbody {
		overflow: auto;
		
	}
    .responsiveTbl th,.responsiveTbl td{
		padding: 7px;
    }
	 
	#ins_chart {

		/* overflow: auto;
		height: 550px;
		background: url(img/Large_0431048.jpg) ;*/
		width: 100%
	}

	.plot {
		width: 50%;
		margin: 10px 10px 0 0;
		padding: 5px 10px
	}

	.thcolor {
		background-color: black;
		opacity: 0.4;
		color: #fff;
		/* font-weight: 700; */
		text-align: -webkit-center;
		font-size: 12px;
	}


	.tableFixHead { overflow-y: auto; height: calc(100vh - 150px); }
	.tableFixHead1 { overflow-y: auto; height: calc(100vh - 150px); }
</style>
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
						<?php echo $title . "for Roll : " . $rollno;?>
						</strong>
						<!-- <div class="card-actions"> 
								<a href="javascript:void(0);" id="pdf_btn" title="Print" style="color:red;font-size: 20px;margin: 1px 5px;" onClick="window.print()">
									<i class="fa fa-print" aria-hidden='true'></i>
								</a>

								<a href="javascript:void(0);" id="excel_btn" title="Export Excel" style="color:green;font-size: 20px;margin: 1px 5px;" onClick="cleanTableExcel('displayreport','Inspection Report');">
									<i class="fa fa-file-excel" aria-hidden='true'></i>
								</a>

								
							</a>
		
						</div> -->
										
					</div>
                  <div class="card-body">
                  <?php include '../includes/alert.php'; ?>		
                 <div class="container1">
			<?php
					$no_of_columns = ceil($total_width / 10) + 1;
					$col_width = round((100 / $no_of_columns), 2) . '%';
			?>
				  <div class="row">
				  <!--------------------------table------------------------>
					<div class="col-2">
					  <table class="responsiveTbl tableFixHead1" style="width:100%;">
							<thead> 
								<tr>
									<th style="border: 1px solid;">Sno</th>
									<th style="border: 1px solid;">Length</th>
									<th style="border: 1px solid;">Width</th>
									<th style="border: 1px solid;">Defect</th>
								</tr>
							</thead>	
							<tbody>	
							<?php 
							 $dsql = "SELECT * FROM  $defectable d inner join STD_DEFECTS sd on(d.CD_DEFECT=sd.DEFECT_ID) WHERE 1 AND CD_ROLL_ID='$roll_parentid'";
								$e_dsql=mysqli_query($fit,$dsql);
								$c=1;
								while($r_dsql=mysqli_fetch_array($e_dsql)){
								?>
								<tr>
									<td style="border: 1px solid;"><?php echo $c; ?></td>
									<td style="border: 1px solid;"><?php echo $r_dsql['CD_STARTLENGTH']; ?></td>
									<td style="border: 1px solid;"><?php echo $r_dsql['CD_WIDTH']; ?></td>
									<td style="border: 1px solid;"><?php echo $r_dsql['DEFECT_NAME']; ?></td>
								</tr>
								
								<?php $c++; } ?>
							</tbody>	
					  </table>
					</div>
					 <!--------------------------table------------------------>
					 <!--------------------------Chart------------------------>
					<div class="col-10" >
					<div class="tableFixHead">
					  <table style="background-image: url('../assets/images/chartbg.jpg');">
					<thead> 
						<tr>
								<th class="thcolor" style="width: <?php echo $col_width; ?>;">&nbsp;&nbsp;&nbsp;</th>
								<?php
								for ($j = 0; $j <= ceil($total_width / 10); $j++) {
									if ($j <= 9) {
										$a = number_format($j * 10, 0);
										//$a = str_pad($a, 3, '0', STR_PAD_LEFT);
									} else {
										$a = number_format($j * 10, 0);
									} 
									
								?>
									<th class="thcolor" style="width: <?php echo $col_width; ?>;"><?php echo $a; ?></th>
								<?php

								}

								?>
							</tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i <= ceil($total_length); $i++) {
							?>
								<tr>
									<td class="thcolor" style="width: <?php echo $col_width; ?>;"><?php echo $i; ?></td>
									<?php
									for ($k = 0; $k <= ceil($total_width / 10); $k++) {
										$start_width = $k * 10;
										$end_width  = ($k + 1) * 10;
										$sql1 = "SELECT * FROM  $defectable WHERE CD_STARTLENGTH LIKE '$i.%' AND CD_WIDTH >= $start_width AND CD_WIDTH < $end_width AND CD_ROLL_ID='$roll_parentid'";
										$res1 = mysqli_query($fit, $sql1);
										if ($res1 && mysqli_num_rows($res1) > 0) {
											while ($row1 = mysqli_fetch_assoc($res1)) {
												$cd_id = $row1['CD_ID'];
												$cd_startlength = $row1['CD_STARTLENGTH'];
												$cd_width = $row1['CD_WIDTH'];
												$defect_id = $row1['CD_DEFECT'];
												$query2 = "SELECT * FROM STD_DEFECTS WHERE DEFECT_ID='$defect_id' ";
												$res2 = mysqli_query($fit, $query2);
												while ($row2 = mysqli_fetch_assoc($res2)) {
													$defect_name = $row2['DEFECT_NAME'];
													$defect_code = $row2['DEFECT_CODE'];
													$defect_symbol = $row2['DEFECT_SYMBOL'];
													$defect_color = $row2['DEFECT_COLOR'];
												}
												$plot = '';
												$plot .= "<span class='fa-stack fa-sm'>";
												$plot .= "<i class='fa fa-square-o fa-stack-2x' style='color: black'></i>";
												$plot .= "<i title='Defect:" . $defect_name . " | Width:" . $cd_width . " | Length:" . $cd_startlength . "' class='fa " . $defect_symbol . " fa-stack-1x' style='color: " . $defect_color . "' aria-hidden='true'></i>";
												$plot .= "</span>";
											}
										} else {
											$plot = '';
										}


									?>
										<td style="text-align:center; width: <?php echo $col_width; ?>;"><?php echo $plot;  ?></td>
									<?php
									}
									?>
								</tr>
							<?php
							}

							?>
						</tbody>
					</table>
					</div>
					</div>
					 <!--------------------------Chart------------------------>
				  </div>
				 
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


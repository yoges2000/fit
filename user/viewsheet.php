<?php

require_once 'session.php';
$title = 'Inspection Sheet';
$page_group = 'reports';
$roll_parentid = $_GET['roll_parentid'];

$roll_start_date=GFV("ROLL", "ROLL_INSP_DATE", "ROLL_ID='$roll_parentid'");


$defectable = $mth_db . ".DEFECT_" . date('mY', strtotime($roll_start_date));


$type_arr = array();
$length_arr = array();
$defect_arr = array();
$point_arr = array();
$date_arr = array();
$shiftchange_arr = array();

//4 POINT DEFECTS
$qry2 = "SELECT * FROM $defectable WHERE CD_ROLL_ID = '$roll_parentid' AND CD_TYPE != '2'";
$res2 = mysqli_query($fit, $qry2);
if ($res2 && mysqli_num_rows($res2) > 0) {
    while ($row2 = mysqli_fetch_assoc($res2)) {
        $type_arr[] = $row2['CD_TYPE'];
        if( round($row2['CD_STARTLENGTH'])>300 && (round($row2['CD_STARTLENGTH'])%2)!=0){
            $length_arr[] = (round($row2['CD_STARTLENGTH'])+1);
        }else{
         $length_arr[] = round($row2['CD_STARTLENGTH']);
        }
        $defect_arr[] = $row2['CD_DEFECT'];
        $point_arr[] = $row2['CD_POINT'];
        $date_arr[] = $row2['CD_DATE'];
        $shiftchange_arr[] = $row2['CD_SHIFTCHANGE'];
    }
}


//CONTINOUS DEFECTS
$qry2 = "SELECT * FROM $mth_db.$defectable WHERE CD_ROLL_ID = '$roll_parentid' AND CD_TYPE = '2'";
$res2 = mysqli_query($fit, $qry2);
if ($res2 && mysqli_num_rows($res2) > 0) {
    $endout_length_arr = array();
    $endout_defect_arr = array();
    while ($row2 = mysqli_fetch_assoc($res2)) {
        
        if( round($row2['CD_STARTLENGTH'])>300 && (round($row2['CD_STARTLENGTH'])%2)!=0){
            $endout_slength= (round($row2['CD_STARTLENGTH'])+1);
        }else{
            $endout_slength = round($row2['CD_STARTLENGTH']);
        }
        
        if( round($row2['CD_ENDLENGTH'])>300 && (round($row2['CD_ENDLENGTH'])%2)!=0){
            $endout_slength= (round($row2['CD_ENDLENGTH'])+1);
        }else{
            $endout_elength = $row2['CD_ENDLENGTH'];
        }
        
     
        $endout_defect = $row2['CD_DEFECT'];
        
        for ($i = $endout_slength; $i <= $endout_elength; ++$i) {
            $endout_length_arr[] = $i;
            $endout_defect_arr[] = $endout_defect;
        }
    }
}

//$ins_name = GFV("INSPECTORS", "INSP_NAME", "INSP_ID='$roll_inspid'");
//$mc_name = GFV("STD_MACHINES", "MC_NAME", "MC_ID='$roll_mcid'");








?>

<!doctype html>

<html lang="en">

<head>

<?php include '../includes/styles.php'; ?>
  <title><?php echo $title;?></title>
 <style>
 
 .table > :not(caption) > * > *, .markdown > table > :not(caption) > * > * {
  padding: 1px;
  background-color: var(--tblr-table-bg);
  border-bottom-width: 1px;
  box-shadow: inset 0 0 0 9999px var(--tblr-table-accent-bg);
}
		.printpage {
			width: 230mm;
			min-height: 317mm;
			padding: 2mm 5mm;;
			margin: 5mm auto;
			border: 1px #D3D3D3 solid;
			border-radius: 5px;
			background: white;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		}

		

		@page {
			size: A4;
			margin: 0;
		}

		@media print {
			body * {
				visibility: hidden;
			}

			#non-printable,
			#non-printable * {
				visibility: hidden;
				display: none;
			}

			#printable,
			#printable * {
				visibility: visible;
			}

			.printpage {
				margin: -50px 0px 0px 20px;
				padding:0px;
				border: initial;
				border-radius: initial;
				width: initial;
				min-height: initial;
				box-shadow: initial;
				background: initial;
				border-color:black;
			}

			.subpage {
				
			}
		}


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
						<?php echo $title;?>
						</strong>
						<div class="card-actions"> 
								<a href="javascript:void(0);" id="pdf_btn" title="Print" style="color:red;font-size: 20px;margin: 1px 5px;" onClick="window.print()">
									<i class="fa fa-print" aria-hidden='true'></i>
								</a>

								<a href="javascript:void(0);" id="excel_btn" title="Export Excel" style="color:green;font-size: 20px;margin: 1px 5px;" onClick="cleanTableExcel('displayreport','Inspection Report');">
									<i class="fa fa-file-excel" aria-hidden='true'></i>
								</a>

								
							</a>
		
						</div>
										
					</div>
                  <div class="card-body">
                  <?php include '../includes/alert.php'; ?>		
                 <?php 
                   $selqry="SELECT ROLL_NUMBER,ROLL_ID,MC_ID,MC_NAME,ROLL_WARPLOT,ROLL_EPI,ROLL_PPCM,ROLL_WIDTH,ROLL_WEFTLOT,INSP_ID,INSP_NAME,ROLL_DOFF_LOOM,STYLE,DESCR,PPCM,ROLL_INSP_DATE,ROLL_DOFF_DATE,ROLL_DOFF_LENGTH,max(ROLL_LENGTH) as ROLL_LENGTH,ROLL_STARTTIME,ROLL_ENDTIME,ROLL_GP,ROLL_GRADE,ROLL_TOTAL_DEFECTS,ROLL_TOTAL_POINTS FROM ROLL INNER JOIN STD_STYLES ON(STYLE_ID=ROLL_STYLE_ID) INNER JOIN INSPECTORS ON(ROLL_INSP_ID=INSP_ID) INNER JOIN STD_MACHINES ON(ROLL_MC_ID=MC_ID) WHERE ROLL_ID='$roll_parentid'";
                   $res=mysqli_query($fit, $selqry);
                   if(mysqli_num_rows($res)>0){
                       $mrow=mysqli_fetch_assoc($res);
                   
                 
                 ?>
              <div id="non-printable" style="float:right"></div>          
						
		    <div id="printable">
			<div class="container-fluid">
				<div class="printpage">
					<div class="subpage">
						<!--<h5 style="text-align:center; font-weight:bold"><?php  echo $_SESSION['millname'];?></h5>-->
						<h6 style="text-align:center; font-weight:bold">INSPECTION REPORT</h6>
						<table class="table table-bordered" style="margin-bottom:0px; font-size:8pt;border-color:#000000;">
							<tbody>
								<tr>
									<td>Loom No</td>
									<td><?php echo $mrow['ROLL_DOFF_LOOM']; ?></td>
									<td>Table No.</td>
									<td><?php echo  $mrow['MC_NAME']; ?></td>
									<td>Doff Date</td>
									<td><?php echo  date("d-m-Y",strtotime($mrow['ROLL_DOFF_DATE'])); ?></td>
									<td>REC/WHS/003</td>
									<td>Warp</td>
									<td><?php echo $mrow['ROLL_WARPLOT']; ?></td>
								</tr>
								<tr>
									<td>Piece No</td>
									<td><?php echo $mrow['ROLL_NUMBER']; ?></td>
									<td>Cons.</td>
									<td colspan='4'><?php echo $mrow['DESCR']; ?></td>
									
									<td>Weft</td>
									<td><?php echo $mrow['ROLL_WEFTLOT']; ?></td>
								</tr>
								<tr>
									<td>Sort No</td>
									<td>A.Reed</td>
									<td>A.PPI</td>
									<td>A.Width</td>
									<td>S (or) Z</td>
									<td>Weave</td>
									<td>Selvedge Colour</td>
									<td>Tube Inch</td>
									<td></td>
								</tr>
								<tr>
									<td><?php echo $mrow['STYLE']; ?></td>
									<td><?php echo $mrow['ROLL_EPI']; ?></td>
									<td><?php echo $mrow['ROLL_PPCM']; ?></td>
									<td><?php echo $mrow['ROLL_WIDTH']; ?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>Note:Std Points:20/100 mtrs</td>
								</tr>
								
							</tbody>
						</table>



						<?php
						$style = "text-align:center; min-width:30px;border-color:black";
						
						
						// Defect Table for Inspection Sheet Data
					

						


						$total_pages = 2;
						$firstpage_row = 50;
						$firstpage_end = 300;

						echo '<table class="table table-bordered" width="100%" style="font-size:7.5pt;">';
									echo '<tr>';
									echo '<td style="' . $style . '" >Mtrs</td>';
									echo '<td style="' . $style . '" >Damage</td>';
									echo '<td style="' . $style . '" >Mtrs</td>';
									echo '<td style="' . $style . '" >Damage</td>';
									echo '<td style="' . $style . '" >Mtrs</td>';
									echo '<td style="' . $style . '" >Damage</td>';
									echo '<td style="' . $style . '" >Mtrs</td>';
									echo '<td style="' . $style . '" >Damage</td>';
									echo '<td style="' . $style . '" >Mtrs</td>';
									echo '<td style="' . $style . '" >Damage</td>';
									echo '<td style="' . $style . '" >Mtrs</td>';
									echo '<td style="' . $style . '" >Damage</td>';
									
									echo '</tr>';
						for ($i = 1; $i <= $firstpage_row; $i++) {
							$k = $i;
							
						
							echo '<tr>';
							
							for ($j = 1; $j <= 6; $j++) {
								
									
								if ($k <= 300) {
									$index = array_search($k, $length_arr);
									if (!empty($index) || $index === 0) {
										if ($type_arr[$index] == '1') {
											// Display Defect Length
											$defect_id = $defect_arr[$index];
											$qry = "select * from STD_DEFECTS where DEFECT_ID='$defect_id'";
											$res = mysqli_query($fit, $qry);
											if ($res && mysqli_num_rows($res) > 0) {
												$row = mysqli_fetch_assoc($res);
												$defect_name = $row['DEFECT_ENGNAME'];
												$particular1 = $row['DEFECT_SHORTNAME'];
											}
											$particular2 = $point_arr[$index];
										} else if ($type_arr[$index] == '3') {
											// Display Shift Change Length
											$particular1 = date('d/m', strtotime($date_arr[$index]));
											$particular2 = $shiftchange_arr[$index];
										}
									} else {
										$particular1 = '';
										$particular2 = '';
									}

									// Display Endout Lengths
									$endout_check = false;
									$endout_index = array_search($k, $endout_length_arr);
									if (!empty($endout_index) || $endout_index === 0) {
										$endout_defect_shortname = GFV("STD_DEFECTS", "DEFECT_SHORTNAME", "DEFECT_ID='$endout_defect_arr[$endout_index]'");
										 $qry3 = "SELECT * FROM $mth_db.$defectable WHERE CD_PARENT_ID = '$roll_parentid' AND CD_TYPE != '2' AND CD_LENGTH='$k'";
										$res3 = mysqli_query($fit, $qry3);
										if ($res3 && mysqli_num_rows($res3) > 0) {
											$row3 = mysqli_fetch_assoc($res3);
											$cd_type3 = $row3['CD_TYPE'];
											$cd_defect3 = $row3['CD_DEFECT'];
											$cd_point3 = $row3['CD_POINT'];
											$cd_date3 = $row3['CD_DATE'];
											
											$defect_shortname3 = GFV("STD_DEFECTS", "DEFECT_SHORTNAME", "DEFECT_ID='$cd_defect3'");
											
												$particular1 = $defect_shortname3;
												$particular2 = $cd_point3;
												$endout_check = false;
											
										} else {
											$particular1 = $endout_defect_shortname;
											$particular2 = '4';
											$endout_check = true;
										}
									}

									if ($endout_check == true) {
										$style = "text-align:center; min-width:30px; background-color:#ffcccb;border-color:#000000;";
									} else {
										$style = "text-align:center; min-width:30px;border-color:#000000;";
									}

									echo '<td style="' . $style . '" >' . $k . '</td>';
									echo '<td style="' . $style . '" >' . $particular1 . '  ' . $particular2 . '</td>';
									//echo '<td style="' . $style . '" >' . $particular2 . '</td>';

									$k = $k + $firstpage_row;
								} else {
									echo '<td style="text-align:center;  font-weight:bold; min-width:30px;">&nbsp;</td>';
									echo '<td style="text-align:center;  font-weight:bold; min-width:50px;"  >&nbsp;</td>';
									//echo '<td style="text-align:center;  font-weight:bold; min-width:30px;" >&nbsp;</td>';
								}
							}
							echo '</tr>';
						}
						
						echo '</table>';
						
						$sty="text-align:left;border-color:#000000;";
?>

						<table class="table table-bordered" width="100%" style="font-size:7pt;border-color:#000000;" >
						<tr>
						
						<td style="">DATALOG MTR</td>
						<td style="<?php echo $sty;?>">INSPECTED MTR</td>
						<td style="<?php echo $sty;?>">PASS MTR</td>
						<td style="<?php echo $sty;?>">T-MTR ABOVE-20</td>
						<td style="<?php echo $sty;?>">RT-MTR BELOW 20</td>
						<td style="<?php echo $sty;?>">FRC BIT-MTR</td>
						<td style="<?php echo $sty;?>">TOTAL-MTR</td>
						<td style="<?php echo $sty;?>">SHORT</td>
						<td style="<?php echo $sty;?>">EXCESS</td>
						<td style="<?php echo $sty;?>">WGT IN KG</td>
						</tr>
						
						<tr>
						<td style="<?php echo $sty;?>"><?php echo $mrow['ROLL_DOFF_LENGTH'];?></td>
						<td style="<?php echo $sty;?>"><?php echo  $mrow['ROLL_LENGTH'];?></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"></td>
						</tr>
						
						<tr>
						<td style="<?php echo $sty;?>">ATTI NO</td>
						<td style="<?php echo $sty;?>">ROLL NO</td>
						<td style="<?php echo $sty;?>" colspan="2">CHECKED BY</td>
						<td style="<?php echo $sty;?>" colspan="2">WH-CLERK</td>
						<td style="<?php echo $sty;?>">WH-SUPERVISOR</td>
						<td style="<?php echo $sty;?>">TOTAL POINTS</td>
						<td style="<?php echo $sty;?>" colspan="2">POINTS/100 MTRS</td>
						</tr>
						
						<tr>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"><?php echo $mrow['ROLL_NUMBER'];?></td>
						<td style="<?php echo $sty;?>" colspan="2"><?php echo $mrow['INSP_NAME'];?></td>
						<td style="<?php echo $sty;?>" colspan="2"></td>
						<td style="<?php echo $sty;?>"></td>
						<td style="<?php echo $sty;?>"><?php echo $mrow['ROLL_TOTAL_POINTS'];?></td>
						<td style="<?php echo $sty;?>" colspan="2"><?php echo $mrow['ROLL_GP'];?></td>
						</tr>
						
						</table>
						
						
						
						
						
						
						<table class="table table-bordered" width="100%" style="font-size:7pt;border-color:#000000;">
						<tr>
						<td style="">Fushing</td>
						<td style="">100</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="">200</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="">300</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="">400</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="">500</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="">600</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="">700</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td style="">800</td>
						<td style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
						</table>
						
						
						
					</div>
				</div>

				<?php
				if ($total_pages >1) {
					for ($p = 2; $p <= $total_pages; $p++) {
						echo '<div class="printpage">';
						echo '<div class="subpage">';
						echo '<br/>';
						echo '<br/>';
						echo '<div>&nbsp;</div>';
						echo '<table class="table table-bordered" width="100%" style="font-size:7.5pt;">';
						$Pre_page_last=300;
						$page_row_Count = 50;
						$page_row_end = 400;
						
						for ($i = $Pre_page_last + 1; $i <= $page_row_end; $i++) {
							    if($i%2==0){
							    
								$k = $i;
								echo '<tr>';
								for ($j = 1; $j <= 6; $j++) {
									if ($k <= 900) {
										$index = array_search($k, $length_arr);
										if (!empty($index) || $index === 0) {
										    // Display Defect Length
										    $defect_id = $defect_arr[$index];
										    $qry = "select * from STD_DEFECTS where DEFECT_ID='$defect_id'";
										    $res = mysqli_query($fit, $qry);
										    if ($res && mysqli_num_rows($res) > 0) {
										        $row = mysqli_fetch_assoc($res);
										        $defect_name = $row['DEFECT_ENGNAME'];
										        $particular1 = $row['DEFECT_SHORTNAME'];
										    }
										    $particular2 = $point_arr[$index];
										} else {
											$particular1 = '';
											$particular2 = '';
										}

										// Display Endout Lengths
										$endout_check = false;
										$endout_index = array_search($k, $endout_length_arr);
										if (!empty($endout_index) || $endout_index === 0) {
											$endout_defect_shortname = GFV("STD_DEFECTS", "DEFECT_SHORTNAME", "DEFECT_ID='$endout_defect_arr[$endout_index]'");
											$qry3 = "SELECT * FROM $mth_db.$defectable WHERE CD_ROLL_ID = '$roll_parentid' AND CD_TYPE != '2' AND CD_LENGTH='$k'";
											$res3 = mysqli_query($fit, $qry3);
											if ($res3 && mysqli_num_rows($res3) > 0) {
												$row3 = mysqli_fetch_assoc($res3);
												$cd_type3 = $row3['CD_TYPE'];
												$cd_defect3 = $row3['CD_DEFECT'];
												$cd_point3 = $row3['CD_POINT'];
												$cd_date3 = $row3['CD_DATE'];
												$cd_shiftchange3 = $row3['CD_SHIFTCHANGE'];
												$defect_shortname3 = GFV("STD_DEFECTS", "DEFECT_SHORTNAME", "DEFECT_ID='$cd_defect3'");
												if ($cd_type3 == '1') {
													$particular1 = $defect_shortname3;
													$particular2 = $cd_point3;
													$endout_check = false;
												} else {
													$particular1 = date('d/m', strtotime($cd_date3));
													$particular2 = $cd_shiftchange3;
													$endout_check = false;
												}
											} else {
												$particular1 = $endout_defect_shortname;
												$particular2 = '4';
												$endout_check = true;
											}
										}

										if ($endout_check == true) {
											$style = "text-align:center; min-width:30px; background-color:#ffcccb;border-color:#000000;";
										} else {
											$style = "text-align:center; min-width:30px;border-color:#000000;";
										}

										echo '<td style="' . $style . '" >' . $k . '</td>';
										echo '<td style="' . $style . '" >' . $particular1 . ' ' . $particular2 . '</td>';
										//echo '<td style="' . $style . '" >' . $particular2 . '</td>';

										$k = $k + ($page_row_Count*2);
									} else {
										echo '<td style="text-align:center;  font-weight:bold; min-width:30px;">&nbsp;</td>';
										echo '<td style="text-align:center;  font-weight:bold; min-width:50px;"  >&nbsp;</td>';
										//echo '<td style="text-align:center;  font-weight:bold; min-width:30px;" >&nbsp;</td>';
									}
								}
								echo '</tr>';
							}
						}
						
						
						echo '</table>';

						
						echo '</div>';
						echo '</div>';

					}
				}
				?>

			</div>
		</div>
		<?php }else{?>
						<div>No data</div>
							
					<?php }?>	
                  </div>
                </div>
        </div>
      </div>

    </div>
  </div>
   
			
 <?php include '../includes/scripts.php'; ?>

</body>

</html>


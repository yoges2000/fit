<?php
require_once 'session.php';

$page_group = 'dashboard';

// Update Machine Running or Stop Status
$qry= "SELECT * FROM `STD_MACHINES` WHERE 1";
$res = mysqli_query($fit,$qry);
while($row=mysqli_fetch_assoc($res)){
    $mc_id = $row0['MC_ID'];
    $mc_length = $row['MC_LENGTH'];
    $mc_scantime = $row['MC_SCANTIME'];
    $mc_prelen = $row['MC_PRELEN'];
    $mc_pretime = $row['MC_PRETIME'];
    if($mc_length != $mc_prelen){
        $run_status = '1';
    }
    else{
        $run_status = '0';
    }
    $cur_time = date('h:i:s');
    $qry_update = "UPDATE STD_MACHINES SET MC_STATUS='$run_status', MC_PRELEN='$mc_length', MC_PRETIME='$cur_time' WHERE MC_ID='$mc_id'";
    mysqli_query($fit, $qry_update);
}

?>

<!doctype html>
<html lang="en">
<head>

<?php include '../includes/styles.php'; ?>
  <title>Dashboard - Datalog</title>
 
</head>

<body>
  <div class="page">
<?php include '../includes/navmenu.php'; ?>
    <div class="page-wrapper">
      <div class="container-fluid">
        <!-- Page title -->
        <div class="page-header d-print-none">
          <div class="row align-items-center">
            <div class="col">
              <!-- Page pre-title -->
              
              <h2 class="page-title">
                Dashboard
               
              </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
              <div class="btn-list">

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page-body">
        <div class="container-fluid">
                
         <div class="row">
        <?php									
										$query1 = "SELECT * FROM `STD_MACHINES` WHERE 1 and mc_valid=1";
										$res1 = mysqli_query($fit,$query1);
										while($row1=mysqli_fetch_assoc($res1)){
											$mc_id = $row1['MC_ID'];
											$mc_name = $row1['MC_NAME'];
											$mc_status = $row1['MC_STATUS'];
											$mc_length = $row1['MC_LENGTH'];
											
											
											
											/*--------------------------side 1--------------------------*/
											$query2 = "SELECT * FROM ROLL WHERE ROLL_MC_ID='$mc_id' AND ROLL_CURRENT='1' ";
											$res2 = mysqli_query($fit,$query2);
											$row2=mysqli_fetch_assoc($res2);
											$roll_id = $row2['ROLL_ID'];
											$roll_insid = $row2['ROLL_INSP_ID'];
											$roll_stylenum= $row2['ROLL_STYLE_ID'];
											
											$roll_loom_no= $row2['ROLL_LOOM_NO'];
											$roll_date = $row2['ROLL_DATE'];
											$roll_dofflength = $row2['ROLL_DOFF_LENGTH'];
											$roll = $row2['ROLL_NUMBER'];
											$roll_width = $row2['ROLL_WIDTH'];
											$style=GFV("STD_STYLES", "STYLE", "STYLE_ID='$roll_stylenum'");
											$ppcm=GFV("STD_STYLES", "PPCM", "STYLE_ID='$roll_stylenum'");
											$epi=GFV("STD_STYLES", "EPI", "STYLE_ID='$roll_stylenum'");
											$insp_name = GFV("INSPECTORS", "INSP_NAME", "INSP_ID='$roll_insid'");
											$defect_count= GFV("CURDEFECTS", "COUNT(CD_DEFECT)", "CD_ROLL_ID='$roll_id'");
											/*--------------------------side 1--------------------------*/
											?>
											<div class="col-md-3" style="padding:10px">
											 <div class="card">
                      <div class="card-header canv" style="background:linear-gradient(to right, #003300 0%, #ccffff 100%);color:white" data-bs-toggle="offcanvas" data-id="<?php echo $mc_id;?>" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd">
                        <h3 class="card-title " style="font-weight: bold">
                         <?php echo $mc_name;?>
                        </h3>
                        
                      </div>
                      <div class="card-body" style="background: #cdf9fb">
                        <dl class="row">
                        	<dt class="col-5">Inspector</dt>
                          <dd class="col-7"><?php echo (!empty($insp_name))?$insp_name:'NA';?></dd>
                          <dt class="col-5">Roll No.</dt>
                          <dd class="col-7"><?php echo (!empty($roll))?$roll:'NA';?></dd>
                          <dt class="col-5">Style</dt>
                          <dd class="col-7"><?php echo (!empty($style))?$style:'NA';?></dd>
                          <dt class="col-5">Ppi</dt>
                          <dd class="col-7"><?php echo (!empty($ppcm))?$ppcm:'NA';?></dd>
                          <dt class="col-5">Epi</dt>
                          <dd class="col-7"><?php echo (!empty($epi))?$epi:'NA';?></dd>
                          <dt class="col-5">Roll Length</dt>
                          <dd class="col-7"><?php echo (!empty($roll_dofflength))?$roll_dofflength:'NA';?></dd>
                          <dt class="col-5">Current Length</dt>
                          <dd class="col-7"><?php echo (!empty($mc_length))?$mc_length:'NA';?></dd>
                          <dt class="col-5">No of Defects</dt>
                          <dd class="col-7"><?php echo (!empty($defect_count))?$defect_count:'NA';?></dd>
                          
                        </dl>
                      </div>
                    </div>
											</div>
											
											<?php 
											
										}
											
										?> 
         </div>
 				
        </div>
           <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
              <div class="offcanvas-header">
                <h2 class="offcanvas-title" id="offcanvasEndLabel">Current Roll Defects</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <div id="dispdefects">
                </div>
                
              </div>
            </div>
      </div>

    </div>
  </div>

 <?php 
 header("Refresh:10");
include '../includes/scripts.php'; 

 
 ?>
<script>


$('.canv').click(function(){
	var mcid=$(this).attr("data-id")
	$.ajax({

		type:"POST",

		url:"../ajax/getcurrentdefects.php",

		data:{'mcid':mcid},

		success:function (data){

			$('#dispdefects').html(data);

			
		}
	});
		
});


</script>
</body>

</html>
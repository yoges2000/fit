<?php

require_once 'session.php';
$title = 'Inspection Label';
$page_group = 'reports';
$roll_parentid = $_GET['roll_parentid'];

 $selqry="SELECT ROLL_NUMBER,ROLL_ID,MC_ID,MC_NAME,ROLL_WARPLOT,ROLL_EPI,ROLL_PPCM,ROLL_WIDTH,ROLL_WEFTLOT,INSP_ID,INSP_NAME,ROLL_DOFF_LOOM,STYLE,DESCR,PPCM,ROLL_INSP_DATE,ROLL_DOFF_DATE,ROLL_DOFF_LENGTH,max(ROLL_LENGTH) as ROLL_LENGTH,ROLL_STARTTIME,ROLL_ENDTIME,ROLL_GP,ROLL_GRADE,ROLL_TOTAL_DEFECTS,ROLL_TOTAL_POINTS FROM ROLL INNER JOIN STD_STYLES ON(STYLE_ID=ROLL_STYLE_ID) INNER JOIN INSPECTORS ON(ROLL_INSP_ID=INSP_ID) INNER JOIN STD_MACHINES ON(ROLL_MC_ID=MC_ID) WHERE ROLL_ID='$roll_parentid'";
$res=mysqli_query($fit, $selqry);
if(mysqli_num_rows($res)>0){
    $mrow=mysqli_fetch_assoc($res);

}

$string = trim($mrow['ROLL_NUMBER']);
$type = 'code128';
$orientation = 'horizontal';
$size = '20';
$print = 'false';
$mode = 'Meters';





?>

<!doctype html>

<html lang="en">

<head>

<?php include '../includes/styles.php'; ?>
  <title><?php echo $title;?></title>
 <style>
	/* these are just styles added for this demo page */
	#canvas {
		width: 104mm;
		height: 128mm;
		margin: 0 auto;
		background: #fff;
		padding: 2mm;
	}

	.ts {
		border: none;
		font-size: 12px;
		font-weight: 600;
		font-family: Arial, Helvetica, sans-serif;
		width: 100mm;
	}

	.ts td {
		border: none;
		padding: 0mm;
	}

	.td1 {
		width: 3mm;
	}

	.td2 {
		width: 28mm;
	}

	.td3 {
		width: 3mm;
	}

	.td4 {
		width: 30mm;
	}

	.td5 {
		width: 3mm;
	}

	.td6 {
		width: 4mm;
	}

	.td7 {
		width: 13mm;
	}

	.td8 {
		width: 13mm;
	}

	.td9 {
		width: 3mm;
	}

	.bdr_top {
		border-top: 1px solid black;
	}

	.bdr_btm {
		border-bottom: 1px solid black;
	}

	.bold {
		font-weight: 900;
	}

	.center {
		text-align: center;
	}


	img.barcode {
		width: 260px;
		height: 40px;
	}

	.movable_div {
		background-color: #fff;
		color: black;
		/* font-family: Verdana;  */
		font-family: Arial, Helvetica, sans-serif;
		cursor: move;
		position: absolute;
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

						</div>
										
					</div>
                  <div class="card-body">
                  <?php include '../includes/alert.php'; ?>		
                
                  
                 <div id="canvas">
                 <div class="movable_div1" id="print">
                 <div>
                
                <table class="ts">
                <tbody>
                 
                <tr class="bdr_top">
                <td colspan="9" class="bold center">CS WEAVERSS</td>
                </tr>
                 
                <tr>
                <td colspan="9" class="center"><img class="barcode" alt="<?php echo  $string;?>" src="../barcode/barcode.php?text=<?php echo $string . '&codetype=' . $type . '&orientation=' . $orientation . '&size=' . $size . '&print=' . $print ;?>"/></td>
                </tr>
                 
                <tr>
                <td colspan="9" class="center">Roll Number</td>
                </tr>
                 
                <tr>
                <td colspan="9" class="bold center" style="font-size:22px;"><?php echo $mrow['ROLL_NUMBER'];?></td>
                </tr>
                 <tr class="bdr_top">
                 </tr>
                 <tr>
                 <tr>
					<td colspan="9" style="margin:0px; padding:0px">&nbsp; &nbsp;</td>
				</tr>
				<tr>
				<td class="td1"> </td>
				<td class="td2 bold">Sort No:</td>
				<td class="td3"> </td>
				<td class="td4 bold">Loom No:</td>
				<td class="td5"> </td>
				<td class="bold" colspan="3">Operator:</td>
				<td class="td9"> </td>
				
				</tr>
				<tr>
                 <td class="td1"> </td>
				 <td class="td2"><?php echo $mrow['STYLE'];?></td>
								<td class="td3"> </td>
								<td class="td4"><?php echo $mrow['ROLL_DOFF_LOOM'];?></td>
								<td class="td5"> </td>
								<td colspan="3"><?php echo $mrow['INSP_NAME'];?></td>
								<td class="td9"> </td>
                </tr>
                
                <tr>
					<td colspan="9" style="margin:0px; padding:0px">&nbsp; &nbsp;</td>
				</tr>
				<tr>
				<td class="td1"> </td>
				<td class="td2 bold">Roll Length:</td>
				<td class="td3"> </td>
				<td class="td4 bold">Customer:</td>
				<td class="td5"> </td>
				<td class="bold" colspan="3">Ppcm</td>
				<td class="td9"> </td>
				
				</tr>
				<tr>
                 <td class="td1"> </td>
				 <td class="td2"><?php echo $mrow['ROLL_LENGTH'];?></td>
								<td class="td3"> </td>
								<td class="td4"><?php echo $mrow['DESCR'];?></td>
								<td class="td5"> </td>
								<td colspan="3"><?php echo $mrow['ROLL_PPCM'];?></td>
								<td class="td9"> </td>
                </tr>
                <tr>
					<td colspan="9" style="margin:0px; padding:0px">&nbsp; &nbsp;</td>
				</tr>
				<tr>
				<td class="td1"> </td>
				<td class="td2 bold">Warp Lot No</td>
				<td class="td3"> </td>
				<td class="td4 bold">Weft Lot No</td>
				<td class="td5"> </td>
				<td class="bold" colspan="3">Date/ Time</td>
				<td class="td9"> </td>
				</tr>
				<tr>
                 <td class="td1"> </td>
				 <td class="td2"><?php echo $mrow['ROLL_WARPLOT'];?></td>
								<td class="td3"> </td>
								<td class="td4"><?php echo $mrow['ROLL_WEFTLOT'];?></td>
								<td class="td5"> </td>
								<td colspan="3"><?php echo date("d-M-Y", strtotime($mrow['ROLL_INSP_DATE'])) . ' ' . $mrow['ROLL_ENDTIME'];?></td>
					</tr>			<td class="td9"> </td>
                
                 <tr class="bdr_btm">
                 <td colspan="9" class="bold center">&nbsp; &nbsp;</td>
                </tr>
                </tbody>
                </table>
                 
                
							</div>
						</div>
					</div>
                 
                 
                 
               
                  </div>
                </div>
        </div>
      </div>

    </div>
  </div>
   
			
 <?php include '../includes/scripts.php'; ?>
<!-- include the jquery ui -->
	<script src="../barcode/jquery-ui.js"></script>
	<!-- this script helps us to capture any div -->
	<script src="../barcode/html2canvas.js"></script>

	<script type="text/javascript">
		function printdiv(divname) {
			var printcontents = document.getElementById(divname).innerHTML;
			var originalcontents = document.body.innerHTML;
			document.body.innerHTML = printcontents;
			window.print();
			document.body.innerHTML = originalcontents;
		}

		$(function() {
			//to make a div draggable
			$('.movable_div').draggable({
				containment: "#canvas",
				scroll: false
			});

			//to capture the entered text in the textbox 
			$('#textbox').keyup(function() {
				var text = $(this).val();
				$('.movable_div').text(text);
			});

			//to change the background once the user select
			$('#background').change(function() {
				var background = $(this).val();
				//$('#canvas').css('background', 'url(bg_img/'+background+')');
			});

			//font size handler here. 
			$('#slider').change(function() {
				fontSize = $(this).val();
				$('.movable_div').css('font-size', fontSize + 'px');
			});

			//here is the hero, after the capture button is clicked
			//he will take the screen shot of the div and save it as image.
			$('#capture').click(function() {
				//get the div content
				div_content = document.querySelector("#canvas")
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/png');
					//then call a super hero php to save the image
					save_img(data);
				});
			});
			$('#capture').trigger('click');
		});


		//to save the canvas image
		function save_img(data) {
			//ajax method.
			$.ajax({
				type: 'POST',
				url: '../barcode/save_jpg.php',
				data: {
					data: data
				},
				success: function(res) {
					$('#capture').html(res);
				}
			});
		}

		function getUrlParameter(sParam) {
			var sPageURL = window.location.search.substring(1),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
				}
			}
		};

		window.onload = setTimeout(function() {
			var print1 = getUrlParameter('print');
			if (print1 == 'Auto') {
				window.close();
			}
		}, 10000)
	</script>
</body>

</html>


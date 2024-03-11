<?php
require_once 'session.php';
$screen_title = "ROLL START";
$page_title = "ROLL START";
$mc_name = strtoupper(GFV("STD_MACHINES", "MC_NAME", "MC_ID='$glob_mcid'"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'styles.php'; ?>
    <title>DATALOG - FABRIC INSPECTION SYSTEM</title>
    <style>
        #anboard-container {
            margin: 10px auto;
            width: 450px;
        }

        #anboard {
            margin: 0;
            padding: 0;
            list-style: none;
            font-size: 24px;
        }

        #anboard li {
            float: left;
            margin: 0 6px 6px 0;
            width: 70px;
            height: 70px;
            line-height: 70px;
            text-align: center;
            background: #000;
            color: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            -webkit-border-radius: 5px;
        }

        #anboard .delete {
            width: 300px;
        }

        .lastitem {
            margin-right: 0;
        }


        #anboard li:hover {
            position: relative;
            top: 1px;
            left: 1px;
            border-color: #e5e5e5;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="full_container">
        <?php include 'fixedblock.php';  ?>
        <div class="ui_container">
            <div class="vertical_center">
                <?php
                $roll_id =  GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
                if (!empty($roll_id)) {
                    if (!empty($roll_id)) {
                        $roll_error_head = 'ACTIVE ROLL EXISTS.';
                        $roll_error_msg = 'PLEASE END THE ROLL BEFORE STARTING THE NEW EXISTING ROLL.';
                    } else {
                        $roll_error_head = 'WRONG INPUT';
                        $roll_error_msg = 'PLEASE GO TO DASHBOARD';
                    }
                ?>
                    <div class="apparent-message warning-message" style="width:915px; margin:0 auto;">
                        <div class="message-container">
                            <div class="apparent-message-icon fa fa-fw fa-2x fa-exclamation-triangle">
                            </div>
                            <div class="content-container">
                                <div class="message-header">
                                    <span><?php echo $roll_error_head; ?></span>
                                </div>
                                <div class="message-body"><?php echo $roll_error_msg; ?></div>
                            </div>
                        </div>
                    </div>
                    
                <?php
                } else {
                ?>

                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="card" style="margin:30px 10px 30px 30px;">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <span class="screen_title">
                                            <?php echo $dlog_logoblock; ?>
                                        </span>
                                        <span class="screen_title"><?php echo $page_title; ?></span>
                                        <span>
                                            <?php echo $mill_logoblock; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php include_once 'alert.php'; ?>
									<form class="form-horizontal" method="post" action="rollstart_act.php" autocomplete="off">
                                    <div class="form-cotainer">
                                        <div class="row">
                                           
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">ROLL NUMBER</label>
                                                    
													<input type="text" class="form-control focus" name="roll_number" id="roll_number" placeholder="Roll Number" style="width: 210px;"  required>
                                                       
                                                </div>
												 <div class="form-group">
                                                    
                                                    
													<span onclick="getstydetail()" style="font-size:30px;color:green;border:1px solid;">&nbsp;&nbsp; Get &nbsp;&nbsp;</span>
                                                       
                                                </div>
                                            </div>
											
											 <div class="col-md-3 col-sm-3">
                                                
                                                    <input type="hidden" name="mc_id" value="<?php echo $glob_mcid; ?>">
                                                    <div class="form-group">
                                                        <label class="control-label">SORT NUMBER</label>
                                                        <input type="text" class="form-control" name="style_name" id="style_name" placeholder="Style Name" style="width: 125px;" required>
                                                    </div>
                                            </div>
											<div class="col-md-3 col-sm-6">
                                                
                                                    <input type="hidden" name="mc_id" value="<?php echo $glob_mcid; ?>">
                                                    <div class="form-group">
                                                        <label class="control-label">SORT DECSR</label>
                                                        <input type="text" class="form-control focus" name="style_descr" id="style_descr" placeholder="DECSR" style="width: 210px;" required>
                                                    </div>
                                            </div>
											<div class="col-md-3 col-sm-3">
                                              
                                                    <input type="hidden" name="mc_id" value="<?php echo $glob_mcid; ?>">
                                                    <div class="form-group">
                                                        <label class="control-label">LOOM NO</label>
                                                        <input type="text" class="form-control focus" name="loom" id="loom" placeholder="Loom" style="width: 85px;" required>
                                                    </div>
                                            </div>
											<!--<div class="col-md-4 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">EPI : <span id="aepi" style="color:red"></span></label>
                                                     <input type="text" class="form-control focus" name="epi" id="epi" placeholder="EPI" required>
                                                </div>
                                            </div>
											<div class="col-md-4 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">PPI : <span id="appcm" style="color:red"></span></label>
                                                     <input type="text" class="form-control focus" name="ppcm" id="ppcm" placeholder="PPCM" required>
                                                </div>
                                            </div>
                                           <div class="col-md-4 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">Width : <span id="awidth" style="color:red"></span></label>
                                                     <input type="text" class="form-control focus" name="width" id="width" placeholder="PPCM" required>
                                                </div>
                                            </div>-->
                                            <div class="col-md-4 col-sm-12">
                                                <div class="text-center">
                                                    <div class="form-actions">
                                                        <input type="submit" name="save_btn" value="START" id="start" class="defect_key">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="col-md-8 col-sm-12">
                            <div id="anboard-container">
                                <ul id="anboard">
                                    <li class="symbol">1</li>
                                    <li class="symbol">2</li>
                                    <li class="symbol">3</li>
                                    <li class="symbol">4</li>
                                    <li class="symbol lastitem">5</li>
                                    <li class="symbol">6</li>
                                    <li class="symbol">7</li>
                                    <li class="symbol">8</li>
                                    <li class="symbol">9</li>
                                    <li class="symbol lastitem">0</li>

                                    <li class="letter">A</li>
                                    <li class="letter">B</li>
                                    <li class="letter">C</li>
                                    <li class="letter">D</li>
                                    <li class="letter lastitem">E</li>
                                    <li class="letter">F</li>
                                    <li class="letter">G</li>
                                    <li class="letter">H</li>
                                    <li class="letter">I</li>
                                    <li class="letter lastitem">J</li>
                                    <li class="letter">K</li>
                                    <li class="letter">L</li>
                                    <li class="letter">M</li>
                                    <li class="letter">N</li>
                                    <li class="letter lastitem">O</li>
                                    <li class="letter">P</li>
                                    <li class="letter">Q</li>
                                    <li class="letter">R</li>
                                    <li class="letter">S</li>
                                    <li class="letter lastitem">T</li>
                                    <li class="letter">U</li>
                                    <li class="letter">V</li>
                                    <li class="letter">W</li>
                                    <li class="letter">X</li>
                                    <li class="letter lastitem">Y</li>
                                    <li class="letter">Z</li>
                                    <li class="delete ">DELETE</li>
                                </ul>
                            </div>
                        </div>

                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'scripts.php'; ?>

    <script>
        function get_style_for_start() {
            var style_names1 = null;
            $.ajax({
                'async': false,
                type: 'POST',
                url: 'get_extra_data.php',
                data: {
                    'get_style_for_start': '1',
                },
                success: function(result) {
                    style_names1 = JSON.parse(result);
                }
            });
            return style_names1;
        };

        function get_rolls_for_start() {
            var style_name = $('#style_name').val();
            //if (style_name != '') {
                $.ajax({
                    type: 'POST',
                    url: 'get_extra_data.php',
                    data: {
                        'get_rolls_for_start': '1',
                        //'style_name': style_name,
                    },
                    success: function(html) {
                        $('#roll_number').html(html);
                    }
                });
            //}
        }

      function getstydetail(v){
		  var roll = $('#roll_number').val();
		//alert(roll);
		if (roll != '') {
			
                $.ajax({
                    type: 'POST',
                    url: 'get_extra_data.php',
                    data: {
                        'get_rolldetails': '1',
                        'rollno': roll,
                    },
                    success: function(result) {
                    	 res = JSON.parse(result)
                        $('#loom').val(res['roll_loom_no']);
                        $('#style_descr').val(res['descr']);
                        $('#style_name').val(res['style']);
						//alert(res['roll_loom_no']);
						
                    }
                });
            }

	  }		  
        
		function getrolldetails() {
            var rollno = $('#roll_number').val();
            if (rollno != '') {
                $.ajax({
                    type: 'POST',
                    url: 'get_extra_data.php',
                    data: {
                        'get_rolldetails': '1',
                        'rollno': rollno,
                    },
                    success: function(result) {
                    	 res = JSON.parse(result)
                        $('#aepi').html(res['EPI']);
                        $('#appcm').html(res['PPCM']);
                        $('#awidth').html(res['WIDTH']);
                    }
                });
            }
        }
		//get_rolls_for_start();
        $(document).on('change', '#roll_number', function() {
            get_rolls_for_start();
        });



        var style_names = get_style_for_start();
        $(function() {
            $("#roll_number").autocomplete({
                source: style_names,
                minLength: 1,
                select: function(event, ui) {
                    $('#roll_number').val(ui.item.value);
                    getrolldetails();
                }
            });

            var $write = $(':focus');
            $(".focus").focus(function() {
                $write = $(this);
            });

            $('#anboard li').click(function() {
                var $this = $(this);
                character = $this.html();
                // Delete
                if ($this.hasClass('delete')) {
                    var html = $write.val();
                    $write.val(html.substr(0, html.length - 1));
                    if ($write.attr("id") == 'roll_number') {
                        var html = $write.html(),
                            txt = html.substr(0, html.length - 1);
                        $write.html(txt);
                        $write.autocomplete("search", txt);
                    }
                    return false;
                }
                // Add the character
                $write.val($write.val() + character);
                if ($write.attr("id") == 'roll_number') {
                    var txt = $write.html() + character;
                    $write.html(txt);
                    $write.autocomplete("search", txt);
                    getrolldetails();
                }
            });
        });
    </script>

</body>

</html>
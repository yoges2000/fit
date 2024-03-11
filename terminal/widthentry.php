<?php
require_once 'session.php';

if (isset($_GET['length'])) {
    $length = $_GET['length'];
} else {
    $length = round(GFV("STD_MACHINES", 'MC_LENGTH', "MC_ID='$glob_mcid'"), 2);
}
$roll_id =  GFV("STD_MACHINES", "MC_ROLL_ID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");
$parentid = GFV("STD_MACHINES", "MC_PARENTID", "MC_ID='$glob_mcid' AND MC_ROLLACTIVE='1'");

$screen_title = 'WIDTH ENTRY';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'styles.php';
    header("Content-type: text/html; charset=utf-8");
    ?>
    <title>DATALOG FABRIC INSPECTION SYSTEM</title>

    <style>
        .ui_container {
            font-size: 22px;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="full_container">
        <?php include 'fixedblock.php';  ?>
        <div class="ui_container">
            <div class="vertical_center">
                <div class="card" style="width:70vw; margin:0 auto;">
                    <div class="card-body">
                        <?php
                        if (!empty($length) && !empty($roll_id)) {
                        ?>
                            <form class="form-horizontal" method="POST" action="widthentry_act.php">
                                <input type="hidden" name="length" value="<?php echo $length; ?>" />
                                <input type="hidden" name="widthentry_act" value="widthentry" />
                                <input type="hidden" name="roll_id" value="<?php echo $roll_id; ?>" />

                                <div class="row">
                                    <div class="col-8">
                                        <div style="padding:0px 25px;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="screen_title"><?php echo $screen_title; ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">TYPE</label>
                                                        <select class="form-control" name="cw_type" id="cw_type" style="border-color: #007BFF; font-size: 22px; margin:15px;padding:15px" required>
                                                            <option value="1">Width</option>
                                                            <!--<option value="2">FULL WIDTH</option>-->
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="width" class="control-label"><b>WIDTH</b></label>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="text" class="form-control number-input" id="cw_width1" name="cw_width1" style="border-color: #007BFF; font-size: 22px; margin:15px;padding:15px" placeholder="pin to pin" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="text" class="form-control number-input" id="cw_width2" name="cw_width2" placeholder="Full width"  style="border-color: #007BFF; font-size: 22px; margin:15px;padding:15px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <a href="home.php" style="text-align:center;">
                                                        <div class="option_key" style="background-color:red; border-color:red">
                                                            <i class="fa fa-close" style="font-size:40px; padding:10px 30px;"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <button class="option_key" type="submit" style="background-color:green; border-color:green">
                                                        <i class="fa fa-check" style="font-size:40px; padding:10px 30px;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="right-panel" id="righe-panel">
                                            <ul id="keypad">
                                                <li class="letter" data-number="1"><i>1</i></li>
                                                <li class="letter" data-number="2"><i>2</i></li>
                                                <li class="letter" data-number="3"><i>3</i></li>

                                                <li class="letter clearl" data-number="4"><i>4</i></li>
                                                <li class="letter" data-number="5"><i>5</i></li>
                                                <li class="letter" data-number="6"><i>6</i></li>

                                                <li class="letter clearl" data-number="7"><i>7</i></li>
                                                <li class="letter" data-number="8"><i>8</i></li>
                                                <li class="letter" data-number="9"><i>9</i></li>


                                                <li class="letter clearl" data-number="."><i>.</i></li>
                                                <li class="letter" data-number="0"><i>0</i></li>
                                                <li class="letter delete"><i class="fa fa-arrow-left"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <?php
                            $qry2 = "SELECT * FROM CURWIDTH WHERE CW_ROLLID='$roll_id' ORDER BY CW_ID DESC";
                            $res2 = mysqli_query($fit, $qry2);
                            if ($res2 && mysqli_num_rows($res2) > 0) {
                                $i = 0;
                            ?>
                                <div class="defect_key_container" style="font-size:16px;">
                                    <table class="table table-primary table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>LENGTH</th>
                                               <!-- <th colspan="2">PIN TO PIN</th>-->
                                                <th>PIN TO PIN WIDTH</th>
                                                <th>FULL WIDTH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row2 = mysqli_fetch_assoc($res2)) {
                                                $i++;
                                                $cw_length = $row2['CW_LENGTH'];
                                                $start_length = round($row2['CW_LENGTH']);
                                                if ($row2['CW_TYPE'] == 1) {
                                                    $pw1 = round($row2['CW_WIDTH1'], 2);
                                                    $pw2 = round($row2['CW_WIDTH2'], 2);
                                                    $fw = '-';
                                                } else {
                                                    $pw1 = '-';
                                                    $pw2 = '-';
                                                    $fw = round($row2['CW_WIDTH1'], 2);
                                                }
                                                echo '<tr>';
                                                echo '<td style="padding:4px 10px;">' . $i . '</td>';
                                                echo '<td style="padding:4px 10px;">' . $cw_length . '</td>';
                                                echo '<td style="padding:4px 10px;">' . $pw1 . '</td>';
                                               // echo '<td style="padding:4px 10px;">' . $pw2 . '</td>';
                                                echo '<td style="padding:4px 10px;">' . $pw2 . '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>
                        <?php
                        } else {
                        ?>
                            <div class="apparent-message warning-message" style="margin:0 auto;">
                                <div class="message-container">
                                    <div class="apparent-message-icon fa fa-fw fa-2x fa-exclamation-triangle">
                                    </div>
                                    <div class="content-container">
                                        <div class="message-header">
                                            <span>WRONG INPUT</span>
                                        </div>
                                        <div class="message-body">PLEASE GO TO DASHBOARD</div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'scripts.php';  ?>
    <script>
        var $write = $(':focus');
        $(".number-input").focus(function() {
            $write = $(this);
        });

        $("[data-number]").on('click', function() {
            var inputNumber = $write.val() + $(this).data("number");
            $write.val(inputNumber);
        });

        $(".delete").on('click', function() {
            var inputNumber = $write.val().slice(0, -1);
            $write.val("");
            $write.val(inputNumber);
        });

        $("#cw_type").change(function() {
            show_width_fields();
        });

        $(document).ready(function() {
            show_width_fields();
        });

        function show_width_fields() {
            if ($("#cw_type").val() == 1) {
                $("#cw_width1").show();
                $("#cw_width2").show();
                $("#cw_width2").prop('required', true);
            } else {
                $("#cw_width1").show();
                $("#cw_width2").hide();
                $("#cw_width2").prop('required', false);
            }
        }
    </script>
</body>

</html>
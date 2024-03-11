<?php
$php_file =  strtolower(basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']));
$php_file = rtrim($php_file, '.php')
?>
<style>
    .logo {
        font-size: 26px;
        text-transform: uppercase;
        font-weight: 700;
    }
</style>
<div class="fixed_container">
    <div class="vertical_center">
        <div class="fixedblock_contents" onclick="openFullscreen()">
            <div class="row">
                <div class="col-3">
                    <div class="fixedblock_column" style="float:left;">
                        <?php
                        if ($php_file == 'home') {
                        ?>
                            <div class="logo">
                                <img src="images/Datalog_Logo_small.png" style="height:30px; width:19px;vertical-align:middle; ">
                                <span style="line-height:50px;">Datalog
                                    <sup>®</sup>
                                </span>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div style=" padding-left:7px; padding-bottom:5px;">
                                <a href=" home.php">
                                    <div class="btn btn-outline-light fixedblock_big_text">
                                        DASHBOARD
                                    </div>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-3">
                    <?php
                    $mc_sec_text = 'Table';
                    $mc_sec_val = GFV("STD_MACHINES", "MC_NAME", "MC_ID='$glob_mcid'");
                    ?>

                    <div class="fixedblock_column">
                        <div class="fixedblock_small_text"><?php echo $mc_sec_text; ?></div>
                        <div class="fixedblock_big_text">
                            <?php echo $mc_sec_val; ?>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="fixedblock_small_text">
                        <?php
                        echo date("l, F d");
                        ?>
                    </div>
                    <div class="fixedblock_big_text">
                        <span class="hms "></span>
                        <span class="ampm"></span>
                    </div>
                </div>
                <div class="col-3">
                    <div class="fixedblock_column" style="float:right">
                        <?php
                        if ($php_file == 'home' || $php_file == 'rollstart') {
                            echo '<img src="images/mill_logo.png" style="height:50px;background: floralwhite; ">';
                        } else {
                        ?>
                            <div class="fixedblock_small_text">Length in Meter</div>
                            <div class="fixedblock_big_text">
                                <?php
                                echo $length;
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
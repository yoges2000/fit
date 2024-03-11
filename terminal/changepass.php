<?php
require_once 'session.php';
$page_title = 'CHANGE PASSWORD';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'styles.php'; ?>
    <title>DATALOG - FABRIC INSPECTION SYSTEM</title>

    <style>
        #keyboard-container {
            margin: 10px auto;
            width: 950px;
            padding-left: 20px;
        }

        #keyboard {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        #keyboard li {
            float: left;
            margin: 0 5px 5px 0;
            width: 60px;
            height: 60px;
            line-height: 60px;
            text-align: center;
            background: #fff;
            border: 1px solid #f9f9f9;
            border-radius: 5px;
            -webkit-border-radius: 5px;
        }

        .capslock,
        .tab,
        .left-shift {
            clear: left;
        }

        #keyboard .tab,
        #keyboard .delete {
            width: 70px;
        }

        #keyboard .capslock {
            width: 100px;
        }

        #keyboard .return {
            width: 95px;
        }

        #keyboard .left-shift {
            width: 130px;
        }

        #keyboard .right-shift {
            width: 130px;
        }

        .lastitem {
            margin-right: 0;
        }

        .uppercase {
            text-transform: uppercase;
        }

        #keyboard .space {
            clear: left;
            width: 915px;
        }

        .on {
            display: none;
        }

        #keyboard li:hover {
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
                <div class="card" style="width:915px; margin:0 auto;">
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
                        <div class="form-cotainer">
                            <form class="form-horizontal" method="post" action="changepass_act.php" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">PREVIOUS PASSWORD</label>
                                            <input type="password" class="form-control focus" name="ppass" style="border-color: #007BFF" autofocus required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">NEW PASSWORD</label>
                                            <input type="password" class="form-control focus" name="npass" style="border-color: #007BFF" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">RE-ENTER PASSWORD</label>
                                            <input type="password" class="form-control focus" name="cpass" style="border-color: #007BFF" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 text-center">
                                        <div class="form-actions">
                                            <input type="submit" name="save_btn" value="SAVE" class="defect_key">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="keyboard-container">
                    <ul id="keyboard">
                        <li class="symbol"><span class="off">`</span><span class="on">~</span></li>
                        <li class="symbol"><span class="off">1</span><span class="on">!</span></li>
                        <li class="symbol"><span class="off">2</span><span class="on">@</span></li>
                        <li class="symbol"><span class="off">3</span><span class="on">#</span></li>
                        <li class="symbol"><span class="off">4</span><span class="on">$</span></li>
                        <li class="symbol"><span class="off">5</span><span class="on">%</span></li>
                        <li class="symbol"><span class="off">6</span><span class="on">^</span></li>
                        <li class="symbol"><span class="off">7</span><span class="on">&amp;</span></li>
                        <li class="symbol"><span class="off">8</span><span class="on">*</span></li>
                        <li class="symbol"><span class="off">9</span><span class="on">(</span></li>
                        <li class="symbol"><span class="off">0</span><span class="on">)</span></li>
                        <li class="symbol"><span class="off">-</span><span class="on">_</span></li>
                        <li class="symbol"><span class="off">=</span><span class="on">+</span></li>
                        <li class="delete lastitem">delete</li>
                        <li class="tab">tab</li>
                        <li class="letter">q</li>
                        <li class="letter">w</li>
                        <li class="letter">e</li>
                        <li class="letter">r</li>
                        <li class="letter">t</li>
                        <li class="letter">y</li>
                        <li class="letter">u</li>
                        <li class="letter">i</li>
                        <li class="letter">o</li>
                        <li class="letter">p</li>
                        <li class="symbol"><span class="off">[</span><span class="on">{</span></li>
                        <li class="symbol"><span class="off">]</span><span class="on">}</span></li>
                        <li class="symbol lastitem"><span class="off">\</span><span class="on">|</span></li>
                        <li class="capslock">caps lock</li>
                        <li class="letter">a</li>
                        <li class="letter">s</li>
                        <li class="letter">d</li>
                        <li class="letter">f</li>
                        <li class="letter">g</li>
                        <li class="letter">h</li>
                        <li class="letter">j</li>
                        <li class="letter">k</li>
                        <li class="letter">l</li>
                        <li class="symbol"><span class="off">;</span><span class="on">:</span></li>
                        <li class="symbol"><span class="off">'</span><span class="on">&quot;</span></li>
                        <li class="return lastitem">return</li>
                        <li class="left-shift">shift</li>
                        <li class="letter">z</li>
                        <li class="letter">x</li>
                        <li class="letter">c</li>
                        <li class="letter">v</li>
                        <li class="letter">b</li>
                        <li class="letter">n</li>
                        <li class="letter">m</li>
                        <li class="symbol"><span class="off">,</span><span class="on">&lt;</span></li>
                        <li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
                        <li class="symbol"><span class="off">/</span><span class="on">?</span></li>
                        <li class="right-shift lastitem">shift</li>
                        <li class="space lastitem" style="color:red; font-weight:bold;">&nbsp;DATALOG&nbsp;</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <?php include 'scripts.php'; ?>
    <script>
        var $write = $(':focus');
        $(".focus").focus(function() {
            $write = $(this);
        });

        $(function() {
            shift = false,
                capslock = false;

            $('#keyboard li').click(function() {
                var $this = $(this),
                    character = $this.html(); // If it's a lowercase letter, nothing happens to this variable

                // Shift keys
                if ($this.hasClass('left-shift') || $this.hasClass('right-shift')) {
                    $('.letter').toggleClass('uppercase');
                    $('.symbol span').toggle();

                    shift = (shift === true) ? false : true;
                    capslock = false;
                    return false;
                }

                // Caps lock
                if ($this.hasClass('capslock')) {
                    $('.letter').toggleClass('uppercase');
                    capslock = true;
                    return false;
                }

                // Delete
                if ($this.hasClass('delete')) {
                    var html = $write.val();
                    $write.val(html.substr(0, html.length - 1));
                    return false;
                }

                // Special characters
                if ($this.hasClass('symbol')) character = $('span:visible', $this).html();
                if ($this.hasClass('space')) character = ' ';
                if ($this.hasClass('tab')) character = "\t";
                if ($this.hasClass('return')) character = "\n";

                // Uppercase letter
                if ($this.hasClass('uppercase')) character = character.toUpperCase();

                // Remove shift once a key is clicked.
                if (shift === true) {
                    $('.symbol span').toggle();
                    if (capslock === false) $('.letter').toggleClass('uppercase');

                    shift = false;
                }
                //console.log("DO IT ", character);
                // Add the character
                $write.val($write.val() + character);
            });
        });
    </script>

</body>

</html>
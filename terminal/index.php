<?php
//session_start();
require_once '../includes/connection.php';
$ismachineid = false;
$isminspectorid = false;
if ((isset($_REQUEST['mc_id']) && !empty($_REQUEST['mc_id'])) || (isset($_SESSION['mc_id']) && !empty($_SESSION['mc_id']))) {
  if (isset($_REQUEST['mc_id']) && !empty($_REQUEST['mc_id'])) {
    $_SESSION['mc_id'] = $_REQUEST['mc_id'];
  }
  if ((isset($_SESSION['mc_id']) && !empty($_SESSION['mc_id']))) {
    $glob_mcid =  $_SESSION['mc_id'];
    $query = "SELECT MC_NAME FROM STD_MACHINES WHERE MC_ID='$glob_mcid'";
    $res = mysqli_query($fit, $query);
    while ($row = mysqli_fetch_assoc($res)) {
      $mc_name =  strtoupper($row['MC_NAME']);
    }
    $ismachineid = true;
  }
}
if ((isset($_SESSION['insp_id']) && !empty($_SESSION['insp_id']))) {
  $isminspectorid = true;
}

if ($ismachineid == true &&  $isminspectorid == true) {
  header("location:home.php");
}

$screen_title = "FABRIC INSPECTION SYSTEM";
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Responsive -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>DATALOG - FABRIC INSPECTION</title>
  <meta name="description" content="DATALOG TECHNOLOGIES- FABRIC INSPECTION SYSTEM">

  <!-- Meta Tags required for Progressive Web App -->
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">
  <link rel="apple-touch-icon" sizes="57x57" href="./images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="./images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="./images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="./images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="./images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="./images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="./images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="./images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="./images/favicon/apple-icon-180x180.png">

  <link rel="icon" type="image/png" sizes="192x192" href="./images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="./images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon/favicon-16x16.png">

  <?php
  if (isset($_REQUEST['mc_id']) && !empty($_REQUEST['mc_id'])) {
  ?>
    <!-- Manifest File link -->
    <link rel="manifest" href="./manifest.php?mc_id=<?php echo $_GET['mc_id']; ?>">
  <?php
  }
  ?>

  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <?php include 'styles.php'; ?>
  <style>
    .index_card_body {
      background: #e3f2fd;
      align-items: center;
      text-align: center;
      color: #138ff2;
      font-family: Roboto;
    }

    .index_card_body h1 {
      font-size: 4em;
      font-weight: 100;
    }

    .index_card_body p {
      font-size: 1.5em;
      line-height: 1.4;
    }

    .success_content {
      color: #138ff2;
    }

    .error_content {
      color: #138ff2;
    }
  </style>

  <style>
    #keyboard-container {
      margin: 10px auto;
      width: 700px;
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
      width: 35px;
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
      width: 656px;
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

    <div class="ui_container">
      <div class="vertical_center">
        <?php
        if ($ismachineid == true) {
        ?>
          <div class="card" style="width:685px; margin:0 auto;">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <span class="screen_title"><?php echo $screen_title; ?></span>
                <span>
                  <img src="images/Datalog_Logo.png" style="padding-top:2px; float:right">
                </span>
              </div>
            </div>
            <div class="card-body">
              <?php include_once 'alert.php'; ?>
              <div class="form-cotainer">
                <form class="form-horizontal" method="post" action="login_act.php" autocomplete="off">
                  <input type="hidden" name="mc_id" value="<?php echo $glob_mcid; ?>">
                  <div class="row">
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label class="control-label">EMPLOYEE ID</label>
                        <input type="text" class="form-control focus" name="insp_empid" style="border-color: #007BFF" autofocus required>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="form-group">
                        <label class="control-label">PASSWORD</label>
                        <input type="password" class="form-control focus" name="insp_password" style="border-color: #007BFF" required>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12 text-center">
                      <div class="form-actions">
                        <input type="submit" name="save_btn" value="LOGIN" id="start" class="defect_key">
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
        <?php
        } else {
        ?>
          <div class="card" style="width:915px; margin:0 auto;">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <span class="screen_title"><?php echo $screen_title; ?></span>
                <span>
                  <img src="images/Datalog_Logo.png" style="padding-top:2px; float:right">
                </span>
              </div>
            </div>
            <div class="card-body index_card_body">
              <h1>ERROR!</h1>
              <p>
                It looks like you've opened an incorrect application. Please close this application and open the correct one.
              </p>
              <hr />
              <div class="d-flex justify-content-between">
                <span>Error: mc_id not set.</span>
                <span>Example:index.php?mc_id=1</span>
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


    window.addEventListener('load', () => {
      registerSW();
    });

    // Register the Service Worker
    async function registerSW() {
      if ('serviceWorker' in navigator) {
        try {
          await navigator
            .serviceWorker
            .register('serviceworker.js');
        } catch (e) {
          console.log('SW registration failed');
        }
      }
    }
  </script>

</body>

</html>
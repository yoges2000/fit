<?php
session_start();
if(isset($_SESSION['dlog_userid'])){
    header("location:dashboard.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
   <?php include '../includes/styles.php'; ?>
    <title>Datalog</title>
 
   
  </head>
  <body  class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark"><img src="../assets/images/logo.png" height="36" alt=""></a>
        </div>
        <form class="card card-md" method="POST" action="../actions/user_login.php" autocomplete="off">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Login to your account</h2>
            <div class="mb-3">
              <label class="form-label">User Name</label>
              <input type="text" class="form-control" name="username" placeholder="Enter Username">
            </div>
            <div class="mb-2">
              <label class="form-label">
                Password
                
              </label>
              <div class="input-group input-group-flat">
                <input type="password" class="form-control" name="password" placeholder="Password"  autocomplete="off">
                
              </div>
            </div>
            
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </div>
          </div>
 
        </form>
        
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <?php include '../includes/scripts.php'; ?>
  </body>
</html>
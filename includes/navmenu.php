<header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
      <a href=".">
        <img src="../assets/images/logo.png" width="110" height="32" alt="" class="navbar-brand-image">
      </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
      <div class="d-none d-md-flex">

        <div class="nav-item dropdown d-none d-md-flex me-3">


        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm" style="background-image: url(../assets/images/avatar.jpg)"></span>

        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="changepass.php" class="dropdown-item">Change Password</a>
          <div class="dropdown-divider"></div>
          <a href="../actions/user_logout.php" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="navbar-menu">
      <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../user/dashboard.php">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-device-desktop-analytics" width="24" height="24"></i>
              </span>
              <span class=" nav-link-title">
                Online Screen
              </span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-adjustments" width="24" height="24"></i>
              </span>
              <span class="nav-link-title">
                Standards
              </span>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="std_mill.php">Mill Standards</a>
              <a class="dropdown-item" href="std_machines.php">Inspection Table Standards</a>
              <a class="dropdown-item" href="std_defects.php">Defect Standards</a>
              <a class="dropdown-item" href="std_style.php">Sort Standards</a>
              <a class="dropdown-item" href="std_roll.php">Piece/Roll Standards</a>
              <a class="dropdown-item" href="std_inspectors.php">Inspector Standards</a>
              <!--  <a class="dropdown-item" href="std_reasons.php">Reasons Standards</a>-->
              <a class="dropdown-item" href="std_users.php">Login User Standards</a>
            </div>
          </li>

          <li class="nav-item <?php if ($page_group == 'Assignments') {
															echo 'active';
														} ?> dropdown">
            <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-package" width="24" height="24"></i>
              </span>
              <span class="nav-link-title">
                Assignments
              </span>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="keymap.php">Key Assignment</a>
			   <a class="dropdown-item" href="approval.php">Roll Approval</a>
			   <a class="dropdown-item" href="approved.php">Roll Approved</a>
			   <a class="dropdown-item" href="weight.php">Roll Weight</a>
			     <a class="dropdown-item" href="rollmanage.php">Roll Management</a>
              <a class="dropdown-item" href="reinspectroll.php">Reinspection Roll</a>
             
            

            </div>
          </li>
          <li class="nav-item <?php if ($page_group == 'reports') {
															echo 'active';
														} ?> dropdown">
            <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="icon ti ti-report-analytics" width="24" height="24"></i>
              </span>
              <span class="nav-link-title">
                Reports
              </span>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="inspection_report.php">Inspection Report</a>
              <a class="dropdown-item" href="inspection_detail.php?type=sheet">Inspection Sheet</a>
              <a class="dropdown-item" href="inspection_detail.php?type=chart">Inspection Chart</a>
              <a class="dropdown-item" href="inspection_detail.php?type=label">Inspection Label</a>
            </div>
          </li>


        </ul>
      </div>
    </div>
  </div>
</header>

<a id="dlink" style="display: none;"></a>
	<!-- Alert and Messages Starts -->
	<div class="alert-msg-container">
	    <?php
        if (isset($_SESSION['error']) || isset($_SESSION['success'])) {
            if (isset($_SESSION['error'])) {
                $alert_icon = 'warning';
                $alert_title = 'ERROR';
                $alert_content = $_SESSION['error'];
                $alert_type = 'danger';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                $alert_icon = 'check';
                $alert_title = 'SUCCESS';
                $alert_content = $_SESSION['success'];
                $alert_type = 'success';
                unset($_SESSION['success']);
            }
        ?>

	        <div class='alert alert-<?php echo $alert_type; ?> alert-dismissible ' style='margin:5px 10px 0px 10px; border-radius:1rem'>
	            <h5><i class='icon fa fa-<?php echo $alert_icon; ?>'></i> <?php echo $alert_title; ?>! &nbsp;<?php echo $alert_content; ?></h5>
	            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	        </div>
	    <?php
        }
        ?>
	</div>
	<!-- Alert and Messages Ends -->
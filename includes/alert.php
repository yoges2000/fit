
<!-- Alert and Messages Starts -->
<style>
.dlalerterror {
  padding: 10px;
  background-color: #f44336;
  color: white;
  margin-top:10px;
  margin-bottom:10px;
}
.dlalertsuccess {
  padding: 10px;
  background-color: #04AA6D;
  color: white;
  margin-top:10px;
  margin-bottom:10px;
}

.dlclosebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.dlclosebtn:hover {
  color: black;
}

</style>


<?php

if (isset($_SESSION['ERROR'])) {
    ?>
	<div class="dlalerterror">
  	<span class="dlclosebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  		<strong>Error!</strong> <?php echo $_SESSION['ERROR'];?>
	</div>
	<?php 
	unset($_SESSION['ERROR']);
}
if (isset($_SESSION['SUCCESS'])) {
	?>
    <div class="dlalertsuccess">
      <span class="dlclosebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <strong>Success!</strong> <?php echo $_SESSION['SUCCESS'];?>
    </div>
	<?php 
		
	unset($_SESSION['SUCCESS']);
}
?>
<!-- Alert and Messages Ends -->
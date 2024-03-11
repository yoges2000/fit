
<!DOCTYPE html>
<html lang="en">

</head>
<?php
	include 'styles.php';
	?>
<style>
	
	</style>
<body><div class="full_container">
        <style>
		.ui_container {
			font-size: 22px;
			font-weight: bold;
		}
	</style>
    <script>
    function validateForm() {
        var epi = document.getElementById("epi").value.trim();
        var ppcm = document.getElementById("ppcm").value.trim();
        var width = document.getElementById("width").value.trim();

        var isValid = true;

        if (epi === "") {
            document.getElementById("aepi").innerText = "This field is required";
            isValid = false;
        } else {
            document.getElementById("aepi").innerText = "";
        }

        if (ppcm === "") {
            document.getElementById("appcm").innerText = "This field is required";
            isValid = false;
        } else {
            document.getElementById("appcm").innerText = "";
        }

        if (width === "") {
            document.getElementById("awidth").innerText = "This field is required";
            isValid = false;
        } else {
            document.getElementById("awidth").innerText = "";
        }

        return isValid;
    }
</script>

<form onsubmit="return validateForm()" method="post" action="home.php">
    <div class="col-md-2 col-sm-6">
        <div class="form-group">
            <label class="control-label">EPI : <span id="aepi" style="color:red ; padding-right: 40px;"></span></label>
            <input type="text" class="form-control focus" name="epi" id="epi" placeholder="EPI" required>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="form-group">
            <label class="control-label">PPI : <span id="appcm" style="color:red"></span></label>
            <input type="text" class="form-control focus" name="ppcm" id="ppcm" placeholder="PPCM" required>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="form-group">
            <label class="control-label">Width : <span id="awidth" style="color:red"></span></label>
            <input type="text" class="form-control focus" name="width" id="width" placeholder="PPCM" required>
        </div>
    </div>
    <div class="col-6" style="margin-top: 10px;">
        <h6 style="color:#FFFFFF">
            <button type="submit" class="btn btn-primary">Submit</button>
        </h6>
    </div>
</form>

    </body>
</html>
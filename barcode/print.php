
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui.js"></script>
<?php 
						$output = shell_exec('start /min mspaint /p D:\xampp\htdocs\fit\cdl\barcode\output\barcode.jpg');
						//echo "<pre>$output</pre>";
?>



<script>
window.onload = setTimeout(function(){
			//alert('hi');
		   window.close();
		}, 10000)
</script>
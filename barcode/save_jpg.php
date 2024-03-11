<?php 	
	$output_file = 'output/barcode.jpg';
	$base64_string = $_POST['data'];
    $file = fopen($output_file, "wb");
    $data = explode(',', $base64_string);
    fwrite($file, base64_decode($data[1]));
    fclose($file);
?>
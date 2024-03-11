<?php
$mc_id = $_GET['mc_id'];

$manifest = [
	"name"  => "DATALOG FABRIC INSPECTION",
	"short_name"  => "DL-FIS",
	"display"  => "standalone",
	"start_url"  => "./index.php?mc_id=$mc_id",
	"scope"  => ".",
	"description"  => "DATALOG TECHNOLOGIES - FABRIC INSPECTION SYSTEM",
	"theme_color"  => "#000",
	"background_color"  => "#000",
	"icons"  => [
		[
			"src"  => "./images/favicon/android-icon-36x36.png",
			"sizes"  => "36x36",
			"type"  => "image/png",
			"density"  => "0.75"
		],
		[
			"src"  => "./images/favicon/android-icon-48x48.png",
			"sizes"  => "48x48",
			"type"  => "image/png",
			"density"  => "1"
		],
		[
			"src"  => "./images/favicon/android-icon-72x72.png",
			"sizes"  => "72x72",
			"type"  => "image/png",
			"density"  => "1.5"
		],
		[
			"src"  => "./images/favicon/android-icon-96x96.png",
			"sizes"  => "96x96",
			"type"  => "image/png",
			"density"  => "2"
		],
		[
			"src"  => "./images/favicon/android-icon-144x144.png",
			"sizes"  => "144x144",
			"type"  => "image/png",
			"density"  => "3"
		],
		[
			"src"  => "./images/favicon/android-icon-192x192.png",
			"sizes"  => "192x192",
			"type"  => "image/png",
			"density"  => "4",
			"purpose"  => "any maskable"
		],
		[
			"src"  => "./images/favicon/android-icon-512x512.png",
			"sizes"  => "512x512",
			"type"  => "image/png",
		]
	]
];

echo json_encode($manifest);

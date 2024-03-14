<?php
require_once 'session.php';

$length = round(GFV("STD_MACHINES", "MC_LENGTH", "MC_ID='$glob_mcid'"), 2)

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	include 'styles.php';
	header("Content-type: text/html; charset=utf-8");
	?>
	<title>DATALOG FABRIC INSPECTION SYSTEM</title>


	<style>
		.field {
			height: 60px;
			width: 85%;
			display: flex;
			position: relative;
		}

		.field input {
			height: 100%;
			width: 100%;
			padding-left: 45px;
			line-height: 2;
			padding: 0.375rem 2rem;
			font-size: 24px;
			outline: none;
			border: none;
			color: #e0d2d2;
			border: 1px solid rgba(255, 255, 255, 0.438);
			border-radius: 8px;
			background: rgba(105, 105, 105, 0);
			text-transform: uppercase;
		}


		.field input::placeholder {
			color: #e0d2d2a6;
		}

		#anboard-container {
			margin: 10px auto;
			width: 100%;
		}

		#anboard {
			margin: 0;
			padding: 0;
			list-style: none;
			font-size: 24px;
		}

		#anboard li {
			float: left;
			margin: 0 6px 6px 0;
			width: 70px;
			height: 70px;
			line-height: 70px;
			text-align: center;
			background: #000;
			color: #fff;
			border: 1px solid #e5e5e5;
			border-radius: 5px;
			-webkit-border-radius: 5px;
		}

		#anboard .delete {
			width: 300px;
		}

		.lastitem {
			margin-right: 0;
		}


		#anboard li:hover {
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
			<div class="row">
			  <div class="col-12 text-center" >

					<div class="defect_key_container" style="height: 500px;">
						<div id="defect_key_contents">
						</div>
					</div>

				</div>
				<div class="col-12 text-center" style="border-right:1px solid #FFFFFF;">
					<div class="vertical_center">
						<div class="defect_key_container">
							<form method="post" autocomplete="off">
								<div class="field">
									<input type="text" class="focus" name="input_text" id="input_text" placeholder="DEFECT" style="width: 90%;" autofocus>
								</div>
							</form>
						</div>
						<div class="defect_key_container">
							<div id="anboard-container">
								<ul id="anboard">
									<li class="symbol">1</li>
									<li class="symbol">2</li>
									<li class="symbol">3</li>
									<li class="symbol">4</li>
									<li class="symbol lastitem">5</li>
									<li class="symbol">6</li>
									<li class="symbol">7</li>
									<li class="symbol">8</li>
									<li class="symbol">9</li>
									<li class="symbol lastitem">0</li>

									<li class="letter">A</li>
									<li class="letter">B</li>
									<li class="letter">C</li>
									<li class="letter">D</li>
									<li class="letter lastitem">E</li>
									<li class="letter">F</li>
									<li class="letter">G</li>
									<li class="letter">H</li>
									<li class="letter">I</li>
									<li class="letter lastitem">J</li>
									<li class="letter">K</li>
									<li class="letter">L</li>
									<li class="letter">M</li>
									<li class="letter">N</li>
									<li class="letter lastitem">O</li>
									<li class="letter">P</li>
									<li class="letter">Q</li>
									<li class="letter">R</li>
									<li class="letter">S</li>
									<li class="letter lastitem">T</li>
									<li class="letter">U</li>
									<li class="letter">V</li>
									<li class="letter">W</li>
									<li class="letter">X</li>
									<li class="letter lastitem">Y</li>
									<li class="letter">Z</li>
									<li class="delete ">DELETE</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				
			</div>
		</div>
	</div>
	</div>

	<?php include 'scripts.php';  ?>

	<script>
		$(document).ready(function() {
			var input_text = $('#input_text').val();
			get_defect_keys(input_text);
		});

		var $write = $(':focus');
		$(".focus").focus(function() {
			$write = $(this);
		});

		$(function() {

			$('#anboard li').click(function() {
				var $this = $(this);
				character = $this.html();
				// Delete
				if ($this.hasClass('delete')) {
					var html = $write.val();
					$write.val(html.substr(0, html.length - 1));
					get_defect_keys($write.val());
					return false;
				}
				// Add the character
				$write.val($write.val() + character);
				get_defect_keys($write.val());
				console.log($write.val());

			});
		});




		function get_defect_keys(input_text) {
			var length = '<?php echo !empty($length) ? $length : 0; ?>';
			$.ajax({
				type: 'POST',
				data: {
					'get_defect_keys': 1,
					'defect_type': 1,
					'input_text': input_text,
					'length': length,
				},
				url: 'get_extra_data.php',
				success: function(result) {
					$('#defect_key_contents').html(result);
				},
				error: function(data) {
					//	location.reload(true);
				}
			});
		}
	</script>


	<script>

	</script>

</body>

</html>
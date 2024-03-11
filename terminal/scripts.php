<!-- JQuery -->
<script src="js/jquery-3.6.0.min.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<!-- sweetalert -->
<script src="js/sweetalert.min.js"></script>
<!-- jquery-ui -->
<script src="js/jquery-ui.js"></script>
<!-- Custom -->
<script src="js/custom.js"></script>

<script>
    window.setInterval(function() {
        get_data();
    }, 200);
    //Get Current Length
    function get_data() {
        $.ajax({
            type: 'POST',
            data: {},
            url: 'get_data.php',
            success: function(result) {
                res = JSON.parse(result)
                if (res['LENGTH'] != undefined) {
                    $('#getlength').html(res['LENGTH']);
                    $('#storelen').val(res['LENGTH']);
                    $('#ballength').html(res['BAL_LENGTH']);
                }

                if (res['TIME'].length > 0) {
                    $('.hms').html(res['TIME'][0]);
                    $('.ampm').html(res['TIME'][1]);
                }
            },
            error: function(data) {
                //	location.reload(true);
            }
        });
    }

    window.setInterval(function() {
        $.ajax({
            type: 'POST',
            data: {},
            url: 'get_prescan.php',
            success: function(result) {
               if(result=='0'){
                //location.reload(true);
               }
            },
            error: function(data) {
                //	location.reload(true);
            }
        });
    }, 200);
   
	function uplen(v){
		 $.ajax({
            type: 'POST',
            data: {},
            url: 'get_data.php?type=uplen&len='+v,
            success: function(result) {
                get_data();
            },
            error: function(data) {
                //	location.reload(true);
            }
        });
	}

	
	var elem = document.documentElement;
	function openFullscreen() {
	  if (elem.requestFullscreen) {
	    elem.requestFullscreen();
	  } else if (elem.webkitRequestFullscreen) { /* Safari */
	    elem.webkitRequestFullscreen();
	  } else if (elem.msRequestFullscreen) { /* IE11 */
	    elem.msRequestFullscreen();
	  }
	}

	function closeFullscreen() {
	  if (document.exitFullscreen) {
	    document.exitFullscreen();
	  } else if (document.webkitExitFullscreen) { /* Safari */
	    document.webkitExitFullscreen();
	  } else if (document.msExitFullscreen) { /* IE11 */
	    document.msExitFullscreen();
	  }
	}
	
</script>
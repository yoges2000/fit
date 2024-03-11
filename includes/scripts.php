<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../assets/datatables/js/datatables.min.js"></script>
<script src="../assets/js/dl.js"></script>
 <script src="../assets/js/select2.full.min.js"></script> 
 <script src="../assets/js/datepicker.js"></script> 
<script>
    

    function toggle_slow(hide_id, show_id) {
        $("#" + hide_id).fadeOut(500)
        $("#" + hide_id).hide(500);
        setTimeout(() => {
            $("#" + show_id).fadeIn(500)
            $("#" + show_id).show(500)
        }, 500)
    }

    function filter_toggle() {
        var display = $('#reportfilter').css("display");
        if (display == 'block') {
            toggle_slow('reportfilter', 'reportpage')
            $("#pdf_btn").show()
            $("#excel_btn").show()
        } else {
            toggle_slow('reportpage', 'reportfilter')
            $("#pdf_btn").hide()
            $("#excel_btn").hide()
        }
    }

    function showme(id) {
        var divid = document.getElementById(id);
        //alert(divid.style.display)
        if (divid.style.display == 'block') divid.style.display = 'none';
        else divid.style.display = 'block';
    }

    //Pdf 
    function pdfData(maindivId) {
        var filename = maindivId.replace("_div", "");
        var temphdtd = $("#hd" + filename).html();
        $("#hd" + filename).html('');
        $('#pdfdata').remove();

        var divToPrint = document.getElementById(maindivId).innerHTML;
        // alert(divToPrint)
        var mapForm = document.createElement("form");
        mapForm.target = "_blank";
        mapForm.method = "POST";
        mapForm.id = "pdfdata";
        mapForm.action = "../tcpdf/examples/createpdf.php";
        var mapInput = document.createElement("textarea");
        mapInput.name = "data";
        mapInput.id = "data";
        mapInput.value = divToPrint;

        var filenameInput = document.createElement("input");
        filenameInput.name = "filename";
        filenameInput.id = "filename";
        filenameInput.value = filename;
        filenameInput.type = "hidden";

        mapForm.appendChild(mapInput);
        mapForm.appendChild(filenameInput);
        document.body.appendChild(mapForm);
        mapForm.submit();
        $("#hd" + filename).html(temphdtd);
        $('#pdfdata').remove();
    }
    function printData(maindivId) {

    	//$("div").removeAttr("style");

    	var cdata ="<div style = 'text-align:center'> VSM Weaves India P.Ltd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Datalog &nbsp;</div><br />";

    	var divId = maindivId;

    	var temphdtd = $("#hd" + divId).html();

    	$("#hd" + divId).html('');



    	var divToPrint = "<div style='font-size:12px'>"

    			+ document.getElementById(maindivId).outerHTML + "</div>";

    	var cleandivToPrint = divToPrint.replace("overflow-y: scroll", "");



    	newWin = window.open("");

    	

    	newWin.document

    			.write("<head><style type='text/css'>table{ font-size:12px; }td,th {padding:0 0 0 10px;text-align:right; }</style></head>")

    	newWin.document.write(cdata + cleandivToPrint);

    	//alert(cleandivToPrint);

    	newWin.print();

    	newWin.close();



    	$("#hd" + divId).html(temphdtd);

    }


    //Excel
    
function cleanTableExcel(maindivId,filename) {

   $("th").css('background-color', '#fff');
	
	var temphdtd = $("#hd" + filename).html();

	$("#hd" + filename).html('');

	tableToExcel(maindivId, name, filename);

	$("#hd" + filename).html(temphdtd);
//$("td").removeAttr("style");
$("th").removeAttr("style");
$("th").css('background-color', '#015772');
}
var tableToExcel = (function() {
	var topContent="<table style='font-size:22px;font-weight:bold;'><tr><td colspan='5' style='text-align:center;'><?php echo $_SESSION['millname']; ?></td><td colspan='5' style='text-align:right;'>Datalog</td></tr></table>";

	var exportExlContent="<b style='color:red;'>*Report taken through Excel</b>";

	var uri = 'data:application/vnd.ms-excel;base64,', template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><style> table, td {border:thin solid black}table {border-collapse:collapse}</style><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>'

			+ topContent

			+ '<table>{table}</table>'

			+ exportExlContent

			+ '</body></html>', base64 = function(s) {

		return window.btoa(unescape(encodeURIComponent(s)))

	}, format = function(s, c) {

		return s.replace(/{(\w+)}/g, function(m, p) {

			return c[p];

		})

	}

	return function(table, name, filename) {

		if (!table.nodeType)

			table = document.getElementById(table)

		var ctx = {

			worksheet : name || 'Worksheet',

			table : table.innerHTML

		}



		document.getElementById("dlink").href = uri

				+ base64(format(template, ctx));

		document.getElementById("dlink").download = filename+".xls";

		document.getElementById("dlink").click();



	}

})()  
    
</script>
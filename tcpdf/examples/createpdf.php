<?php


require_once 'tcpdf_include.php';



//*** DELETE OLD REPORT FILES (> 3 hrs)** ///
$folderName = __DIR__ . "/outputs";
if (file_exists($folderName)) {
    foreach (new DirectoryIterator($folderName) as $fileInfo) {
        if ($fileInfo->isDot()) {
            continue;
        }
        if ($fileInfo->isFile() && time() - $fileInfo->getCTime() >= 3 * 60 * 60) {
            unlink($fileInfo->getRealPath());
        }
    }
}
///////////////////////////////////////////
date_default_timezone_set('Asia/Kolkata');
$size = "A5";
$ori = "L";
$title = "Title";
$data = '';
$rptname = "None";
$fontsize = 8;
if (isset($_REQUEST['data'])) {
    $data = $_REQUEST['data'];
}

if (isset($_REQUEST['title'])) {
    $title = $_REQUEST['title'];
}
if (isset($_REQUEST['ctitle'])) {
    $ctitle = $_REQUEST['ctitle'];
}
if (isset($_REQUEST['size'])) {
    $size = $_REQUEST['size'];
}
if (isset($_REQUEST['ori'])) {
    $ori = $_REQUEST['ori'];
}
if (isset($_REQUEST['rptname'])) {
    $rptname = $_REQUEST['rptname'];
}
if (isset($_REQUEST['filter'])) {
    $filter = $_REQUEST['filter'];
}
if (isset($filter) && $filter == 'F') {
    $rptname1 = " (F)";
} else {
    $rptname1 = "";
}
if (isset($_REQUEST['fontsize'])) {
    $fontsize = $_REQUEST['fontsize'];
}

class MYPDF extends TCPDF
{

    public function Header()
    {

        global $title;
        global $ctitle;
        global $ori;
        global $size;
        global $rptname;
        global $rptname1;
        global $filter;
        if (isset($ctitle) && $ctitle != '') {
            $title .= " (" . $ctitle . ")";
        }
      //  $image_file = '../../assets/images/mill_logo.png';
      //  $this->Image($image_file, 10, 5, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file = '../../assets/images/logo.png';
        $this->Image($image_file, 0, 6, '', 8, 'PNG', '', 'T', false, 300, 'R', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('freeserif', 'B', 15);
        $this->SetY(6);

        //        $this->Cell(0,15, '        '.'DATALOG Technologies Pvt Ltd', '', false, 'L', 0, '', 1, false, 'A', 'M');
        $this->SetFont('freeserif', 'B', 10);
        $this->SetY(10);

        $this->Cell(0, 15, $rptname . $rptname1, '', false, 'C', 0, '', 1, false, 'A', 'M');
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(225, 225, 225));
        if ($size == 'A4') {
            if ($ori == 'L') {
                $this->Line(10, 15, 294, 15, $style);
            } else {
                $this->Line(10, 15, 207, 15, $style);
            }
        } else if ($size == 'A3') {
            if ($ori == 'L') {
                $this->Line(10, 15, 417, 15, $style);
            } else {
                $this->Line(10, 15, 294, 15, $style);
            }
        } else if ($size == 'A5') {
            if ($ori == 'L') {
                $this->Line(10, 15, 207, 15, $style);
            } else {
                $this->Line(10, 15, 145, 15, $style);
            }
        }
        $this->SetY(16);
        $this->SetFont('freeserif', '', 10);
        $title = '<b>' . $title . '</b>';
        $this->writeHTML($title, true, false, true, false, '');
        //        $this->Cell(0, 0, $title, 0, false, 'L', 0, 0, '', '', true);

        $this->SetY(16);
        $this->SetFont('freeserif', '', 6);
        $this->Cell(0, 10, date('d-M-y h:i A'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        if ($size == 'A4') {
            if ($ori == 'L') {
                $this->Line(10, 23, 294, 23, $style);
            } else {
                $this->Line(10, 23, 207, 23, $style);
            }
        } else if ($size == 'A3') {
            if ($ori == 'L') {
                $this->Line(10, 23, 417, 23, $style);
            } else {
                $this->Line(10, 23, 294, 23, $style);
            }
        } else if ($size == 'A5') {
            if ($ori == 'L') {
                $this->Line(10, 23, 207, 23, $style);
            } else {
                $this->Line(10, 23, 145, 23, $style);
            }
        }
    }
    // Page footer
    public function Footer()
    {

        $this->SetY(-8);

        $this->SetFont('freeserif', 'I', 6);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF($ori, PDF_UNIT, $size, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(1, PDF_MARGIN_TOP, 1);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('freeserif', '', $fontsize);

// add a page
$pdf->AddPage();
//$data=mb_convert_encoding($data, 'HTML-ENTITIES', 'UTF-8');
// print a block of text using Write()

$pdf->writeHTML($data, true, false, true, false, '');

// ---------------------------------------------------------
$rptname = "Datalog_" . date('YmdHis') . ".pdf";
//Close and output PDF document
$pdf->Output(__DIR__ . "/outputs/" . $rptname, 'F');
echo  'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/outputs/" . $rptname;
//============================================================+
// END OF FILE
//============================================================+

<?php
// Include the Dompdf library
require_once 'dompdf/autoload.inc.php';
// Reference the Dompdf namespace
use Dompdf\Dompdf;
// Initialize Dompdf object
$dompdf = new Dompdf();
$html = file_get_contents("01dompdf.php"); 
$dompdf->loadHtml($html); 
$dompdf->setPaper('A5', 'landscape'); 
// landscape portrait
$dompdf->render();
$dompdf->stream("codexworld", array("Attachment" => 0));
//1  = Download
//0 = Preview
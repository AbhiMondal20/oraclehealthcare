<?php
include ('../../db_conn.php');

// Path to the .rdl file
$rdlFilePath = '"RHYTHM/Receipt/registration_receipt.rdl"';

// Path where you want to save the generated PDF
$pdfFilePath = 'RHYTHM/Receipt/generated.pdf';

// Function to generate PDF from .rdl file
function generatePDFFromRDL($rdlFilePath, $pdfFilePath) {
    // Check if the .rdl file exists
    if (!file_exists($rdlFilePath)) {
        die("RDL file not found.");
    }

    // Run whatever command or library you use to generate the PDF from the .rdl file
    // For example, you might use a library like PhantomJS, wkhtmltopdf, or a dedicated reporting tool
    // Here's a simple example using wkhtmltopdf
    exec("wkhtmltopdf $rdlFilePath $pdfFilePath");

    // Check if the PDF was generated successfully
    if (!file_exists($pdfFilePath)) {
        die("PDF generation failed.");
    }
}

// Generate PDF
generatePDFFromRDL($rdlFilePath, $pdfFilePath);

// If the PDF is generated successfully, you can now output it to the browser
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="generated.pdf"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
readfile($pdfFilePath);

// Optionally, you can delete the generated PDF file after sending it to the browser
unlink($pdfFilePath);

?>

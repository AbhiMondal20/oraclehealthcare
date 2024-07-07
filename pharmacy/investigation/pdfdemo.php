<?php

$html = '<style>
    div { border: 1px solid black; padding: 1em; }
    .level3 { box-decoration-break: clone; }
</style>

<div class="level1">
    <div class="level2">
        <div class="level3">
        Types of page breakPermalink¶
        The handling of borders and padding at page breaks was updated in mPDF 6.0. mPDF has three types of page breaks:
        
        “slice” - no border and no padding are inserted at a break. The effect is as though the element were rendered with no breaks present, and then sliced by the breaks afterward
        </div>
        “cloneall” - each page fragment is independently wrapped with the borders and padding of all open elements.
        
        “clonebycss” - open elements which have the (custom) CSS property box-decoration-break set to clone are independently wrapped with their border and padding.

        Types of page breakPermalink¶
        The handling of borders and padding at page breaks was updated in mPDF 6.0. mPDF has three types of page breaks:
        
        “slice” - no border and no padding are inserted at a break. The effect is as though the element were rendered with no breaks present, and then sliced by the breaks afterward
        
        “cloneall” - each page fragment is independently wrapped with the borders and padding of all open elements.
        
        “clonebycss” - open elements which have the (custom) CSS property box-decoration-break set to clone are independently wrapped with their border and padding. Types of page breakPermalink¶
        The handling of borders and padding at page breaks was updated in mPDF 6.0. mPDF has three types of page breaks:
        
        “slice” - no border and no padding are inserted at a break. The effect is as though the element were rendered with no breaks present, and then sliced by the breaks afterward
        
        “cloneall” - each page fragment is independently wrapped with the borders and padding of all open elements.
        
        “clonebycss” - open elements which have the (custom) CSS property box-decoration-break set to clone are independently wrapped with their border and padding. Types of page breakPermalink¶
        The handling of borders and padding at page breaks was updated in mPDF 6.0. mPDF has three types of page breaks:
        
        “slice” - no border and no padding are inserted at a break. The effect is as though the element were rendered with no breaks present, and then sliced by the breaks afterward
        
        “cloneall” - each page fragment is independently wrapped with the borders and padding of all open elements.
        
        “clonebycss” - open elements which have the (custom) CSS property box-decoration-break set to clone are independently wrapped with their border and padding. Types of page breakPermalink¶
        The handling of borders and padding at page breaks was updated in mPDF 6.0. mPDF has three types of page breaks:
        
        “slice” - no border and no padding are inserted at a break. The effect is as though the element were rendered with no breaks present, and then sliced by the breaks afterward
        
        “cloneall” - each page fragment is independently wrapped with the borders and padding of all open elements.
        
        “clonebycss” - open elements which have the (custom) CSS property box-decoration-break set to clone are independently wrapped with their border and padding. Types of page breakPermalink¶
        The handling of borders and padding at page breaks was updated in mPDF 6.0. mPDF has three types of page breaks:
        
        “slice” - no border and no padding are inserted at a break. The effect is as though the element were rendered with no breaks present, and then sliced by the breaks afterward
        
        “cloneall” - each page fragment is independently wrapped with the borders and padding of all open elements.
        
        “clonebycss” - open elements which have the (custom) CSS property box-decoration-break set to clone are independently wrapped with their border and padding.
    </div>


    
</div>';

require ('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A5-L',
    'allow_remote_images' => true,
    'debug' => true,
    'autoPageBreak' => true,
]);

// $mpdf->SetDisplayMode('fullpage');
$file = 'BILL-CUM-RECEIPT.pdf';
$mpdf->use_kwt = true; 
$mpdf->SetFooter('<div >Conted...</div>');
// $mpdf->WriteHTML($html);
// $mpdf->AddPage();
// Double-side document - mirror margins
$mpdf->mirrorMargins = 1;

// Set a simple Footer including the page number
$mpdf->setFooter('{PAGENO}');

// Turn off (suppress) page numbering from the start of the document
$mpdf->AddPage('','','','','on');
$mpdf->WriteHTML('Your Front Cover Pages');
// You could also do this using
$mpdf->AddPage('asdasd','NEXT-ODD','2','i','off');
$mpdf->WriteHTML('Your Foreword and Introduction');
// $mpdf->WriteHTML('<pagebreak type="NEXT-ODD" pagenumstyle="1" />');
// $mpdf->WriteHTML('Your Book text');

$mpdf->output($file, 'I');
?>
<?php
include ('function.php');
require ('../vendor/autoload.php');

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'allow_remote_images' => true,
    'debug' => true,
]);

$id = isset($_GET['id']) ? $_GET['id'] : '';
$rno = isset($_GET['rno']) ? $_GET['rno'] : '';
$modality = isset($_GET['modality']) ? $_GET['modality'] : '';
$subgroup = isset($_GET['subgroup']) ? $_GET['subgroup'] : '';
$pname = $opid = $subtest = $unit = $inval = $normrang = $status = $age = $gender = '';
$dataFound = false;

if (!empty($rno) && !empty($modality) && !empty($subgroup) && !empty($id)) {

    $sql = "SELECT
                pr.pname AS pname, 
                pr.opid AS opid, 
                pr.rno AS rno, 
                pr.subtest AS subtest, 
                pr.unit AS unit, 
                pr.normrang AS normrang,
                pr.inval AS inval,
                pr.status AS status,
                r.rage AS age,
                r.rsex AS gender
            FROM PathoReport AS pr 
            INNER JOIN registration AS r ON r.rno = pr.rno
            WHERE pr.rno = ? AND pr.modality = ? AND pr.subgroup = ?";

    $params = array($rno, $modality, $subgroup);
    $stmt = mysqli_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(mysqli_errors(), true));
    }

    if ($row = mysqli_fetch_array($stmt)) {
        $dataFound = true;
        $pname = htmlspecialchars($row['pname']);
        $rno = htmlspecialchars($row['rno']);
        $opid = htmlspecialchars($row['opid']);
        $subtest = htmlspecialchars($row['subtest']);
        $unit = htmlspecialchars($row['unit']);
        $inval = htmlspecialchars($row['inval']);
        $normrang = htmlspecialchars($row['normrang']);
        $status = htmlspecialchars($row['status']);
        $age = htmlspecialchars($row['age']);
        $gender = htmlspecialchars($row['gender']);
    }

    mysqli_free_stmt($stmt);
}

// Generate the header
$header = '
<div><br><br><br><br><br><br><div class="container1">
<span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>
    <div class="wrapper">
        <div class="box a"><strong>Name:</strong> &nbsp;&nbsp;<span class="txt">' . $pname . '</span></div>
        <div class="box b" id="age"><strong>Age & Gender:</strong> &nbsp;&nbsp;&nbsp;<span class="txt">' . $age . ' / ' . $gender . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box a"><strong>Reg No:</strong>&nbsp;<span class="txt">' . $rno . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date"><strong>OP ID.: </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $opid . '</div>
    </div>
    <span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>
</div><br><br><br>';

$html2 = '<table id="myTable" style="margin: 0 auto; padding: 0px;">
    <thead>
        <tr>
            <th style="padding: 0 20px; ">Name of Test</th>
            <th style="padding: 0 ;">Result</th>
            <th style="padding: 0 60px;">Unit</th>
            <th style="padding: 0 60px;">Normal Reference</th>
        </tr>
    </thead>
    <tbody><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>';

$sql = "SELECT b.unit, b.subtest, b.inval, b.normrang, b.subgroup
    FROM PathoReport AS b
    ORDER BY subtest DESC";

$params = array($rno);
$stmt = mysqli_query($conn, $sql, $params);
$sno = 0;
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}

$subtotal = 0;
$footer = '';

$totalRows = mysqli_num_rows($stmt);
$rowCount = 0;

while ($row = mysqli_fetch_array($stmt)) {
    $sno++;
    $unit = $row['unit'];
    $subtest = $row['subtest'];
    $normrang = $row['normrang'];
    $inval = $row['inval'];
    $subgroup = $row['subgroup'];
    $html2 .= '<tr>
                    <td style="padding: 0 20px; text-transform: uppercase;">' . $subtest . '.</td>
                    <td style="padding: 0 ; text-transform: uppercase;">:&nbsp;' . $inval . '</td>
                    <td style="padding: 0 60px; text-transform: uppercase;">' . $unit . '</td>
                    <td style="padding: 0 60px; text-transform: uppercase;">' . $normrang . '.00</td>
                </tr>';
    // $subtotal += $servrate;
    $rowCount++;
    if ($rowCount % 22 == 0) {
        $html2 .= '</tbody></table><pagebreak/><div class="next-page" style="padding-top: 55mm;"></div><table id="myTable" style="margin: 0 auto;">
        <tbody><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span><tr>
        <th style="padding: 0 90px; "></th>
        <th style="padding: 0px  60px"></th>
        <th style="padding: 0px 20px; "></th>
        <th style="padding: 0px 20px; "></th>
        </tr><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>';
        $footer .= '<div id="html_footer"><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>Contd..</div>';
    }
}

$html2 .= '</tbody></table>';

$Last_footer = '</div><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span><div class="container1">
   
</div><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>';
$mpdf->SetHeader('');
$mpdf->SetHTMLHeader($header);
$mpdf->SetFooter('');
$mpdf->SetHTMLFooter($footer);

$footerStyles = "<style>
#html_footer {
    position: fixed;
    bottom: -5;
    width: 100%;
    text-align: right;
}
</style>";

$mpdf->WriteHTML($footerStyles);
$mpdf->WriteHTML('<br><br><br><br><br><br><br><br><br><h5 style="text-align: center;"></h5>');
$mpdf->WriteHTML($html2);
$mpdf->SetFooter('');
$mpdf->SetHTMLFooter($Last_footer);
// $pdf->SetTitle('Bill Cum Receipt');

// $mpdf-> AddPage();
// $mpdf-> AddPage();
$css = file_get_contents('css/pdfcss.css');
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->Output();

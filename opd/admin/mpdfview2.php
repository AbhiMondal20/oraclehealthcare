<?php
include ('function.php');
require ('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A5-L',
    'allow_remote_images' => true,
    'debug' => true,
]);
$rno1 = isset($_GET['rno']) ? $_GET['rno'] : '';
$billno1 = isset($_GET['billno']) ? $_GET['billno'] : '';

if (!empty($rno1) && !empty($billno1)) {
    $sql1 = "SELECT bd.pname AS pname, 
                bd.phone AS phone, 
                bd.rdocname AS rdocname,
                bd.billdate AS billdate, 
                bd.totalPrice AS totalPrice, 
                bd.totalAdj AS totalAdj, 
                bd.discount AS discount, 
                bd.billAmount AS billAmount, 
                bd.paidAmount AS paidAmount, 
                bd.balance AS balance, 
                bd.status AS status, 
                rs.rage AS rage, 
                rs.rsex AS rsex,
                rs.radd1 AS add1,
                rs.radd2 AS add2,
                rs.rcity AS city,
                rs.opid AS opid
                FROM billingDetails AS bd 
                INNER JOIN registration AS rs 
                ON bd.rno = rs.rno
                WHERE bd.rno = ? AND bd.billno = ?";

    $params1 = array($rno1, $billno1);
    $stmt1 = sqlsrv_query($conn, $sql1, $params1);

    if ($stmt1 === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    if ($row = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
        $pname = $row['pname'];
        $phone = $row['phone'];
        $billdate = $row['billdate'];
        $totalPrice = $row['totalPrice'];
        $rdocname = $row['rdocname'];
        $totalAdj = $row['totalAdj'];
        $discount = $row['discount'];
        $billAmount = $row['billAmount'];
        $paidAmount = $row['paidAmount'];
        $balance = $row['balance'];
        $status = $row['status'];
        $gender = $row['rsex'];
        $age = $row['rage'];
        $add1 = $row['add1'];
        $add2 = $row['add2'];
        $city = $row['city'];
        $opid = $row['opid'];
    } else {
        echo "No data found for the provided rno and billno.";
    }
    sqlsrv_free_stmt($stmt1);
}

$header = '
</div><br><br><br><br><br><div class="container">
    <div class="wrapper">
        <div class="box a"><strong>Name:</strong> &nbsp;&nbsp;<span class="txt">' . $pname . '</span></div>
        <div class="box b" id="age"><strong>Age & Gender:</strong> &nbsp;&nbsp;&nbsp;<span class="txt">' . $age . ' / ' . $gender . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box a"><strong>Reg No:</strong>&nbsp;<span class="txt"> ' . $rno1 . '</span></div>
        <div class="box b" id="reg_date"><strong>Bill Date: </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $billdate . '</div>
    </div>
    <div class="wrapper">
        <div class="box a"><strong>OP Id :</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt">' . $opid . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date"><strong>Ref. Doctor: </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $rdocname . '</div>
    </div>
    <div class="wrapper">
        <div class="box a"><strong>Bill No :</strong>&nbsp;&nbsp;&nbsp;<span class="txt">' . $billno1 . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date"><strong>Address: </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $add1 . ',&nbsp;' . $city . '</div>
    </div>
</div><br><br><br><br><br>';
$html2 = '<table style="margin: 0 auto; padding: 0px;">
    <thead>
        <tr>
            <th style="padding: 0 50px;">Sr. No.</th>
            <th style="padding: 0 ;">Description</th>
            <th style="padding: 0 50px;">Qty</th>
            <th style="padding: 0 50px;">Amount</th>
        </tr>
    </thead>
    <tbody>';
$sql = "SELECT b.servname, b.servrate
    FROM billing AS b 
    WHERE b.rno = '$rno1' AND b.billno = '$billno1'
    GROUP BY b.servname, b.servrate";

$params = array($rno1, $billno1);
$stmt = sqlsrv_query($conn, $sql, $params);
$sno = 0;
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Initialize subtotal and footer
$subtotal = 0;
$footer = '';

// Count the total number of rows returned from the SQL query
$totalRows = sqlsrv_num_rows($stmt);
$rowCount = 0;

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $sno++;
    $servname = $row['servname'];
    $servrate = $row['servrate'];

    // Add row to HTML
    $html2 .= '<tr>
<td style="padding: 0 50px;">' . $sno . '</td>
<td style="padding: 0 ;">' . $servname . '</td>
<td style="padding: 0 50px;">1</td>
<td style="padding: 0 50px;">₹ ' . $servrate . '</td>
</tr>';
    // $subtotal += $servrate;
    $rowCount++;
    if ($rowCount % 4 == 0) {
        $html2 .= '</tbody></table><pagebreak/><div class="next-page" style="padding-top: 45mm;"></div><h4 style="text-align: center;">BILL</h4><table style="margin: 0 auto;">
        <tbody><tr>
        <th style="padding: 0 50px;">Sr. No.</th>
        <th style="padding: 0 ">Description</th>
        <th style="padding: 0 50px;">Qty</th>
        <th style="padding: 0 50px;">Amount</th>
        </tr>';
        $footer .= '<div id="html_footer"><hr>Contd..</div>';
    }
}


$html2 .= '</tbody></table>';

// Add the summary rows
// $html2 .= '<table class="bill-table">
//     <tbody>
//     <tr>
//         <td colspan="3" class="total">Bill Amount</td>
//         <td>₹ ' . $billAmount . '</td>
//     </tr>
//     <tr>
//         <td colspan="3" class="total">Advance</td>
//         <td>₹ ' . $paidAmount . '.00</td>
//     </tr>
//     <tr>
//         <td colspan="3" class="total">Balance/Due</td>
//         <td>₹ ' . $balance . '</td>
//     </tr>
//     <tr>
//         <td colspan="3" class="total">' . getIndianCurrency($billAmount) . 'Only /&nbsp;&nbsp;Mode:</td>
//         <td>' . $status . '</td>
//     </tr>
//     </tbody>
// </table>';

$Last_footer = '
</div><hr><div class="container1">
    <div class="wrapper">
        <div class="box a">Total Amount &nbsp;&nbsp;<span class="txt">₹ ' . $billAmount . '</span></div>
        <div class="box b" id="age">Less Adjusted: &nbsp;&nbsp;&nbsp;<span class="txt">₹' . ($totalAdj !== NULL ? $totalAdj : "₹ 0.00") . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box a">Net Payable:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt">₹' . $paidAmount . '.00</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date">Balance/Due: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;₹' . $balance . '</div>
    </div>
    <div class="wrapper">
        <div class="box a">Mode:&nbsp;&nbsp;&nbsp;<span class="txt">' . $status . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date">Rupees: ' . getIndianCurrency($billAmount) . '</div>
    </div>
</div><hr>';
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
$mpdf->WriteHTML('<br><br><br><br><br><br><br><br><br><h5 style="text-align: center;">BILL CUM RECEIPT</h5>');
$mpdf->WriteHTML($html2);
$mpdf->SetFooter('');
$mpdf->SetHTMLFooter($Last_footer);
// $pdf->SetTitle('Bill Cum Receipt');

// $mpdf-> AddPage();
// $mpdf-> AddPage();
$css = file_get_contents('css/pdfcss.css');
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
// remove header footer line border
$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->Output();

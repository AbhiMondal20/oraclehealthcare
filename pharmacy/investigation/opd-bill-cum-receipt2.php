<?php
include('function.php');
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}

$rno1 = isset($_GET['rno']) ? $_GET['rno'] : '';
$billno1 = isset($_GET['billno']) ? $_GET['billno'] : '';

if (!empty($rno1) && !empty($billno1)) {
    $sql1 = "SELECT bd.pname AS pname, 
            bd.phone AS phone, 
            bd.rdocname AS rdocname,
            bd.billdate AS billdate, 
            bd.totalPrice AS totalPrice, 
            bd.totalAdj AS totalAdj, 
            bd.gst AS gst, 
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
        $gst = $row['gst'];
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

$htmlHeader = '<div class="container " >
    <div class="wrapper ">
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
</div>';

$html = '
   <h2 style="text-align: center;"><b>BILL CUM RECEIPT</b></h2>';
   
$html2 = '<table class="bill-table">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Amount</th>
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

// Count the total number of rows returned from the SQL query
$totalRows = sqlsrv_num_rows($stmt);
// Calculate the total number of pages
// $totalPages = ceil($totalRows / 5); // Assuming you want 5 rows per page

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $sno = $sno + 1;
    $servname = $row['servname'];
    $servrate = $row['servrate'];
    //   $total = $row['total'];
    $html2 .= '<tr>
    <td>' . $sno . '</td>
    <td>' . $servname . '</td>
    <td>1</td>
    <td>₹ ' . $servrate . '</td>';
}
$html2 .= '</tr>
    <tr>
        <td colspan="3" class="total">Bill Amount</td>
        <td>₹ ' . $billAmount . '</td>
    </tr>
    <tr>
        <td colspan="3" class="total">Advance</td>
        <td>₹ ' . $paidAmount . '.00</td>
    </tr>
    <tr>
        <td colspan="3" class="total">Balance/Due</td>
        <td>₹ ' . $balance . '</td>
    </tr>
    <tr>
        <td colspan="3" class="total">' . getIndianCurrency($billAmount) . 'Only /&nbsp;&nbsp;Mode:</td>
        <td>' . $status . '</td>
    </tr>
    </tbody>
</table>';

require('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A5-L',
    'allow_remote_images' => true,
    'debug' => true,
]);

$css = file_get_contents('css/pdfcss.css');
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->SetHTMLHeader($htmlHeader);
$mpdf->SetDisplayMode('fullpage');
$file = 'BILL-CUM-RECEIPT/' . $pname . '.pdf';
// Set HTML header content
$mpdf->AliasNbPages('[pagetotal]');
$mpdf->WriteHTML('
    There are [pagetotal] pages in this document
');

// $totalPages = $mpdf->AliasNbPages('[pagetotal]');
// for ($i = 0; $i < $totalPages; $i++) {
//     $mpdf->WriteHTML($htmlHeader);
// }

$mpdf->WriteHTML($html);
$mpdf->WriteHTML($html2);

$mpdf->SetFooter('<div >Conted...</div>');
$mpdf->Output($file, 'I');


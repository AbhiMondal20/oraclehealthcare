<?php
include ('function.php');
require ('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A5-L',
    'allow_remote_images' => true,
    'debug' => true,
]);

$mpdf->SetTitle('Rhythm - Bill Return ');
$rno1 = isset($_GET['rno']) ? $_GET['rno'] : '';
$billno1 = isset($_GET['billno']) ? $_GET['billno'] : '';
$billdate = isset($_GET['billdate']) ? $_GET['billdate'] : '';
if (!empty($rno1) && !empty($billno1)) {
    $rno1 = $conn->real_escape_string($rno1);
    $billno1 = $conn->real_escape_string($billno1);
    $billdate = $conn->real_escape_string($billdate);

    // SQL query
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
                    bd.rtime AS rtime,
                    rs.rage AS rage, 
                    rs.rsex AS rsex,
                    rs.radd1 AS add1,
                    rs.radd2 AS add2,
                    rs.rcity AS city,
                    rs.opid AS opid
            FROM returnbillingDetails AS bd 
            INNER JOIN registration AS rs 
            ON bd.rno = rs.rno
            WHERE bd.rno = '$rno1' AND bd.billno = '$billno1' AND bd.billdate = '$billdate'";

    // Execute query
    $result1 = $conn->query($sql1);
    if ($result1 === false) {
        die("Error executing query: " . $conn->error);
    }
    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $pname = $row['pname'];
        $phone = $row['phone'];
        $rdocname = $row['rdocname'];
        $billdate = $row['billdate'];
        $totalPrice = $row['totalPrice'];
        $totalAdj = $row['totalAdj'];
        $gst = $row['gst'];
        $billAmount = $row['billAmount'];
        $paidAmount = $row['paidAmount'];
        $balance = $row['balance'];
        $status = $row['status'];
        $rtime = $row['rtime'];
        $age = $row['rage'];
        $gender = $row['rsex'];
        $add1 = $row['add1'];
        $add2 = $row['add2'];
        $city = $row['city'];
        $opid = $row['opid'];
        $result1->free();
    } else {
        echo "No data found for the provided rno and billno.";
    }
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
        FROM returnBilling AS b 
        WHERE b.rno = '$rno1' AND b.billno = '$billno1'
        GROUP BY b.servname, b.servrate";
        

$stmt = mysqli_query($conn, $sql);
$sno = 0;
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}

$subtotal = 0;
$footer = '';
$totalRows = mysqli_num_rows($stmt);
$rowCount = 0;
$servrateTotal = 0;
while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $sno++;
    $servname = $row['servname'];
    $servrate = $row['servrate'];
    $subtotal = $servrate;
    $servrateTotal += $subtotal;
    $html2 .= '<tr>
                    <td style="padding: 0 50px;">' . $sno . '</td>
                    <td style="padding: 0 ;">' . $servname . '</td>
                    <td style="padding: 0 50px;">1</td>
                    <td style="padding: 0 50px;">₹ ' . $servrate . '</td>
                </tr>';
    // $subtotal += $servrate;
    $rowCount++;
    if ($rowCount % 4 == 0) {
        $html2 .= '</tbody></table><pagebreak/><div class="next-page" style="padding-top: 45mm;"></div><h4 style="text-align: center;">BILL RETURN</h4><table style="margin: 0 auto;">
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

$Last_footer = '
</div><hr><div class="container1">
    <div class="wrapper">
        <div class="box a">Total Amount &nbsp;&nbsp;<span class="txt">₹ ' . $servrateTotal . '</span></div>
        <div class="box b" id="age">Less Adjusted: &nbsp;&nbsp;&nbsp;<span class="txt">₹' . ($totalAdj !== NULL ? $totalAdj : "₹ 0.00") . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box a">Return Amount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt">₹' . $servrateTotal . '.00</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date">Balance/Due: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;₹' . $balance . '</div>
    </div>
    <div class="wrapper">
        <div class="box a">Remark:&nbsp;&nbsp;&nbsp;<span class="txt">' . $status . '</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date">Rupees: ' . getIndianCurrency($servrateTotal) . '</div>
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
$mpdf->WriteHTML('<br><br><br><br><br><br><br><br><br><h5 style="text-align: center;">BILL RETURN</h5>');
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
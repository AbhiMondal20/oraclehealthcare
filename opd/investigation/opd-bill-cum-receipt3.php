<?php
include ('../../db_conn.php');
session_start();
if (isset ($_SESSION['login']) && $_SESSION['login'] == true) {
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

$html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Caleb Adeleye">
    <title>Receipt </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://use.fontawesome.com/65eb163cd4.js"></script>
    <link href="css/pdf.css" rel="stylesheet" />
</head>
<body>
    <div class="container-fluid invoice-container" id="invoice">
        <header>
            <div class="row align-items-center">
                <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
                </div>
                <div class="col-sm-5 text-center text-sm-right">
                    <h4 class="text-7 mb-0">Receipt</h4>
                </div>
            </div>
            <hr style="background-color: green;">
        </header>

        <main id="receipt">

            <div class="row">
                <div class="col-sm-6"><strong>Date:</strong> '.$billdate.' </div>
                <div class="col-sm-6 text-sm-right"> <strong>Reg No:</strong> '.$rno1.'</div>

            </div>
            <div class="row">
                <div class="col-sm-12 text-sm-center">
                    <h3 style="padding-top: 15px;">BILL CUM RECEIPT</h3>
                </div>
            </div>
            <hr style="background-color: black;">
            <div class="row">
                <div class="col-sm-6 text-sm-right order-sm-1"> <strong>OSPOLY PAY:</strong>
                    <address>
                        Osun State Polytechnic Iree<br />
                        (+234) 8034904264, 08034879983<br />
                        support@ospolypay.com.ng

                    </address>
                </div>
                
                <div class="col-sm-6 order-sm-0"> <strong>Payment By:</strong>
                    <address>
                        NAME: '.$pname.'<br />
                    </address>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="card-header">
                                <tr>
                                    <td class="col-3 border-0"><strong>Description</strong></td>
                                    <td class="col-4 border-0"><strong>Student Type</strong></td>
                                    <td class="col-2 text-center border-0"><strong>Rate</strong></td>
                                    <td class="col-1 text-center border-0"><strong>QTY</strong></td>
                                    <td class="col-2 text-right border-0"><strong>Amount</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-3 border-0" style="background-color: #dcd8cf;color: #000;">Payment
                                        For S.U.G Due</td>
                                    <td class="col-4 text-1 border-0" style="background-color: #dcd8cf;color: #000;">
                                        Staylite</td>
                                    <td class="col-2 text-center border-0"
                                        style="background-color: #dcd8cf;color: #000;">&#8358;250</td>
                                    <td class="col-1 text-center border-0"
                                        style="background-color: #dcd8cf;color: #000;">1</td>
                                    <td class="col-2 text-right border-0"
                                        style="background-color: #2264c4;color: #fff;">&#8358;250</td>
                                </tr>

                            </tbody>
                            <tfoot class="card-footer">
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Sub Total:</strong></td>
                                    <td class="text-right">&#8358;250</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Transaction Fee:</strong></td>
                                    <td class="text-right">&#8358;50</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                    <td class="text-right">&#8358;300</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right" style="background-color: #dcd8cf;color: #000;">
                                        <strong>Receipt No:</strong></td>
                                    <td class="text-right" style="background-color: #2264c4;color: #fff;">OP/SUGDUE</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </main>

    </div>
</body>

</html>';

require ('../vendor/autoload.php');
// $mpdf=new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P', 'allow_remote_images' => true, 'debug' => true]);
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$file = 'Report/' . $pname . '.pdf';
// $mpdf->SetWatermarkText('UNITED TELERADIOLOGY SERVICES',0.3);
// $mpdf->showWatermarkText = true;
// $mpdf->watermarkTextAlpha = 0.1;
// $mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->output($file, 'I');

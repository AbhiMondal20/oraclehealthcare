<?php
session_start();
if (isset ($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
    include ('header.php');
?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Bill</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Bill</li>
                                <li class="breadcrumb-item active" aria-current="page">BILL CUM RECEIPT</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="invoice printableArea">
            <div class="row">

                <div class="col-12">
                    <div class="page-header">
                        <center>
                            <h2 class="d-inline"><span class="fs-30">BILL CUM RECEIPT</span></h2>
                        </center>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <?php
            $rno = $_GET['rno'];
            $billno = $_GET['billno'];

            $sql = "SELECT bd.rstatus AS rstatus, 
            bd.pname AS pname, 
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
            rs.rcity AS city
            FROM billingDetails AS bd 
            INNER JOIN registration AS rs 
            ON bd.rno = rs.rno
            WHERE bd.rno = '$rno' AND bd.billno = '$billno'";
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt === false) {
                die (print_r(sqlsrv_errors(), true));
            }
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $rstatus = $row['rstatus'];
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
            }
            ?>
            <div class="row invoice-info">
                <div class="col-md-6 invoice-col">
                    <!-- <strong>From</strong> -->
                    <address>
                        <strong class="text-blue fs-16">Regd No :
                            <?php echo $rno; ?>
                        </strong><br>
                        <strong class="text-blue fs-16">Name of Patient :
                            <?php echo $pname; ?>, Age :
                            <?php echo $age; ?>Y,
                            Gender : <?php echo $gender; ?>
                            
                        </strong><br>
                        <strong class="d-inline">Address :
                            <?php echo $add1 . "&nbsp;" . $add2 . "&nbsp;" . $city; ?>
                        </strong><br>
                        <strong class="d-inline">Dr. :
                            <?php echo $rdocname; ?>
                        </strong><br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-md-6 invoice-col text-end">
                    <address>
                        <strong class="text-blue fs-24">Bill No :
                            <?php echo $billno; ?> /
                            <?php echo $rstatus; ?>
                        </strong><br>
                        Date :
                        <?php echo $billdate; ?><br>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Amount</th>
                            </tr>
                            <?php
                           $sql = "SELECT billing.servname, MAX(billing.servrate) AS max_servrate 
                           FROM billing 
                           WHERE rno = '$rno' AND billno = '$billno' 
                           GROUP BY billing.servname";                   
                            $stmt = sqlsrv_query($conn, $sql);
                            $sno = 0;
                            if ($stmt === false) {
                                die (print_r(sqlsrv_errors(), true));
                            }
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $sno = $sno + 1;
                                $servname = $row['servname'];
                                $servrate = $row['max_servrate'];
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $sno; ?>
                                    </td>
                                    <td >
                                        <?php echo $servname; ?>
                                    </td>
                                    <td class="text-end">1</td>
                                    <td class="text-end">₹
                                        <?php echo $servrate; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-12 text-end">
                    <div>
                        <p>Sub - Total amount : ₹ <?php echo $totalPrice; ?></p>
                        <p>Less Adjusted : ₹ <?php echo $totalAdj; ?></p>
                        <p>GST (%) : ₹ <?php echo $gst; ?> </p>
                    </div>
                    <div class="total-payment">
                        <h3><b>Bill Amount :</b> ₹ <?php echo $billAmount; ?></h3><br>
                    </div>
                    <p>Advance : ₹ <?php echo $paidAmount; ?></p>
                    <p>Balance/Due : ₹ <?php echo $balance; ?></p>
                    <p>Mode: <?php echo $status; ?></p>
                </div>
                <div class="col-sm-12 invoice-col mb-15">
                    <div class="row no-margin">
                        <div class="col-md-6 col-lg-6">Rupees:&nbsp;<?php echo getIndianCurrency($billAmount) ?></div>
                    </div>
                </div>
                <div class="col-sm-12 invoice-col mb-15">
                    <div class="row no-margin">
                        <div class="col-md-6 col-lg-6">All Disputes Subject to Jurisdiction Only</div>
                    </div>
                </div>
                <center>
                    E.& O.E. <br> For Rhythm Health Care
                </center>
            </div>
        </section>
        <div class="col-12">
            <div class="bb-1 clearFix">
                <div class="text-center pb-15">
                    <button id="print2" class="btn btn-primary btn-lg" type="button"> <span><i class="fa fa-print"></i>
                            Print</span> </button>
                </div>
            </div>
        </div>

        <!-- /.content -->
    </div>
</div>
<?php
include ('footer.php');
?>
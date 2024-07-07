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
                    <h4 class="page-title">Money</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Money</li>
                                <li class="breadcrumb-item active" aria-current="page">Money Receipt</li>
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
                            <h2 class="d-inline"><span class="fs-30">MONEY RECEIPT</span></h2>
                        </center>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <?php
            $id = $_GET['id'];
            $rno = $_GET['rno'];

            $sql = "SELECT TOP 500 
            bd.pname AS pname,
            bd.id AS id,
            bd.rno AS rno,
            bd.billno AS billno,
            bd.rdocname AS rdocname,
            bd.billdate AS billdate, 
            bd.totalPrice AS totalPrice, 
            bd.totalAdj AS totalAdj, 
            bd.gst AS gst, 
            bd.billAmount AS billAmount, 
            bd.paidAmount AS paidAmount, 
            bd.balance AS balance, 
            bd.status AS status
            FROM billingDetails AS bd
            WHERE bd.id = '$id' AND bd.rno = '$rno'";
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt === false) {
                die (print_r(sqlsrv_errors(), true));
            }
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $id = $row['id'];
                $rno = $row['rno'];
                $billno = $row['billno'];
                $pname = $row['pname'];
                $billdate = $row['billdate'];
                $totalPrice = $row['totalPrice'];
                $rdocname = $row['rdocname'];
                $totalAdj = $row['totalAdj'];
                $gst = $row['gst'];
                $billAmount = $row['billAmount'];
                $paidAmount = $row['paidAmount'];
                $balance = $row['balance'];
                $status = $row['status'];
            }
            ?>
            <div class="row invoice-info">
                <div class="col-md-6 invoice-col">
                    <!-- <strong>From</strong> -->
                    <address>
                        <strong class="text-blue fs-16">Bill No :
                            <?php echo $billno; ?>
                        </strong><br>
                        <strong class="text-blue fs-16">Reg No :
                            <?php echo $rno; ?> 
                        </strong><br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-md-6 invoice-col text-end">
                    <address>
                        Date :
                        <?php echo $billdate; ?><br>
                    </address>
                </div>
                <p>Received with thanks from
                    <?php echo $pname; ?>
                </p>

            </div>
            <hr>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <!-- table-bordered -->
                        <tbody>
                            <tr>
                                <th class="text-end">Bill No </th>
                                <th class="text-end">Date</th>
                                <th class="text-end">Bill Amt</th>
                                <th class="text-end">Adjusted</th>
                                <th class="text-end">Paid Amt</th>
                                <th class="text-end">Mode Of Payment</th>
                            </tr>
                            <tr>
                                <td class="text-end">
                                    <?php echo $billno; ?>
                                </td>
                                <td class="text-end">
                                    <?php echo $billdate; ?>
                                </td>
                                <td class="text-end">₹
                                    <?php echo $billAmount; ?>
                                </td>
                                <td class="text-end">
                                    ₹
                                    <?php echo $totalAdj; ?>
                                </td>
                                <td class="text-end">
                                    ₹
                                    <?php echo $paidAmount; ?>
                                </td>
                                <td class="text-end">
                                    <?php echo $status; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-12 text-end">
                    <div>
                        <p>Total Paid : ₹
                            <?php echo $totalPrice; ?>
                        </p>
                    </div>
                </div>
                <div class="col-sm-12 invoice-col mb-15">
                    <div class=" row no-margin">
                        <div class="col-md-6 col-lg-6">Rupees:&nbsp;
                            <?php echo getIndianCurrency($billAmount) ?>
                        </div>
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
<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
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
                    <h4 class="page-title">Registration Receipt</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Registration</li>
                                <li class="breadcrumb-item active" aria-current="page">Receipt</li>
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
                            <h2 class="d-inline"><span class="fs-30">REGISTRATION RECEIPT</span></h2>
                        </center>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <?php
            $opid = $_GET['opid'];
            $rno = $_GET['rno'];

            $sql = "SELECT TOP 1 id, rno, opid, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy, rdoc, dept
            FROM registration 
            WHERE opid = '$opid' AND rno = '$rno'";
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $id = $row['id'];
                $rno = $row['rno'];
                $opid = $row['opid'];
                $fullname = $row['fullname'];
                $rfname = $row['rfname'];
                $doctor = $row['rdoc'];
                $dept = $row['dept'];
                $rdoc = $row['rdoc'];
                $rage = $row['rage'];
                $rsex = $row['rsex'];
                $phone = $row['phone'];
                $wamt = number_format($row['wamt'], 2);
                $rdate = $row['rdate'];
                $rtime = $row['rtime']->format('H:i:s');
            }
            ?>
            <div class="row invoice-info">
                <div class="col-md-12 invoice-col">
                    <!-- <strong>From</strong> -->
                    <address>
                        <strong class="text-blue fs-16">Reg. No :
                            <?php echo $rno; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date : &nbsp; <?php echo $rdate; ?><?php echo $rtime; ?>&nbsp;
                        </strong><br>
                        <strong class="text-blue fs-16">OP No :
                            <?php echo $opid; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CONSULTANT DR. :&nbsp;
                        <?php echo $rdoc; ?>
                        </strong><br>
                        <strong class="text-blue fs-16">Name :
                            <?php echo $fullname; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Mobile: <?php echo $phone; ?>
                        </strong><br>
                        <strong class="text-blue fs-16">Age/Gender :
                            <?php echo $rage; ?> / <?php echo $rsex; ?>
                        </strong><br>
                    </address>
                </div>
                <!-- /.col -->
                <p>Received with thanks from
                    <?php echo $fullname; ?>
                </p>

            </div>
            <hr>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <!-- table-bordered -->
                        <tbody>
                            <tr>
                                <th class="text-end">Sl. No </th>
                                <th class="text-end">Service</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Performed</th>
                                <th class="text-end">Amount(₹)</th>
                            </tr>
                            <tr>
                                <td class="text-end">
                                    <?php echo '1'; ?>
                                </td>
                                <td class="text-end">
                                    <?php echo 'CONSULTATION OPD'; ?>
                                </td>
                                <td class="text-end">
                                    <?php echo '1.00'; ?>
                                </td>
                                <td class="text-end">
                                    
                                    <?php echo $rdoc; ?>
                                </td>
                                <td class="text-end">
                                    ₹
                                    <?php echo $wamt; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- <div class="row">
                <div class="col-12 text-end">
                    <div>
                        <p>Total Paid : ₹
                            <?php echo $wamt; ?>
                        </p>
                    </div>
                </div>
                    E.& O.E. <br> For Rhythm Health Care
            </div> -->
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
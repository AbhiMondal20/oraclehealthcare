<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>

<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-primary"><i class="mdi mdi-wheelchair-accessibility"></i>
                                </h1>
                                <?php
                                $date = date('Y-m-d');
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration where rdate = '$date' and addedBy = '$username'";
                                $stmt = sqlsrv_query($conn, $sql);
                                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                $total = $row['totalRegistrations'];
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>
                                <span class="badge badge-pill badge-primary px-10 mb-10">New OPD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="mdi mdi-wheelchair-accessibility"></i>
                                </h1>
                                <?php
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration WHERE addedBy = '$username'";
                                $stmt = sqlsrv_query($conn, $sql);
                                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                $total = $row['totalRegistrations'];
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>
                                <span class="badge badge-pill badge-success px-10 mb-10">Old OPD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-primary"><i class="mdi mdi-wheelchair-accessibility"></i>
                                </h1>
                                <?php
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration WHERE visitType = 'Re Visit' AND addedBy = '$username'";
                                $stmt = sqlsrv_query($conn, $sql);
                                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                $total = $row['totalRegistrations'];
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>
                                <span class="badge badge-pill badge-primary px-10 mb-10">Revisit</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-rupee-sign"></i></h1>
                                <?php
                                $date = date('Y-m-d');
                                $sql = "SELECT SUM(CONVERT(decimal(18, 2), paidAmount)) AS totallabp 
                                        FROM billingDetails 
                                        WHERE CAST(billdate AS DATE) = '$date' AND uname = '$username'";
                                $stmt = sqlsrv_query($conn, $sql);
                                if ($stmt === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }
                                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                if ($row === false) {
                                    die("No data refuned.");
                                }
                                $totallabp = $row['totallabp'];
                                ?>
                                <!-- Display the total paid amount -->
                                <h2>₹<?php echo $totallabp; ?></h2>
                                <span class="badge badge-pill badge-success px-10 mb-10">Collection</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-primary"><i class="fa-solid fa-prescription"></i>
                                </h1>
                                <?php
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration WHERE uploadPrescription IS NOT NULL AND addedBy = '$username'";
                                $stmt = sqlsrv_query($conn, $sql);
                                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                $total = $row['totalRegistrations'];
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>
                                <span class="badge badge-pill badge-primary px-10 mb-10">Prescription</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
<?php
include ('footer.php');
?>
<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Daily Cash Reports</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Daily Cash Reports</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <section class="content1" style="display:none">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form novalidate method="POST" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Username <span class="text-danger">*</span></h5>
                                            <!-- <input type="text" name="username" placeholder="Reg. No" class="form-control"> -->
                                            <select class="form-select" name="username">
                                                <?php
                                                $sql = "SELECT dUSERNAME FROM dba";
                                                $res = mysqli_query($conn, $sql);
                                                if ($res === false) {
                                                    // Handle SQL error
                                                    die(print_r(mysqli_errors(), true));
                                                }
                                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                                    $username = $row['dUSERNAME'];
                                                    echo "<option value='$username'>$username</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Form Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="from" placeholder="DD-MM-YYYY"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>To Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="to" placeholder="DD-MM-YYYY"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls mt-4">
                                                <h5><span class="text-danger"></span></h5>
                                                <button type="submit" name="search"
                                                    class="btn btn-primary btn-md">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>OP Id</th>
                                        <th>Reg. Date Time.</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Ph. No</th>
                                        <th>Dept.</th>
                                        <th>Doctor</th>
                                        <th>Fee</th>
                                        <th>Payment Type</th>
                                        <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$totalAmount = 0;
$today = date('Y-m-d');
$username = $login_username;

$sql = "SELECT
            id, rno, rdate, rtime, 
            rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, 
            rsex, rage, fname, phone, opid, dept, paymentType,
            radd1, rcity, rdist, wamt, addedBy, rdoc
        FROM 
            registration 
        WHERE 
            addedBy = ? 
            AND DATE(rdate) = ?
        ORDER BY 
            id DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $today);
$result = mysqli_stmt_execute($stmt);

if ($result === false) {
    die("Execute statement failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_result($stmt, $id, $rno, $rdate, $rtime, $rfname, $fullname, $rsex, $rage, $fname, $phone, $opid, $dept, $paymentType, $radd1, $rcity, $rdist, $wamt, $addedBy, $rdoc);

while (mysqli_stmt_fetch($stmt)) {
    $wamt_formatted = number_format($wamt, 2);
    $totalAmount += $wamt;

    ?>
    <tr>
        <td><?php echo $rno; ?></td>
        <td><?php echo $opid; ?></td>
        <td><?php echo $rdate . ' ' . $rtime; ?></td>
        <td><?php echo $fullname; ?> (<?php echo $rage; ?>)</td>
        <td><?php echo $rsex; ?></td>
        <td><?php echo $phone; ?></td>
        <td><?php echo $dept; ?></td>
        <td><?php echo $rdoc; ?></td>
        <td><?php echo $wamt_formatted; ?></td>
        <td><?php echo $paymentType; ?></td>
        <td><?php echo $addedBy; ?></td>
    </tr>
    <?php
}

?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">Total: </td>
                                        <td>
                                            <?php echo number_format($totalAmount, 2); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
</div>

<?php
include ('footer.php');

?>
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
                    <h4 class="page-title">Return Bill</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Return</li>
                                <li class="breadcrumb-item active" aria-current="page">Bill</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <!-- <section class="content1">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form novalidate method="POST" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Payment Type <span class="text-danger">*</span></h5>
                                            <select class="form-select select2" name="paymentType" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Card">Card</option>
                                                <option value="NEFT">NEFT</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Credit">Credit</option>
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
        </section> -->

        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>Bill No</th>
                                        <th>Return Date</th>
                                        <th>Name</th>
                                        <th>Services</th>
                                        <th>Price</th>
                                        <th>Remark</th>
                                        <th>Doctor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$totalAmount = 0;

$sql = "SELECT rb.id, rb.rno, rb.pname, rb.phone, rb.rdocname, rb.billno, rb.billdate, rb.totalPrice, rb.totalAdj, rb.gst, rb.billAmount, rb.paidAmount, rb.balance, rb.status, rb.addedBy, rb.opid, b.servname, b.servrate 
        FROM returnbillingDetails AS rb 
        INNER JOIN returnbilling AS b ON rb.rno = b.rno";

$stmt = mysqli_query($conn, $sql);

if ($stmt === false) {
    die("Error: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $id = $row['id'];
    $rno = $row['rno'];
    $opid = $row['opid'];
    $doctor = $row['rdocname'];
    $billdate = $row['billdate'];
    $billno = $row['billno'];
    $pname = $row['pname'];
    $addedBy = $row['addedBy'];
    $servname = $row['servname'];
    $servrate = $row['servrate']; 
    $remark = $row['status'];
    
    $servrate = floatval($row['servrate']);
    if (is_numeric($row['servrate'])) {
        $totalAmount += $row['servrate'];
    }
    ?>
    <tr>
        <td><?php echo $rno; ?></td>
        <td><?php echo $billno; ?></td>
        <td><?php echo $billdate; ?></td>
        <td><?php echo $pname; ?></td>
        <td><?php echo $servname; ?></td>
        <td><?php echo "₹" . $servrate; ?></td>
        <td><?php echo $remark; ?></td>
        <td><?php echo $doctor; ?></td>
    </tr>
    <?php
}

?>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">Total: </td>
                                        <td><?php echo "₹".number_format($totalAmount, 2); ?></td>
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
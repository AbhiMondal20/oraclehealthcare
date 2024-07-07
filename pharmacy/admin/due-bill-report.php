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
                    <h4 class="page-title">Due Bill</h4>
                    <div class="d-inline-bdock align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Due</li>
                                <li class="breadcrumb-item active" aria-current="page">Bill</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <section class="content1 m-3">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form novalidate method="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Form Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="from" placeholder="DD-MM-YYYY"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>To Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="to" placeholder="DD-MM-YYYY"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                        <div class="tabde-responsive">
                            <?php
                            
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {

                                $fromDate = isset($_POST['from']) ? $_POST['from'] : '';
                                $toDate = isset($_POST['to']) ? $_POST['to'] : '';

                                $sql = "SELECT bd.id, bd.rno, bd.pname, bd.phone, bd.rdocname, bd.billno, bd.billdate, bd.totalPrice, bd.totalAdj, bd.billAmount, bd.paidAmount, bd.balance, bd.status 
                                FROM billingDetails AS bd
                                WHERE bd.billdate BETWEEN $fromDate AND $toDate";
                                $res = mysqli_query($conn, $sql);
                                if ($res === false) {
                                    die("Statement execution failed: " . mysqli_error($conn));
                                }
                            } else {
                                $sql = "SELECT bd.id, bd.rno, bd.pname, bd.phone, bd.rdocname, bd.billno, bd.billdate, bd.totalPrice, bd.totalAdj, bd.billAmount, bd.paidAmount, bd.balance, bd.status FROM billingDetails AS bd";
                                $res = mysqli_query($conn, $sql);
                                if ($res === false) {
                                    die("Statement execution failed: " . mysqli_error($conn));
                                }
                            }

                            ?>
                            <table id="example" class="table table-hover display nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>Bill No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Due Amt.</th>
                                        <th>Remark</th>
                                        <th>Doctor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalAmount = 0;

                                   
                                    while ($rows = mysqli_fetch_assoc($res)) {
                                        
                                        $rno = $rows['rno'];
                                        $billno = $rows['billno'];
                                        $billdate = $rows['billdate'];
                                        $pname = $rows['pname']; 
                                        $balance = $rows['balance'];
                                        $status = $rows['status'];
                                        $rdocname = $rows['rdocname'];
                                        $totalAmount += $balance;
                                        ?>
                                        <tr>
                                            <td><?php echo $rno; ?></td>
                                            <td><?php echo $billno; ?></td>
                                            <td><?php echo $billdate; ?></td>
                                            <td><?php echo $pname; ?></td>
                                            <td><?php echo "₹" . $balance; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><?php echo $rdocname; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total: </td>
                                        <td><?php echo "₹" . $totalAmount; ?></td>
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
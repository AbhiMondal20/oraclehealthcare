<?php
session_start();
if (isset ($_SESSION['login']) && $_SESSION['login'] == true) {
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
                    <h4 class="page-title">Daily Cash Bill</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Report</li>
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
                                                $sql = "SELECT dUSERNAME FROM dba WHERE dUSERNAME = '$login_username'";
                                                $res = sqlsrv_query($conn, $sql);
                                                if ($res === false) {
                                                    // Handle SQL error
                                                    die (print_r(sqlsrv_errors(), true));
                                                }
                                                while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
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
                                        <th>Bill No</th>
                                        <th>Billing Date</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Services</th>
                                        <th>Price</th>
                                        <th>Username</th>
                                        <th>Doctor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $today = date('Y-m-d');
                                    $totalAmount = 0;

                                    // Check if the form is submitted (if needed)
                                    // if (isset($_POST['search'])) {
                                    //     $username = $_POST['username'];
                                    //     $to = $_POST['to'];
                                    //     $from = $_POST['from'];
                                    
                                    // Prepare and execute SQL query
                                    $sql = "SELECT
                                                r.id, r.rno, r.rdate, r.rtime, b.pname AS fullname, 
                                                r.rsex, r.rage, b.uname, r.rdoc, b.billdate, b.billno, b.servname, b.servrate, b.uname
                                            FROM 
                                                registration AS r
                                            INNER JOIN billing AS b ON r.rno = b.rno
                                            WHERE 
                                                b.uname = ? 
                                                AND b.billdate = ? 
                                            ORDER BY 
                                                id DESC";
                                    $params = array($login_username, $today);
                                    $stmt = sqlsrv_query($conn, $sql, $params);
                                    
                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }
                                    
                                    // Fetch and display data
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        $rno = $row['rno'];
                                        $id = $row['id'];
                                        $doctor = $row['rdoc'];
                                        $billdate = $row['billdate'];
                                        $billno = $row['billno'];
                                        $fullname = $row['fullname'];
                                        $sex = $row['rsex'];
                                        $age = $row['rage'];
                                        $uname = $row['uname'];
                                        $servname = $row['servname'];
                                        
                                        // Convert servrate to float
                                        $servrate = floatval($row['servrate']);
                                    
                                        // Check if servrate is numeric and update totalAmount
                                        if (is_numeric($row['servrate'])) {
                                            $totalAmount += $row['servrate'];
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $rno; ?></td>
                                            <td><?php echo $billno; ?></td>
                                            <td><?php echo $billdate; ?></td>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php echo $age; ?></td>
                                            <td><?php echo $servname; ?></td>
                                            <td><?php echo $servrate; ?></td>
                                            <td><?php echo $uname; ?></td>
                                            <td><?php echo $doctor; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">Total: </td>
                                    <td><?php echo number_format($totalAmount, 2); ?></td>
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
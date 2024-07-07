<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$srno = $_GET['srno'];

// Prepare the SQL query
$sql = "SELECT srno, docName, sp, fee, docregno, dept FROM docmaster WHERE srno = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {
    die("Error preparing statement: " . mysqli_error($conn));
}

// Bind the parameter
mysqli_stmt_bind_param($stmt, 'i', $srno);

// Execute the statement
if (mysqli_stmt_execute($stmt) === false) {
    die("Error executing statement: " . mysqli_stmt_error($stmt));
}

// Bind the result variables
mysqli_stmt_bind_result($stmt, $srno, $docName, $sp, $fee, $docregno, $dept);

// Fetch the results
if (mysqli_stmt_fetch($stmt)) {
    $fee = floatval($fee);  // Ensure $fee is treated as a float
    $fee = number_format($fee, 2);
} else {
    die("No data found for srno: " . $srno);
}

// Close the statement
mysqli_stmt_close($stmt);
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Update Doctor Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Doctor</li>
                                <li class="breadcrumb-item active" aria-current="page">Master</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <!-- Basic Forms -->
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form novalidate method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Department<span class="text-danger">*</span></h5>
                                            <input list="deptlist" name="dept" id="dept" tabindex="9" value="<?php echo $dept; ?>"
                                                onchange="getDeptDoctors(this.value)" class="form-control">
                                            <datalist id="deptlist">
                                                <option selected disabled>Select City</option>
                                                <?php
                                                $sql = "SELECT dept FROM deptmaster";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                } else {
                                                    while ($row = mysqli_fetch_array($stmt)) {
                                                        $dept = $row['dept'];
                                                        echo '<option value="' . $dept . '">' . $dept . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Doctor Reg. No.<span class="text-danger">*</span></h5>
                                            <input type="text" name="docregno" placeholder="" class="form-control"
                                                required value="<?php echo $docregno; ?>"
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Doctor Name<span class="text-danger">*</span></h5>
                                            <input type="text" name="docName" placeholder="" class="form-control"
                                                required value="<?php echo $docName; ?>"
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Speciality<span class="text-danger">*</span></h5>
                                            <input type="text" name="sp" placeholder="" class="form-control" required
                                                value="<?php echo $sp; ?>"
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Fees <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="fee" placeholder="" class="form-control"
                                                    required value="<?php echo $fee; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <center>
                        <div class="text-xs-right">
                            <button type="submit" class="btn btn-info" name="save">UPDATE</button>
                        </div>
                    </center>
                    </form>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

</section>
<!-- /.content -->
</div>
</div>
<!-- /.content-wrapper -->


<?php
if (isset($_POST['save'])) {
    $dept = $_POST['dept'];
    $docregno = $_POST['docregno'];
    $docName = $_POST['docName'];
    $sp = $_POST['sp'];
    $fee = $_POST['fee'];
    $modify_date = date('Y-m-d H:i:s');

    $sql = "UPDATE docmaster 
        SET dept = '$dept', 
            docregno = '$docregno', 
            docName = '$docName', 
            sp = '$sp', 
            fee = '$fee', 
            modified_by = '$login_username',
            modified_date = '$modify_date'
        WHERE srno = '$srno'";

    $stmt = mysqli_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(mysqli_errors(), true));
    } else {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "doctor-master";
                }, 1000);
            </script>';
    }
}



include ('footer.php');

?>
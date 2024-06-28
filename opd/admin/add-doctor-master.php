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
                    <h4 class="page-title"><a href="javascript:void()" onclick="goBack()">Doctor Master</a></h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void()" onclick="goBack()"><i
                                            class="mdi mdi-home-outline"></i></a>
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
                                            <input list="deptlist" name="dept" id="dept" tabindex="9"
                                                onchange="getDeptDoctors(this.value)" class="form-control">
                                            <datalist id="deptlist">
                                                <option selected disabled>Select City</option>
                                                <?php
                                                $sql = "SELECT dept FROM deptmaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
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
                                            <h5>Doctor Reg. No.</h5>
                                            <input type="text" name="docregno" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Doctor Name<span class="text-danger">*</span></h5>
                                            <input type="text" name="docName" placeholder="" class="form-control"
                                                required data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Speciality<span class="text-danger">*</span></h5>
                                            <input type="text" name="sp" placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Fees <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="fee" placeholder="" class="form-control"
                                                    required data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <center>
                        <div class="text-xs-right">
                            <button type="submit" class="btn btn-info" name="save">SAVE</button>
                        </div>
                    </center>
                    </form>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.box -->
        <!-- upload CSV -->
        <section class="content">
            <!-- Basic Forms -->
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h5>Doctor (Upload CSV File)<span
                                                    class="text-danger">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="load/get_Doctor_CSV_file.php" Download>
                                                    <i class="fa-solid fa-download"></i> Download Format</a>
                                            </h5>
                                            <input type="file" name="docName" placeholder="Upload CSV File"
                                                class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="uploadCSV">SAVE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
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
    // $modify_date = date('Y-m-d H:i:s');

    // Check if the docName already exists
    $check_sql = "SELECT COUNT(*) AS count FROM docmaster WHERE docName = ? AND dept =?";
    $check_params = array($docName, $dept);
    $check_stmt = sqlsrv_query($conn, $check_sql, $check_params);
    if ($check_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);
    $count = $row['count'];

    if ($count > 0) {
        // docName already exists, display alert
        echo '<script>
                swal("Error", "The doctor name already exists!", "error");
              </script>';
    } else {
        // Insert the new docName
        $sql = "INSERT INTO docmaster (dept, docregno, docName, sp, fee, addedBy) VALUES (?, ?, ?, ?, ?, ?)";
        $params = array($dept, $docregno, $docName, $sp, $fee, $login_username);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            // Insert successful, display success message
            echo '<script>
                    swal("Success!", "Doctor added successfully.", "success");
                    setTimeout(function(){
                        window.location.href = window.location.href;
                    }, 1000);
                  </script>';
        }
    }
}


// CSV Upload 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploadCSV"])) {
    if (isset($_FILES["docName"]) && $_FILES["docName"]["error"] == UPLOAD_ERR_OK) {
        $csvFile = $_FILES["docName"]["tmp_name"];
        $fileHandle = fopen($csvFile, "r");
        fgetcsv($fileHandle);

        $sql_insert = "INSERT INTO docmaster (dept, docregno, docName, sp, fee, addedBy) VALUES (?, ?, ?, ?, ?, ?)";
        $sql_update = "UPDATE docmaster SET dept = ?, docregno = ?, sp = ?, fee = ? WHERE docName = ?";
        $stmt_insert = sqlsrv_prepare($conn, $sql_insert, array(&$dept, &$docregno, &$docName, &$sp, &$fee, &$addedBy));
        $stmt_update = sqlsrv_prepare($conn, $sql_update, array(&$dept, &$docregno, &$sp, &$fee, &$addedBy, &$docName));
        $addedBy = $login_username;

        while (($data = fgetcsv($fileHandle, 1000, ",")) !== false) {
            $dept = $data[0];
            $docregno = $data[1];
            $docName = $data[2];
            $sp = $data[3];
            $fee = $data[4];

            $check_sql = "SELECT docName FROM docmaster WHERE docName = ?";
            $check_stmt = sqlsrv_prepare($conn, $check_sql, array(&$docName));
            if (!sqlsrv_execute($check_stmt)) {
                echo '<script>
                        swal("Error!", "Error checking doctor: ' . sqlsrv_errors()[0]['message'] . '", "error");
                    </script>';
                die();
            }

            sqlsrv_fetch($check_stmt);
            $exists = sqlsrv_has_rows($check_stmt);

            if ($exists) {
                if (!sqlsrv_execute($stmt_update)) {
                    echo '<script>
                            swal("Error!", "Error updating doctor: ' . sqlsrv_errors()[0]['message'] . '", "error");
                        </script>';
                    die();
                }
            } else {
                if (!sqlsrv_execute($stmt_insert)) {
                    echo '<script>
                            swal("Error!", "Error inserting doctor: ' . sqlsrv_errors()[0]['message'] . '", "error");
                        </script>';
                    die();
                }
            }
        }
        fclose($fileHandle);
        sqlsrv_close($conn);
        echo '<script>
                swal("Success!", "Data inserted successfully", "success");
            </script>';
    } else {
        echo '<script>
                swal("Error!", "No file uploaded!", "error");
            </script>';
    }
}

include ('footer.php');
?>
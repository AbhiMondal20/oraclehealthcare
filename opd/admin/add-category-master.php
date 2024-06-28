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
                    <h4 class="page-title"><a href="javascript:void()" onclick="goBack()">Category Master</a></h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void()" onclick="goBack()"><i
                                            class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Category</li>
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
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h5>Category<span class="text-danger">*</span></h5>
                                            <input type="text" name="cate" placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="save">SAVE</button>
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
                                            <h5>Category (Upload CSV File)<span
                                                    class="text-danger">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="load/get_CATE_CSV_file.php" Download>
                                                    <i class="fa-solid fa-download"></i> Download Format</a>
                                            </h5>
                                            <input type="file" name="cate" placeholder="Upload CSV File"
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
    </div>
</div>
<!-- /.content-wrapper -->


<?php
    if (isset($_POST['save'])) {
        $cate = $_POST['cate'];
        $addedBy = $login_username;
        // Check if the Category already exists
        $check_sql = "SELECT COUNT(*) AS count FROM catemaster WHERE cate = '$cate'";
        $check_stmt = sqlsrv_query($conn, $check_sql);
        if ($check_stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $row = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);
        $cate_count = $row['count'];
        if ($cate_count > 0) {
            // Category already exists, display alert
            echo '<script>
                    swal("Alert", "Category already exists!", "warning");
                </script>';
        } else {
            // Category does not exist, proceed with insertion
            $sql = "INSERT INTO catemaster (cate, addedBy) VALUES ('$cate', '$addedBy')";
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                echo '<script>
                        swal("Success!", "", "success");
                    </script>';
            }
        }
    }

    // CSV Upload 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploadCSV"])) {
        if (isset($_FILES["cate"]) && $_FILES["cate"]["error"] == UPLOAD_ERR_OK) {
            $csvFile = $_FILES["cate"]["tmp_name"];
            $fileHandle = fopen($csvFile, "r");
            fgetcsv($fileHandle);
            
            // Prepare SQL statement for insertion or update
            $sql_insert = "INSERT INTO catemaster (cate, addedBy) VALUES (?, ?)";
            $sql_update = "UPDATE catemaster SET addedBy = ? WHERE cate = ?";
            $stmt_insert = sqlsrv_prepare($conn, $sql_insert, array(&$cate, &$addedBy));
            $stmt_update = sqlsrv_prepare($conn, $sql_update, array(&$addedBy, &$cate));
            $addedBy = $login_username;
            
            while (($data = fgetcsv($fileHandle, 1000, ",")) !== false) {
                $cate = $data[0];
                
                // Check if Category already exists in the database
                $check_sql = "SELECT cate FROM catemaster WHERE cate = ?";
                $check_stmt = sqlsrv_prepare($conn, $check_sql, array(&$cate));
                if (!sqlsrv_execute($check_stmt)) {
                    echo "Error checking Category.\n";
                    die(print_r(sqlsrv_errors(), true));
                }
                
                if (sqlsrv_has_rows($check_stmt)) {
                    // Category exists, update it
                    if (!sqlsrv_execute($stmt_update)) {
                        echo "Error updating Category.\n";
                        die(print_r(sqlsrv_errors(), true));
                    }
                } else {
                    // Category does not exist, insert it
                    if (!sqlsrv_execute($stmt_insert)) {
                        echo "Error inserting Category.\n";
                        die(print_r(sqlsrv_errors(), true));
                    }
                }
            }
            
            fclose($fileHandle);
            sqlsrv_close($conn);
            echo '<script>
                    swal("Success!", "", "success");
                </script>';
        } else {
            echo '<script>
                    swal("No file uploaded.!", "", "error");
                </script>';
        }
    }

    include ('footer.php');
?>
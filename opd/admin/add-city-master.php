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
                    <h4 class="page-title">City Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">City</li>
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
                            <form novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Country<span class="text-danger">*</span></h5>
                                            <input type="text" name="country" placeholder="" class="form-control"
                                                required data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>State<span class="text-danger">*</span></h5>
                                            <input type="text" name="state" placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Distric<span class="text-danger">*</span></h5>
                                            <input type="text" name="dist" placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>City<span class="text-danger">*</span></h5>
                                            <input type="text" name="Cityname" placeholder="" class="form-control"
                                                required data-validation-required-message="This field is required">
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
                                            <h5>City Master (Upload CSV File)<span
                                                    class="text-danger">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="load/get_CITY_CSV_file.php" Download>
                                                    <i class="fa-solid fa-download"></i> Download Format</a>
                                            </h5>
                                            <input type="file" name="CitynameUpload" placeholder="Upload CSV File"
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
    $Cityname = isset($_POST['Cityname']) ? $_POST['Cityname'] : '';
    $dist = isset($_POST['dist']) ? $_POST['dist'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $username = $login_username;
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO citymaster (Cityname, distname, state, country, added_by) VALUES (?, ?, ?, ?, ?)";
    $params = array($Cityname, $dist, $state, $country, $username);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>';
    }
}

// CSV Upload 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploadCSV"])) {
    if (isset($_FILES["CitynameUpload"]) && $_FILES["CitynameUpload"]["error"] == UPLOAD_ERR_OK) {
        $csvFile = $_FILES["CitynameUpload"]["tmp_name"];
        $fileHandle = fopen($csvFile, "r");
        fgetcsv($fileHandle);

        $sql_insert = "INSERT INTO citymaster (Cityname, distname, state, country, added_by) VALUES (?, ?, ?, ?, ?)";
        $sql_update = "UPDATE citymaster SET distname = ?, state = ?, country = ? WHERE Cityname = ?";
        $stmt_insert = sqlsrv_prepare($conn, $sql_insert, array(&$Cityname, &$distname, &$state, &$country, &$addedBy));
        $stmt_update = sqlsrv_prepare($conn, $sql_update, array(&$distname, &$state, &$country, &$Cityname));
        $addedBy = $login_username;

        while (($data = fgetcsv($fileHandle, 10000, ",")) !== false) {
            $Cityname = $data[0];
            $distname = $data[1];
            $state = $data[2];
            $country = $data[3];

            $check_sql = "SELECT Cityname FROM citymaster WHERE Cityname = ?";
            $check_stmt = sqlsrv_prepare($conn, $check_sql, array(&$Cityname));
            if (!sqlsrv_execute($check_stmt)) {
                echo '<script>
                        swal("Error!", "Error checking city: ' . sqlsrv_errors()[0]['message'] . '", "error");
                    </script>';
                die();
            }

            sqlsrv_fetch($check_stmt);
            $exists = sqlsrv_has_rows($check_stmt);

            if ($exists) {
                if (!sqlsrv_execute($stmt_update)) {
                    echo '<script>
                            swal("Error!", "Error updating city: ' . sqlsrv_errors()[0]['message'] . '", "error");
                        </script>';
                    die();
                }
            } else {
                if (!sqlsrv_execute($stmt_insert)) {
                    echo '<script>
                            swal("Error!", "Error inserting city: ' . sqlsrv_errors()[0]['message'] . '", "error");
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
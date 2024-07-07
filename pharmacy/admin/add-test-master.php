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
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Test Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Test</li>
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
                <div class="box-body" style="max-height: 500px; overflow-x: auto;">
                    <div class="row">
                        <div class="col">
                            <form novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Code</h5>
                                            <div class="controls">
                                                <?php
                                                $sql = "SELECT code FROM servmaster ORDER BY srno DESC LIMIT 1";
                                                $result = mysqli_query($conn, $sql);

                                                // Error handling
                                                if (!$result) {
                                                    die("Query failed: " . mysqli_error($conn));
                                                } else {
                                                    // Default value for the next code
                                                    $next_code = "000001";

                                                    // Check if there are rows in the result set
                                                    if (mysqli_num_rows($result) > 0) {
                                                        // Fetch the last code
                                                        $row = mysqli_fetch_assoc($result);
                                                        $last_code = $row['code'];

                                                        // Generate the next code if the last code is not empty
                                                        if (!empty($last_code)) {
                                                            $last_number = intval(substr($last_code, 2));
                                                            $next_number = $last_number + 1;
                                                            $next_code = str_pad($next_number, 6, "0", STR_PAD_LEFT);
                                                        }
                                                    }
                                                }
                                                ?>
                                                <input type="text" name="code" placeholder="000001" class="form-control"
                                                    required value="<?php echo htmlspecialchars($next_code); ?>"
                                                    readonly data-validation-required-message="This field is required">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Department<span class="text-danger">*</span></h5>
                                            <input list="deptlist" name="dept" class="form-control" required>
                                            <datalist id="deptlist">
                                                <?php

                                                $sql = "SELECT dept FROM deptmaster";
                                                $stmt = mysqli_query($conn, $sql);

                                                // Error handling
                                                if ($stmt === false) {
                                                    die("Query failed: " . mysqli_error($conn));
                                                } else {
                                                    // Fetch and display departments in the datalist
                                                    while ($row = mysqli_fetch_assoc($stmt)) {
                                                        $dept = htmlspecialchars($row['dept']);
                                                        echo '<option value="' . $dept . '">' . $dept . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Modality</h5>
                                            <input type="text" name="modality" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Test Name<span class="text-danger">*</span></h5>
                                            <input type="text" name="servname" placeholder="" class="form-control"
                                                required data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display:none;">
                                        <div class="form-group">
                                            <h5>Price</h5>
                                            <input type="text" name="servrate0" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>status<span class="text-danger">*</span></h5>
                                            <select name="ServFlag" class="form-control" required>
                                                <option value="Y">Active</option>
                                                <option value="N">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <hr>
                                        <h2>CATEGORY:</h2>
                                        <?php
                                        $sno = 0;
                                        $sql = "SELECT id, cate FROM catemaster";
                                        $stmt = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($stmt)) {
                                            $id = $row['id'];
                                            $cate = $row['cate'];
                                            $sno = $sno + 1;
                                            ?>
                                            <div class="form-group row">
                                                <label class="col-form-label col-md-2"><?php echo $sno; ?>.</label>
                                                <label class="col-form-label col-md-2"><?php echo $cate; ?></label>
                                                <input class="form-control col-md-2" type="hidden" name="cate[]"
                                                    value="<?php echo $cate; ?>">
                                                <div class="col-md-8">
                                                    <input class="form-control" type="text" name="cateVal[]">
                                                </div>
                                            </div>
                                        <?php } ?>
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
                                            <h5>Test Category (Upload CSV File)<span
                                                    class="text-danger">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="load/get_Test_CSV_file.php" Download>
                                                    <i class="fa-solid fa-download"></i> Download Format</a>
                                            </h5>
                                            <input type="file" name="testName" placeholder="Upload CSV File"
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

<!-- insert data -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {

    $sql = "INSERT INTO servmaster (dept, modality, servname, ServFlag, added_by, cateVal, cate, code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Statement preparation failed: " . mysqli_error($conn));
    }

    $success = true;
    foreach ($_POST['cateVal'] as $i => $cateVal) {
        if (!empty($cateVal)) {
            $date = date('Y-m-d H:i:s');
            $dept = isset($_POST['dept']) ? $_POST['dept'] : '';
            $code = isset($_POST['code']) ? $_POST['code'] : '';
            $cate = isset($_POST['cate'][$i]) ? $_POST['cate'][$i] : '';
            $servname = isset($_POST['servname']) ? $_POST['servname'] : '';
            $added_by = $login_username;
            $modality = isset($_POST['modality']) ? $_POST['modality'] : '';
            $ServFlag = isset($_POST['ServFlag']) ? $_POST['ServFlag'] : '';

            // Bind the parameters to the SQL query
            mysqli_stmt_bind_param($stmt, 'ssssssss', $dept, $modality, $servname, $ServFlag, $added_by, $cateVal, $cate, $code);

            // Execute the prepared statement
            if (!mysqli_stmt_execute($stmt)) {
                $success = false;
                die("Statement execution failed: " . mysqli_stmt_error($stmt));
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    if ($success) {
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
    // Check if a file was uploaded and if there were no errors
    if (isset($_FILES["testName"]) && $_FILES["testName"]["error"] == UPLOAD_ERR_OK) {
        $csvFile = $_FILES["testName"]["tmp_name"];
        $fileHandle = fopen($csvFile, "r");

        // Skip the header row
        fgetcsv($fileHandle);

        // Prepare the SQL statement for inserting data into the servmaster table
        $sql_insert = "INSERT INTO servmaster (dept, modality, servname, ServFlag, cate, cateVal, code, added_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        if (!$stmt_insert) {
            die("Statement preparation failed: " . mysqli_error($conn));
        }

        // Get the username of the currently logged-in user
        $added_by = $login_username;

        // Loop through each row in the CSV file
        while (($data = fgetcsv($fileHandle, 1000, ",")) !== false) {
            $dept = $data[0];
            $modality = $data[1];
            $servname = $data[2];
            $ServFlag = $data[3];
            $cate = $data[4];
            $cateVal = $data[5];
            $code = $data[6];

            // Bind the parameters to the SQL query
            mysqli_stmt_bind_param($stmt_insert, 'ssssssss', $dept, $modality, $servname, $ServFlag, $cate, $cateVal, $code, $added_by);

            // Execute the SQL insert statement
            if (!mysqli_stmt_execute($stmt_insert)) {
                echo '<script>
                        swal("Error!", "Error inserting data: ' . mysqli_stmt_error($stmt_insert) . '", "error");
                    </script>';
                die();
            }
        }

        // Close the file handle and the prepared statement
        fclose($fileHandle);
        mysqli_stmt_close($stmt_insert);

        // Close the database connection
        mysqli_close($conn);

        // Success message
        echo '<script>
                swal("Success!", "Data inserted successfully.", "success");
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>';
    } else {
        echo '<script>
                swal("Error!", "Failed to upload file.", "error");
            </script>';
    }
}


include ('footer.php');
?>
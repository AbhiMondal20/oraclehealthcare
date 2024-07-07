<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include 'header.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $sql = "SELECT srno, dept, modality, servname, servrate, ServFlag, cateVal, cate
            FROM servmaster
            WHERE code = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die('MySQLi prepare error: ' . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 's', $code);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $srno, $dept, $modality, $servname, $servrate, $ServFlag, $cateVal, $cate);

        // Initialize an empty array for cateVal
        $cateValArray = array();

        // Fetch values
        while (mysqli_stmt_fetch($stmt)) {
            // Process fetched data
            $servrate = number_format($servrate, 2);

            // Collect cateVal into an array
            $cateValArray[] = array(
                'cate' => $cate,
                'value' => $cateVal,
            );

            // Example of using fetched values
            $updatedept = $dept;
            $cateServ = $cate;
            // Do further processing here if needed
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle execution error
        die('MySQLi execute error: ' . mysqli_error($conn));
    }
} else {
    die('No code parameter found in GET request');
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Update Test Master</h4>
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
                <div class="box-body">
                    <form novalidate method="POST" enctype="multipart/form-data">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Code</h5>
                                        <div class="controls">
                                            <input type="text" name="code" placeholder="000001" class="form-control"
                                                required value="<?php echo $code; ?>" readonly
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Department<span class="text-danger">*</span></h5>
                                        <input list="deptlist" name="dept" class="form-control"
                                            value="<?php echo $dept; ?>">
                                        <datalist id="deptlist">
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
                                        <h5>Modality</h5>
                                        <input type="text" name="modality" class="form-control"
                                            value="<?php echo $modality; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Test Name<span class="text-danger">*</span></h5>
                                        <input type="text" name="servname" placeholder="" class="form-control"
                                            value="<?php echo $servname; ?>" required
                                            data-validation-required-message="This field is required">
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
                                    if ($stmt === false) {
                                        die('MySQL error: ' . mysqli_error($conn));
                                    }
                                    while ($row = mysqli_fetch_array($stmt)) {
                                        $sno++;
                                        $id = $row['id'];
                                        $cate = $row['cate'];
                                        $value = '';
                                        foreach ($cateValArray as $item) {
                                            if ($item['cate'] === $cate) {
                                                $value = $item['value'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-2"><?php echo $sno; ?>.</label>
                                            <label class="col-form-label col-md-2"><?php echo $cate; ?></label>
                                            <input class="form-control col-md-2" type="hidden" name="cate[]"
                                                value="<?php echo $cate; ?>">
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="cateVal[]"
                                                    value="<?php echo $value; ?>">
                                            </div>
                                        </div>
                                        <?php
                                    } ?>
                                </div>

                            </div>
                        </div>
                </div>
                <center>
                    <div class="text-xs-right">
                        <button type="submit" class="btn btn-info m-4" name="save">SAVE</button>
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
 
    $success = true;

    // Loop through each row of data to process
    foreach ($_POST['cateVal'] as $i => $cateVal) {
        if (!empty($cateVal)) {
            // Assign values from $_POST or set default values as needed
            $dept = isset($_POST['dept']) ? $_POST['dept'] : '';
            $code = isset($_POST['code']) ? $_POST['code'] : '';
            $cate = isset($_POST['cate'][$i]) ? $_POST['cate'][$i] : '';
            $servname = isset($_POST['servname']) ? $_POST['servname'] : '';
            $modality = isset($_POST['modality']) ? $_POST['modality'] : '';
            $ServFlag = isset($_POST['ServFlag']) ? $_POST['ServFlag'] : '';
            $added_by = $login_username;

            // Prepare the data for insertion or update
            $sql = "INSERT INTO servmaster (dept, code, modality, servname, ServFlag, cate, cateVal)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                    modality = VALUES(modality),
                    servname = VALUES(servname),
                    ServFlag = VALUES(ServFlag),
                    cateVal = VALUES(cateVal)";

            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                $success = false;
                echo "Statement preparation failed: " . mysqli_error($conn);
                break; // Exit loop if preparation fails
            }

            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'sssssss', $dept, $code, $modality, $servname, $ServFlag, $cate, $cateVal);

            // Execute the statement
            if (!mysqli_stmt_execute($stmt)) {
                $success = false;
                echo "Statement execution failed: " . mysqli_stmt_error($stmt);
                break; // Exit loop if execution fails
            }

            mysqli_stmt_close($stmt); // Close statement
        }
    }

    mysqli_close($conn); // Close connection

    // Display success message and refresh page if successful
    if ($success) {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>';
    }
}


include 'footer.php';
?>
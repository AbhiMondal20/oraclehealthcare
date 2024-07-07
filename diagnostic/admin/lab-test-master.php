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
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Lab Test Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Lab Test</li>
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
                                            <h5>Modality<span class="text-danger">*</span></h5>
                                            <select name="modality" class="form-control select2" required
                                                data-validation-required-message="This field is required">
                                                <option disabled selected>select</option>
                                                <?php
                                                $sql = "SELECT modality FROM servmaster WHERE modality IS NOT NULL GROUP BY modality";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                }
                                                while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                                    $modality = $row['modality'];
                                                    echo "<option value='$modality'>" . $modality . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Test Head<span class="text-danger">*</span></h5>
                                            <input type="text" name="test" placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Subtest<span class="text-danger">*</span></h5>
                                            <input type="text" name="subtest" placeholder="" class="form-control"
                                                required data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Unit</h5>
                                            <input type="text" name="unit" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Normal Range</h5>
                                            <input type="text" name="normrang" placeholder="" class="form-control">
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
                                                <a href="upload/DoctorFormat.csv" Download>
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
    $modality = $_POST['modality'];
    $test = $_POST['test'];
    $subtest = $_POST['subtest'];
    $unit = $_POST['unit'];
    $normrang = $_POST['normrang'];
    $addedBy = $login_username;

    // Check if the subtest already exists
    $check_sql = "SELECT COUNT(*) AS count FROM pathomaster WHERE modality = ? AND test = ? AND subtest = ?";
    $check_stmt = $conn->prepare($check_sql);
    if ($check_stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $check_stmt->bind_param("sss", $modality, $test, $subtest);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        // Subtest already exists, display alert
        echo '<script>
                swal("Error", "The Subtest already exists!", "error");
              </script>';
    } else {
        // Insert the new subtest
        $sql = "INSERT INTO pathomaster (modality, test, subtest, unit, normrang, addedby) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ssssss", $modality, $test, $subtest, $unit, $normrang, $addedBy);
        if ($stmt->execute()) {
            echo '<script>
                    swal("Success!", "Subtest added successfully.", "success");
                    setTimeout(function(){
                        window.location.href = window.location.href;
                    }, 1000);
                  </script>';
        } else {
            die("Error executing statement: " . $stmt->error);
        }
        $stmt->close();
    }
}


// CSV Upload 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploadCSV"])) {
    if (isset($_FILES["docName"]) && $_FILES["docName"]["error"] == UPLOAD_ERR_OK) {
        $csvFile = $_FILES["docName"]["tmp_name"];
        $fileHandle = fopen($csvFile, "r");
        fgetcsv($fileHandle); // Skip the header row

        $sql = "INSERT INTO docmaster (docName, sp, fee, docregno, dept, addedBy) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ssssss", $docName, $sp, $fee, $docregno, $dept, $addedBy);

        $addedBy = $login_username;

        while (($data = fgetcsv($fileHandle, 1000, ",")) !== false) {
            $docName = $data[0];
            $sp = $data[1];
            $fee = $data[2];
            $docregno = $data[3];
            $dept = $data[4];

            if (!$stmt->execute()) {
                echo "Error inserting data: " . $stmt->error . "\n";
                die();
            }
        }

        fclose($fileHandle);
        $stmt->close();
        $conn->close();

        echo '<script>
                swal("Success!", "Data has been successfully uploaded.", "success");
            </script>';
    } else {
        echo '<script>
                swal("No file uploaded!", "Please upload a valid CSV file.", "error");
            </script>';
    }
}

include ('footer.php');

?>
<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$code = $_GET['code'];
$sql = "SELECT srno, dept, modality, servname, servrate, ServFlag, cateVal, cate FROM servmaster WHERE code = ?";
$params = array($code);
$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$cateVal = array();

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $srno = $row['srno'];
    $servname = $row['servname'];
    $servrate = number_format($row['servrate'], 2);
    $updatedept = $row['dept'];
    $modality = $row['modality'];
    $ServFlag = $row['ServFlag'];
    $dept = $row['dept'];

    $cateVal[] = array(
        'cate' => $row['cate'],
        'value' => $row['cateVal']
    );

    $cateServ = $row['cate'];
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
                                    $stmt = sqlsrv_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        $sno++;
                                        $id = $row['id'];
                                        // $cate = $row['cate'];
                                        $value = '';
                                        foreach ($cateVal as $item) {
                                            if ($item['cate'] === $row['cate']) {
                                                $value = $item['value'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-2"><?php echo $sno; ?>.</label>
                                            <label class="col-form-label col-md-2"><?php echo $row['cate']; ?></label>
                                            <input class="form-control col-md-2" type="hidden" name="cate[]"
                                                value="<?php echo $row['cate']; ?>">
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="cateVal[]"
                                                    value="<?php echo $value; ?>">
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
    $sql = "MERGE INTO servmaster AS target
            USING (VALUES (?, ?, ?, ?, ?, ?, ?)) AS source (dept, code, modality, servname, ServFlag, cate, cateVal)
            ON target.cate = source.cate
            WHEN MATCHED THEN
                UPDATE SET target.cateVal = source.cateVal
            WHEN NOT MATCHED THEN
                INSERT (dept, code, modality, servname, ServFlag, cate, cateVal)
                VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = sqlsrv_prepare($conn, $sql, array(
    &
        $dept,
    &
        $code,
    &
        $modality,
    &
        $servname,
    &
        $ServFlag,
    &
        $cate,
    &
        $cateVal,
    &
        $dept,
    &
        $code,
    &
        $modality,
    &
        $servname,
    &
        $ServFlag,
    &
        $cate,
    &
        $cateVal
    )
    );

    if ($stmt === false) {
        die("Statement preparation failed: " . print_r(sqlsrv_errors(), true));
    }

    $success = true;
    foreach ($_POST['cateVal'] as $i => $cateVal) {
        if (!empty($cateVal)) {
            $dept = isset($_POST['dept']) ? $_POST['dept'] : '';
            $code = isset($_POST['code']) ? $_POST['code'] : '';
            $cate = isset($_POST['cate'][$i]) ? $_POST['cate'][$i] : '';
            $servname = isset($_POST['servname']) ? $_POST['servname'] : '';
            $modality = isset($_POST['modality']) ? $_POST['modality'] : '';
            $ServFlag = isset($_POST['ServFlag']) ? $_POST['ServFlag'] : '';
            $added_by = $login_username;
            $modify_by = $login_username;
            if (!sqlsrv_execute($stmt)) {
                $success = false;
                die("Statement execution failed: " . print_r(sqlsrv_errors(), true));
            }
        }
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    if ($success) {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>';
    }
}

include ('footer.php');
?>
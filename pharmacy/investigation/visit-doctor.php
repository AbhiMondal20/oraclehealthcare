<?php
session_start();
if (isset ($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}

include ('header.php');

$id = $_GET['id'];
$rno = $_GET['rno'];
$sql = "SELECT id, rno, rdate, rtime, rstatus,rtitle, se, rdoc, rfname, rmname, rlname, fname, rsex, rage, fname, rrace, radd1, radd2, rcity, rdist, rstate, rcountry, wamt
FROM registration WHERE rno = '$rno' AND id = '$id'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die (print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $rstatus = $row['rstatus'];
    $rno = $row['rno'];
    $rdate = $row['rdate']->format('Y-m-d');
    ;
    $rtitle = $row['rtitle'];
    $rtime = $row['rtime'];
    $se = $row['se'];
    $rfname = $row['rfname'];
    $rmname = $row['rmname'];
    $rlname = $row['rlname'];
    $fname = $row['fname'];
    $rsex = $row['rsex'];
    $rage = $row['rage'];
    $fname = $row['fname'];
    $rrace = $row['rrace'];
    $radd1 = $row['radd1'];
    $radd2 = $row['radd2'];
    $rcity = $row['rcity'];
    $rdoc = $row['rdoc'];
    $rdist = $row['rdist'];
    $rstate = $row['rstate'];
    $rcountry = $row['rcountry'];
    $wamt = number_format($row['wamt'], 2);


}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Visit Doctor</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="reg-list"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Visit</li>
                                <li class="breadcrumb-item active" aria-current="page">Doctor</li>
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
                            <form novalidate method="POST" action="">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>OPD / IPD <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="rstatus">
                                                <option value="OPD" <?php if ($rstatus == 'OPD')
                                                    echo ' selected'; ?>>OPD
                                                </option>
                                                <option value="IPD" <?php if ($rstatus == 'IPD')
                                                    echo ' selected'; ?>>IPD
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Reg. No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="rno" placeholder="237495" class="form-control"
                                                    required value="<?php echo $rno; ?>" readonly
                                                    data-validation-required-message="This field is required">


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5> <span class="text-danger">*</span></h5>
                                                <input type="text" name="se" class="form-control"
                                                    placeholder="2024-2025" required value="<?php echo $se; ?>" readonly
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Reg. Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" value="<?php echo $rdate; ?>" class="form-control"
                                                    required name="rdate"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Salutation <span class="text-danger">*</span></h5>
                                            <select class="form-select select2" name="rtitle">
                                                <?php
                                                $sql = "SELECT title FROM titlemaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die (print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $title = $row['title'];
                                                        echo '<option value="' . $title . '"';
                                                        if ($title == $rtitle) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . $title . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>First Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rfname"
                                                    value="<?php echo $rfname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Middle Name</h5>
                                                <input type="text" class="form-control" name="rmname"
                                                    value="<?php echo $rmname; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Last Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rlname"
                                                    value="<?php echo $rlname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Gender <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="rsex">
                                                <option value="Male" <?php if ($rsex == 'Male')
                                                    echo 'selected'; ?>>Male
                                                </option>
                                                <option value="Female" <?php if ($rsex == 'Female')
                                                    echo 'selected'; ?>>
                                                    Female</option>
                                                <option value="Others" <?php if ($rsex == 'Others')
                                                    echo 'selected'; ?>>
                                                    Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Age (Years) <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rage"
                                                    value="<?php echo $rage; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Month </h5>
                                                <input type="text" class="form-control" name="month">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Days </h5>
                                                <input type="text" class="form-control" name="days">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>F/H/S/D/W <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="fname"
                                                    value="<?php echo $fname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="radd1"
                                                    value="<?php echo $radd1; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="radd2"
                                                    value="<?php echo $radd2; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>City <span class="text-danger">*</span></h5>
                                            <select class="form-select select2" id="rcity" name="rcity">
                                                <?php
                                                $sql = "SELECT Cityname FROM citymaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die (print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $Cityname = $row['Cityname'];
                                                        echo '<option value="' . $Cityname . '"';
                                                        if ($rcity == $Cityname) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . $Cityname . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>District <span class="text-danger">*</span></h5>
                                            <input type="text" name="rdist" class="form-control" required
                                                value="<?php echo $rdist; ?>"
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>State <span class="text-danger">*</span></h5>
                                            <input type="text" name="rstate" class="form-control" required
                                                value="<?php echo $rstate; ?>"
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Country <span class="text-danger">*</span></h5>
                                            <input type="text" name="rcountry" class="form-control" required
                                                value="<?php echo $rcountry; ?>"
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rrace"
                                                    value="<?php echo $rrace; ?>" maxlength="10"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Ref. Doctor <span class="text-danger">*</span></h5>
                                            <select class="form-select select2" name="rdoc" id="docName"
                                                onchange="getDocname(this.value)">
                                                <?php
                                                $sql = "SELECT docName FROM docmaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die (print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $docName = $row['docName'];
                                                        echo '<option value="' . $docName . '"';
                                                        echo '>' . $docName . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Fee</h5>
                                                <input type="text" class="form-control" name="wamt" id="wamt">
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
<script>
    function getDocname(docName) {
        $.ajax({
            url: "load/doc_fetch_price.php",
            type: "POST",
            data: { docName: docName },
            dataType: "json",
            success: function (data) {
                $("#wamt").val(data.fee);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
<?php
if (isset ($_POST['save'])) {
    $rno = $_POST['rno'];
    $se = $_POST['se'];
    $rdate = $_POST['rdate'];
    $rtime = date('H:i:s A');
    $rstatus = $_POST['rstatus'];
    $rtitle = $_POST['rtitle'];
    $rfname = $_POST['rfname'];
    $rmname = $_POST['rmname'];
    $rlname = $_POST['rlname'];
    $rsex = $_POST['rsex'];
    $rage = $_POST['rage'];
    $month = $_POST['month'];
    $days = $_POST['days'];
    $fname = $_POST['fname'];
    $radd1 = $_POST['radd1'];
    $radd2 = $_POST['radd2'];
    $rcity = $_POST['rcity'];
    $rdist = $_POST['rdist'];
    $rstate = $_POST['rstate'];
    $rcity = $_POST['rcity'];
    $rrace = $_POST['rrace'];
    $rdoc = $_POST['rdoc'];
    $wamt = $_POST['wamt'];
    $rcountry = $_POST['rcountry'];
    $modify_date = date('Y-m-d H:i:s');


    $sql = "UPDATE registration SET 
    rno = '$rno',
    se = '$se',
    rdate = '$rdate',
    rtime = '$rtime',
    rstatus = '$rstatus',
    rtitle = '$rtitle',
    rfname = '$rfname',
    rmname = '$rmname',
    rlname = '$rlname',
    rsex = '$rsex',
    rage = '$rage',
    fname = '$fname',
    radd1 = '$radd1',
    radd2 = '$radd2',
    rcity = '$rcity',
    rdist = '$rdist',
    rstate = '$rstate',
    rrace = '$rrace',
    rdoc = '$rdoc',
    wamt = '$wamt',
    modify_by = '$login_username',
    modify_date = '$modify_date',
    rcountry = '$rcountry'
    WHERE rno = '$rno' AND id = '$id'";

    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die (print_r(sqlsrv_errors(), true));
    } else {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "reg-list";
                }, 1000);
            </script>';
    }
}



include ('footer.php');

?>
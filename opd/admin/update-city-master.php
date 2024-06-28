<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$srno = $_GET['srno'];
$sql = "SELECT srno, Cityname, distname, state, country FROM citymaster WHERE srno = '$srno'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$sno = 0;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $srno = $row['srno'];
    $Cityname = $row['Cityname'];
    $state = $row['state'];
    $distname = $row['distname'];
    $country = $row['country'];
    $sno = $sno + 1;
}
?>
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
                                            <input type="text" name="country" value="<?php echo $country; ?>"
                                                placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>State<span class="text-danger">*</span></h5>
                                            <input type="text" name="state" placeholder="" value="<?php echo $state; ?>"
                                                class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Distric<span class="text-danger">*</span></h5>
                                            <input type="text" name="dist" placeholder="" class="form-control"
                                                value="<?php echo $distname; ?>" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>City<span class="text-danger">*</span></h5>
                                            <input type="text" name="Cityname" placeholder=""
                                                value="<?php echo $Cityname; ?>" class="form-control" required
                                                data-validation-required-message="This field is required">
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
        </section>
        <!-- /.box -->
    </div>
</div>


<?php
if (isset($_POST['save'])) {
    $Cityname = isset($_POST['Cityname']) ? $_POST['Cityname'] : '';
    $dist = isset($_POST['dist']) ? $_POST['dist'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $username = $login_username;
    $modify_date = date('Y-m-d H:i:s');

    $sql = "UPDATE citymaster 
            SET Cityname = ?, distname = ?, state = ?, country = ?, modify_by = ?, modify_date = ?
            WHERE srno = ?";
    $params = array($Cityname, $dist, $state, $country, $username, $modify_date, $srno);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "city-master";
                }, 1000);
              </script>';
    }

}

include ('footer.php');
?>
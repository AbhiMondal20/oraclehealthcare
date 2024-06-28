<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$id = $_GET['id'];

$sql = "SELECT id, dept FROM deptmaster WHERE id = '$id'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $id = $row['id'];
    $dept = $row['dept'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Update Department Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Department</li>
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
                                            <h5>Department<span class="text-danger">*</span></h5>
                                            <input type="text" name="dept" placeholder="" class="form-control" required value="<?php echo $dept; ?>" data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="save">UPDATE</button>
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
    $modify_date = date('Y-m-d H:i:s');
    $sql = "UPDATE deptmaster SET dept = '$dept', modified_by = '$login_username', modified_date = '$modify_date' WHERE id = '$id'";
    
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "dept-master";
                }, 1000);
            </script>';
    }
}




include ('footer.php');

?>
<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$id = $_GET['id'];
$sql = "SELECT id, cate FROM catemaster WHERE id = '$id'";
$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($stmt)) {
    $id = $row['id'];
    $cate = $row['cate'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Update Category Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
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
                                            <input type="text" name="cate" placeholder="" class="form-control" required value="<?php echo $cate; ?>" data-validation-required-message="This field is required">
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
    $cate = $_POST['cate'];
    $modifiedDate = date('Y-m-d H:i:s');
    $sql = "UPDATE catemaster SET cate = '$cate', modifiedBy = '$login_username', modifiedDate = '$modifiedDate' WHERE id = '$id'";
    
    $stmt = mysqli_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(mysqli_errors(), true));
    } else {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "category-master";
                }, 1000);
            </script>';
    }
}

include ('footer.php');
?>
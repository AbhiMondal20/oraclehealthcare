<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$id = $_GET['id'];
$sql = "SELECT id, test, modality, subtest, unit, normrang FROM pathomaster WHERE id = '$id'";
$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $id = $row['id'];
    $test = $row['test'];
    $subtest = $row['subtest'];
    $oldmodality = $row['modality'];
    $unit = $row['unit'];
    $normrang = $row['normrang'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Update Lab Test Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Lab</li>
                                <li class="breadcrumb-item active" aria-current="page">Test</li>
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
                                                    echo '<option value="' . $modality . '"';
                                                    if ($oldmodality == $modality) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . $modality . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Test Head<span class="text-danger">*</span></h5>
                                            <input type="text" name="test" placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required" value="<?php echo $test; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Subtest<span class="text-danger">*</span></h5>
                                            <input type="text" name="subtest" placeholder="" class="form-control" value="<?php echo $subtest; ?>"
                                                required data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Unit</h5>
                                            <input type="text" name="unit" placeholder="" class="form-control" value="<?php echo $unit; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Normal Range</h5>
                                            <input type="text" name="normrang" placeholder="" value="<?php echo $normrang; ?>" class="form-control">
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


<?php
if (isset($_POST['save'])) {
    $modality = $_POST['modality'];
    $test = $_POST['test'];
    $subtest = $_POST['subtest'];
    $unit = $_POST['unit'];
    $normrang = $_POST['normrang'];
    $modify_date = date('Y-m-d H:i:s');

    $sql = "UPDATE pathomaster 
        SET test = '$test', 
            modality = '$modality', 
            subtest = '$subtest', 
            unit = '$unit', 
            normrang = '$normrang', 
            modifiedBy = '$login_username',
            modifiedDate = '$modify_date' WHERE id = '$id'";

    $stmt = mysqli_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(mysqli_errors(), true));
    } else {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "labtest";
                }, 1000);
            </script>';
    }
}



include ('footer.php');

?>
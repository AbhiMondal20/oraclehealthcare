<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
$id = $_GET['id'];
$rno = $_GET['rno'];

$sql = "SELECT b.id, b.rno, b.opid, b.billdate, b.billno, b.pname, b.uname, b.servname, b.servrate, r.rsex, r.rage, r.rdoc
FROM billing AS b
INNER JOIN registration AS r ON b.rno = r.rno WHERE b.id = '$id' AND b.rno = '$rno'";
$res = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
    $opid = $row['opid'];
    $pname = $row['pname'];
    $servname = $row['servname'];
    $age = $row['rage'];
    $gender = $row['rsex'];
    $doc = $row['rdoc'];
}
?>
<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Medical Reports</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Medical</li>
                                <li class="breadcrumb-item active" aria-current="page">Reports</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">Reg. No: &nbsp;
                        <?php echo $rno ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name: &nbsp;
                        <?php echo $pname ?>&nbsp;/
                        <?php echo $age ?>&nbsp;/
                        <?php echo $gender; ?>&nbsp;&nbsp;&nbsp;Doctor: &nbsp;
                        <?php echo $doc ?>
                    </h4>
                </div>
            </div>
        </div>
        <!-- Upload Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title"><strong>Upload Reports</strong></h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-close" href="#"></a></li>
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>

                <div class="box-body">
                    <!-- Main content -->
                    <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <form action="#" class="dropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- Test Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title"><strong style="background-color: #22cab9;">Test Reports: &nbsp;&nbsp;
                            <?php echo $servname; ?>
                        </strong></h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-close" href="#"></a></li>
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="col-form-label">Name</label>
                                </div>
                                <div class="col-md-2">
                                    Unit
                                </div>
                                <div class="col-md-2">
                                    Reference Range
                                </div>
                                <div class="col-md-2">
                                    Result
                                </div>
                                <div class="col-md-2">
                                    Status
                                </div>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="BILIRUBIN-TOTAL"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="mg/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang"
                                            value=" 0.2 and 1.3 mg/dL" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="BILIRUBIN-DIRECT"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="mg/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang"
                                            value=" less than 0.3 mg/dL" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="rangev">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest"
                                            value="BILIRUBIN-INDIRECT" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="mg/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang" value="0.2 to 0.8 mg/dL"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="SGO/AST" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="U/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang" value="8 and 45 U/L"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="SGPT/ALT"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="U/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang" value="7 and 56 U/L"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="TOTAL PROTEIN"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="g/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang" value="6.0 to 8.3 g/dl"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="ALBUMIN" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="g/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang" value="3.4 to 5.4 g/dl"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="GLOBULIN"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="g/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang" value="2.0 to 3.5 g/dl"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="AG/RATIO "
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="Ratio" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang"
                                            value="1.1 and 2.5 Ratio" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="GGT" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit" value="IU/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang" value="5 to 40 IU/L"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="status">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea name="" id="editor" rows="10"></textarea>
                                    </div>
                                </div>
                                <center>

                                    <button class="btn btn-md btn-primary" type="submit" name="save">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>

    </div>
</div>
<?php
include ('footer.php');
?>
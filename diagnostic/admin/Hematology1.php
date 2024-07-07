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
        <!-- Blood Analysis -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Reg. No: &nbsp;
                        <?php echo $rno ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        OP Id: &nbsp;
                        <?php echo $opid ?>
                        Name: &nbsp;
                        <?php echo $pname ?>&nbsp;/
                        <?php echo $age ?>&nbsp;/
                        <?php echo $gender; ?>&nbsp;&nbsp;&nbsp;Doctor: &nbsp;
                        <?php echo $doc ?>&nbsp;&nbsp;<strong style="background-color: #22cab9;">Test Reports:
                            &nbsp;&nbsp;
                            <?php echo $servname; ?>
                        </strong>
                    </h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-close" href="#"></a></li>
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-12" style="max-height: 450px; overflow-x: scroll;">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="col-form-label">Name</label>
                                </div>
                                <div class="col-md-2">
                                    Result
                                </div>
                                <div class="col-md-2">
                                    Severity
                                </div>
                                <div class="col-md-2">
                                    Unit
                                </div>
                                <div class="col-md-2">
                                    Reference Range
                                </div>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                    <input class="form-control" type="hidden" name="pname"
                                        value="<?php echo $pname; ?>">
                                    <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                    <input class="form-control" type="hidden" name="servname"
                                        value="<?php echo $servname; ?>">
                                    <input class="form-control" type="hidden" name="modality" value="Hematology">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Heamoglobin"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="1">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="gm/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" readonly
                                            value="Men- 13.5-18.0 gm/dl.">
                                        <input class="form-control" type="text" name="normrang[]" readonly
                                            value="Women- 11.5-16.4 gm/dl.">
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="E.S.R."
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="2">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="MM/1st hr"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="normrang[]" class="form-control" value="Westergren">
                                        <input type="text" name="normrang[]" class="form-control"
                                            value="00-10 mm /1st  hr.">
                                    </div>
                                </div>
                                <h3 for="">Total Count</h3>
                                <hr>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="R.B.C Count"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="3">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="4.0-6.5 X 10^6 /cmm" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="W.B.C Count"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="4">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="4000-11000 /cmm" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Platelet Count"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="5">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="1.5-4.0 X 10^5 /cmm" readonly>
                                    </div>
                                </div>
                                <h3 for="">Absoluate Value</h3>
                                <hr>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="PCV" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="6">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="%">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="35-45 %"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="MCV" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="7">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="fl">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="76-96 fl"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="MCH" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="8">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="pg">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="27-33 pg"
                                            readonly>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="MCHC">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="9">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="%">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="30-35  mg./dl.">
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Bleeding Time">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="10">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="Duke's Method">
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest" value="Minutes">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="11">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit">
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Second">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="11">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="1 - 5 mins">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Coagulation Time">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="12">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Minutes">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="13">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Seconds">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="14">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="2 - 9 mins">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="Capillary Method">
                                    </div>
                                </div>
                                <h3 for="">DIFFERENCIAL COUNT</h3>
                                <hr>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Neutrophil">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="15">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="%">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="40-74 %">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Lymphocyte"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="16">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="%">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="20-45 %"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Eosinophil"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="17">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="01-06 %"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Monocyte"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="18">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>

                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="00-10 %"
                                            readonly>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Basophil"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="19">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="00-01 %"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Band Cell"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="20">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Promyelocytes"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="21">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Reticulocyte Count" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="22">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Myelocytes">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="23">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Blast Cell">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="24">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Metamyelocytes">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="25">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Micro Filaria">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="26">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <h3>PERIPHERAL BLOOD SMEAR</h3>
                                <hr>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <label for="">RCB</label>
                                        <select class="form-control select2" name="rcb[]" id="" tabindex="27">
                                            <option selected disabled>select</option>
                                            <option value="Acanthocytes">Acanthocytes</option>
                                            <option value="Hypochromic with anisocytosis & microcytosis.">Hypochromic
                                                with anisocytosis & microcytosis.</option>
                                            <option value="Hypochromic with anisocytosis.">Hypochromic with
                                                anisocytosis.</option>
                                            <option value="macrocytes few.">Macrocytes few.</option>
                                            <option value="Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Microcytic hypochromic cell with anisopoikilocytosis.</option>
                                            <option value="Microcytic hypochromic RBC.">Microcytic hypochromic RBC.
                                            </option>
                                            <option value="Microcytic hypochromic to normocytic normochromic RBC.">
                                                Microcytic hypochromic to normocytic normochromic RBC.</option>
                                            <option value="Microcytic hypochromic.">Microcytic hypochromic.</option>
                                            <option value="Mild anisocytosis hypochromic (+) macrocytes few.">Mild
                                                anisocytosis hypochromic (+) macrocytes few.</option>
                                            <option value="Mild anisocytosis hypochromic (+), macrocytes few.">Mild
                                                anisocytosis hypochromic (+), macrocytes few.</option>
                                            <option value="Mildly hypochromic RBC seen.">Mildly hypochromic RBC seen.
                                            </option>
                                            <option value="Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Normocytic Normochromic Predominantly with Anisocytosis.</option>
                                            <option value="Normocytic Normochromic Predominantly.">Normocytic
                                                Normochromic Predominantly.</option>
                                            <option value="Normocytic Normochromic RBC.">Normocytic Normochromic RBC.
                                            </option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Population reduced, hypochromia with anisocytosis.">
                                                Population reduced, hypochromia with anisocytosis.</option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisocytosis.">
                                                Population reduced, Microcytic hypochromic cell with anisocytosis.
                                            </option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Population reduced, Microcytic hypochromic cell with
                                                anisopoikilocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Population reduced, Normocytic Normochromic Predominantly with
                                                Anisocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic normochromic predominantly with anisocytosis.">
                                                Population reduced, Normocytic normochromic predominantly with
                                                anisocytosis.</option>
                                            <option value="Population reduced, Normocytic normochromic predominantly.">
                                                Population reduced, Normocytic normochromic predominantly.</option>
                                            <option value="Population reduced, Normocytic Normochromic.">Population
                                                reduced, Normocytic Normochromic.</option>
                                            <option value="Population reduced, Predominantly microcytic hypochromic.">
                                                Population reduced, Predominantly microcytic hypochromic.</option>
                                            <option value="Predominantly microcytic hypochromic.">Predominantly
                                                microcytic hypochromic.</option>
                                            <option value="Predominantly normocytic hypochromic (+), macrocytes few.">
                                                Predominantly normocytic hypochromic (+), macrocytes few.</option>
                                            <option value="Predominantly normocytic hypochromic (+).">Predominantly
                                                normocytic hypochromic (+).</option>
                                            <option value="Predominantly normocytic mild hypochromic.">Predominantly
                                                normocytic mild hypochromic.</option>
                                            <option value="Predominantly normocytic normochromic, macrocytes-few.">
                                                Predominantly normocytic normochromic, macrocytes-few.</option>
                                            <option value="Target cell, Acanthocytes and fragmented RBC seen.">Target
                                                cell, Acanthocytes and fragmented RBC seen.</option>

                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <!-- <label for="">RCB</label> -->
                                        <select class="form-control select2" name="rcb[]" tabindex="28">
                                            <option selected disabled>select</option>
                                            <option value="Acanthocytes">Acanthocytes</option>
                                            <option value="Hypochromic with anisocytosis & microcytosis.">Hypochromic
                                                with anisocytosis & microcytosis.</option>
                                            <option value="Hypochromic with anisocytosis.">Hypochromic with
                                                anisocytosis.</option>
                                            <option value="macrocytes few.">Macrocytes few.</option>
                                            <option value="Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Microcytic hypochromic cell with anisopoikilocytosis.</option>
                                            <option value="Microcytic hypochromic RBC.">Microcytic hypochromic RBC.
                                            </option>
                                            <option value="Microcytic hypochromic to normocytic normochromic RBC.">
                                                Microcytic hypochromic to normocytic normochromic RBC.</option>
                                            <option value="Microcytic hypochromic.">Microcytic hypochromic.</option>
                                            <option value="Mild anisocytosis hypochromic (+) macrocytes few.">Mild
                                                anisocytosis hypochromic (+) macrocytes few.</option>
                                            <option value="Mild anisocytosis hypochromic (+), macrocytes few.">Mild
                                                anisocytosis hypochromic (+), macrocytes few.</option>
                                            <option value="Mildly hypochromic RBC seen.">Mildly hypochromic RBC seen.
                                            </option>
                                            <option value="Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Normocytic Normochromic Predominantly with Anisocytosis.</option>
                                            <option value="Normocytic Normochromic Predominantly.">Normocytic
                                                Normochromic Predominantly.</option>
                                            <option value="Normocytic Normochromic RBC.">Normocytic Normochromic RBC.
                                            </option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Population reduced, hypochromia with anisocytosis.">
                                                Population reduced, hypochromia with anisocytosis.</option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisocytosis.">
                                                Population reduced, Microcytic hypochromic cell with anisocytosis.
                                            </option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Population reduced, Microcytic hypochromic cell with
                                                anisopoikilocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Population reduced, Normocytic Normochromic Predominantly with
                                                Anisocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic normochromic predominantly with anisocytosis.">
                                                Population reduced, Normocytic normochromic predominantly with
                                                anisocytosis.</option>
                                            <option value="Population reduced, Normocytic normochromic predominantly.">
                                                Population reduced, Normocytic normochromic predominantly.</option>
                                            <option value="Population reduced, Normocytic Normochromic.">Population
                                                reduced, Normocytic Normochromic.</option>
                                            <option value="Population reduced, Predominantly microcytic hypochromic.">
                                                Population reduced, Predominantly microcytic hypochromic.</option>
                                            <option value="Predominantly microcytic hypochromic.">Predominantly
                                                microcytic hypochromic.</option>
                                            <option value="Predominantly normocytic hypochromic (+), macrocytes few.">
                                                Predominantly normocytic hypochromic (+), macrocytes few.</option>
                                            <option value="Predominantly normocytic hypochromic (+).">Predominantly
                                                normocytic hypochromic (+).</option>
                                            <option value="Predominantly normocytic mild hypochromic.">Predominantly
                                                normocytic mild hypochromic.</option>
                                            <option value="Predominantly normocytic normochromic, macrocytes-few.">
                                                Predominantly normocytic normochromic, macrocytes-few.</option>
                                            <option value="Target cell, Acanthocytes and fragmented RBC seen.">Target
                                                cell, Acanthocytes and fragmented RBC seen.</option>

                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <!-- <label for="">RCB</label> -->
                                        <select class="form-control select2" name="rcb[]" tabindex="29">
                                            <option selected disabled>select</option>
                                            <option value="Acanthocytes">Acanthocytes</option>
                                            <option value="Hypochromic with anisocytosis & microcytosis.">Hypochromic
                                                with anisocytosis & microcytosis.</option>
                                            <option value="Hypochromic with anisocytosis.">Hypochromic with
                                                anisocytosis.</option>
                                            <option value="macrocytes few.">Macrocytes few.</option>
                                            <option value="Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Microcytic hypochromic cell with anisopoikilocytosis.</option>
                                            <option value="Microcytic hypochromic RBC.">Microcytic hypochromic RBC.
                                            </option>
                                            <option value="Microcytic hypochromic to normocytic normochromic RBC.">
                                                Microcytic hypochromic to normocytic normochromic RBC.</option>
                                            <option value="Microcytic hypochromic.">Microcytic hypochromic.</option>
                                            <option value="Mild anisocytosis hypochromic (+) macrocytes few.">Mild
                                                anisocytosis hypochromic (+) macrocytes few.</option>
                                            <option value="Mild anisocytosis hypochromic (+), macrocytes few.">Mild
                                                anisocytosis hypochromic (+), macrocytes few.</option>
                                            <option value="Mildly hypochromic RBC seen.">Mildly hypochromic RBC seen.
                                            </option>
                                            <option value="Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Normocytic Normochromic Predominantly with Anisocytosis.</option>
                                            <option value="Normocytic Normochromic Predominantly.">Normocytic
                                                Normochromic Predominantly.</option>
                                            <option value="Normocytic Normochromic RBC.">Normocytic Normochromic RBC.
                                            </option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Population reduced, hypochromia with anisocytosis.">
                                                Population reduced, hypochromia with anisocytosis.</option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisocytosis.">
                                                Population reduced, Microcytic hypochromic cell with anisocytosis.
                                            </option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Population reduced, Microcytic hypochromic cell with
                                                anisopoikilocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Population reduced, Normocytic Normochromic Predominantly with
                                                Anisocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic normochromic predominantly with anisocytosis.">
                                                Population reduced, Normocytic normochromic predominantly with
                                                anisocytosis.</option>
                                            <option value="Population reduced, Normocytic normochromic predominantly.">
                                                Population reduced, Normocytic normochromic predominantly.</option>
                                            <option value="Population reduced, Normocytic Normochromic.">Population
                                                reduced, Normocytic Normochromic.</option>
                                            <option value="Population reduced, Predominantly microcytic hypochromic.">
                                                Population reduced, Predominantly microcytic hypochromic.</option>
                                            <option value="Predominantly microcytic hypochromic.">Predominantly
                                                microcytic hypochromic.</option>
                                            <option value="Predominantly normocytic hypochromic (+), macrocytes few.">
                                                Predominantly normocytic hypochromic (+), macrocytes few.</option>
                                            <option value="Predominantly normocytic hypochromic (+).">Predominantly
                                                normocytic hypochromic (+).</option>
                                            <option value="Predominantly normocytic mild hypochromic.">Predominantly
                                                normocytic mild hypochromic.</option>
                                            <option value="Predominantly normocytic normochromic, macrocytes-few.">
                                                Predominantly normocytic normochromic, macrocytes-few.</option>
                                            <option value="Target cell, Acanthocytes and fragmented RBC seen.">Target
                                                cell, Acanthocytes and fragmented RBC seen.</option>

                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <!-- <label for="">RCB</label> -->
                                        <select class="form-control select2" name="rcb[]" tabindex="30">
                                            <option selected disabled>select</option>
                                            <option value="Acanthocytes">Acanthocytes</option>
                                            <option value="Hypochromic with anisocytosis & microcytosis.">Hypochromic
                                                with anisocytosis & microcytosis.</option>
                                            <option value="Hypochromic with anisocytosis.">Hypochromic with
                                                anisocytosis.</option>
                                            <option value="macrocytes few.">Macrocytes few.</option>
                                            <option value="Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Microcytic hypochromic cell with anisopoikilocytosis.</option>
                                            <option value="Microcytic hypochromic RBC.">Microcytic hypochromic RBC.
                                            </option>
                                            <option value="Microcytic hypochromic to normocytic normochromic RBC.">
                                                Microcytic hypochromic to normocytic normochromic RBC.</option>
                                            <option value="Microcytic hypochromic.">Microcytic hypochromic.</option>
                                            <option value="Mild anisocytosis hypochromic (+) macrocytes few.">Mild
                                                anisocytosis hypochromic (+) macrocytes few.</option>
                                            <option value="Mild anisocytosis hypochromic (+), macrocytes few.">Mild
                                                anisocytosis hypochromic (+), macrocytes few.</option>
                                            <option value="Mildly hypochromic RBC seen.">Mildly hypochromic RBC seen.
                                            </option>
                                            <option value="Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Normocytic Normochromic Predominantly with Anisocytosis.</option>
                                            <option value="Normocytic Normochromic Predominantly.">Normocytic
                                                Normochromic Predominantly.</option>
                                            <option value="Normocytic Normochromic RBC.">Normocytic Normochromic RBC.
                                            </option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Population reduced, hypochromia with anisocytosis.">
                                                Population reduced, hypochromia with anisocytosis.</option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisocytosis.">
                                                Population reduced, Microcytic hypochromic cell with anisocytosis.
                                            </option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Population reduced, Microcytic hypochromic cell with
                                                anisopoikilocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Population reduced, Normocytic Normochromic Predominantly with
                                                Anisocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic normochromic predominantly with anisocytosis.">
                                                Population reduced, Normocytic normochromic predominantly with
                                                anisocytosis.</option>
                                            <option value="Population reduced, Normocytic normochromic predominantly.">
                                                Population reduced, Normocytic normochromic predominantly.</option>
                                            <option value="Population reduced, Normocytic Normochromic.">Population
                                                reduced, Normocytic Normochromic.</option>
                                            <option value="Population reduced, Predominantly microcytic hypochromic.">
                                                Population reduced, Predominantly microcytic hypochromic.</option>
                                            <option value="Predominantly microcytic hypochromic.">Predominantly
                                                microcytic hypochromic.</option>
                                            <option value="Predominantly normocytic hypochromic (+), macrocytes few.">
                                                Predominantly normocytic hypochromic (+), macrocytes few.</option>
                                            <option value="Predominantly normocytic hypochromic (+).">Predominantly
                                                normocytic hypochromic (+).</option>
                                            <option value="Predominantly normocytic mild hypochromic.">Predominantly
                                                normocytic mild hypochromic.</option>
                                            <option value="Predominantly normocytic normochromic, macrocytes-few.">
                                                Predominantly normocytic normochromic, macrocytes-few.</option>
                                            <option value="Target cell, Acanthocytes and fragmented RBC seen.">Target
                                                cell, Acanthocytes and fragmented RBC seen.</option>

                                        </select>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <!-- <label for="">RCB</label> -->
                                        <select class="form-control select2" name="rcb[]" tabindex="31">
                                            <option selected disabled>select</option>
                                            <option value="Acanthocytes">Acanthocytes</option>
                                            <option value="Hypochromic with anisocytosis & microcytosis.">Hypochromic
                                                with anisocytosis & microcytosis.</option>
                                            <option value="Hypochromic with anisocytosis.">Hypochromic with
                                                anisocytosis.</option>
                                            <option value="macrocytes few.">Macrocytes few.</option>
                                            <option value="Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Microcytic hypochromic cell with anisopoikilocytosis.</option>
                                            <option value="Microcytic hypochromic RBC.">Microcytic hypochromic RBC.
                                            </option>
                                            <option value="Microcytic hypochromic to normocytic normochromic RBC.">
                                                Microcytic hypochromic to normocytic normochromic RBC.</option>
                                            <option value="Microcytic hypochromic.">Microcytic hypochromic.</option>
                                            <option value="Mild anisocytosis hypochromic (+) macrocytes few.">Mild
                                                anisocytosis hypochromic (+) macrocytes few.</option>
                                            <option value="Mild anisocytosis hypochromic (+), macrocytes few.">Mild
                                                anisocytosis hypochromic (+), macrocytes few.</option>
                                            <option value="Mildly hypochromic RBC seen.">Mildly hypochromic RBC seen.
                                            </option>
                                            <option value="Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Normocytic Normochromic Predominantly with Anisocytosis.</option>
                                            <option value="Normocytic Normochromic Predominantly.">Normocytic
                                                Normochromic Predominantly.</option>
                                            <option value="Normocytic Normochromic RBC.">Normocytic Normochromic RBC.
                                            </option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Population reduced, hypochromia with anisocytosis.">
                                                Population reduced, hypochromia with anisocytosis.</option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisocytosis.">
                                                Population reduced, Microcytic hypochromic cell with anisocytosis.
                                            </option>
                                            <option
                                                value="Population reduced, Microcytic hypochromic cell with anisopoikilocytosis.">
                                                Population reduced, Microcytic hypochromic cell with
                                                anisopoikilocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic Normochromic Predominantly with Anisocytosis.">
                                                Population reduced, Normocytic Normochromic Predominantly with
                                                Anisocytosis.</option>
                                            <option
                                                value="Population reduced, Normocytic normochromic predominantly with anisocytosis.">
                                                Population reduced, Normocytic normochromic predominantly with
                                                anisocytosis.</option>
                                            <option value="Population reduced, Normocytic normochromic predominantly.">
                                                Population reduced, Normocytic normochromic predominantly.</option>
                                            <option value="Population reduced, Normocytic Normochromic.">Population
                                                reduced, Normocytic Normochromic.</option>
                                            <option value="Population reduced, Predominantly microcytic hypochromic.">
                                                Population reduced, Predominantly microcytic hypochromic.</option>
                                            <option value="Predominantly microcytic hypochromic.">Predominantly
                                                microcytic hypochromic.</option>
                                            <option value="Predominantly normocytic hypochromic (+), macrocytes few.">
                                                Predominantly normocytic hypochromic (+), macrocytes few.</option>
                                            <option value="Predominantly normocytic hypochromic (+).">Predominantly
                                                normocytic hypochromic (+).</option>
                                            <option value="Predominantly normocytic mild hypochromic.">Predominantly
                                                normocytic mild hypochromic.</option>
                                            <option value="Predominantly normocytic normochromic, macrocytes-few.">
                                                Predominantly normocytic normochromic, macrocytes-few.</option>
                                            <option value="Target cell, Acanthocytes and fragmented RBC seen.">Target
                                                cell, Acanthocytes and fragmented RBC seen.</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-3">
                                        <label for="">WBC</label>
                                        <select class="form-control select2" name="wbc[]" tabindex="32">
                                            <option selected disabled>select</option>
                                            <option value="Advice : Hb variant study may help explain RBC Morphology">
                                                Advice : Hb variant study may help explain RBC Morphology</option>
                                            <option value="Advice: Iron study may prove helpful">Advice: Iron study may
                                                prove helpful.</option>
                                            <option value="Eosinophil count mildly raised">Eosinophil count mildly
                                                raised.</option>
                                            <option value="Eosinophilia noted">Eosinophilia noted.</option>
                                            <option value="Few transformed lymphocytes seen">Few transformed lymphocytes
                                                seen.</option>
                                            <option value="Leucocytosis">Leucocytosis.</option>
                                            <option value="Leucopenia along with Transformed lymphocytes seen">
                                                Leucopenia along with Transformed lymphocytes seen</option>
                                            <option value="Leucopenia and eosinophilia count proportionally high">
                                                Leucopenia and eosinophilia count proportionally high.</option>
                                            <option value="Leucopenia noted">Leucopenia noted</option>
                                            <option value="Leucopenia">Leucopenia</option>
                                            <option value="Lymphocytosis">Lymphocytosis</option>
                                            <option value="Mild degree neutrophilic leucocytosis.">Mild degree
                                                neutrophilic leucocytosis.</option>
                                            <option value="Mild Eosinophilia.">Mild Eosinophilia.</option>
                                            <option value="Mild leucopenia noted.">Mild leucopenia noted.</option>
                                            <option value="Mild Neutrophilc shift to left noted.">Mild Neutrophilc shift
                                                to left noted.</option>
                                            <option value="Mild shift to left noted.">Mild shift to left noted.</option>
                                            <option value="Neutrophilia and show mild shift to left noted.">Neutrophilia
                                                and show mild shift to left noted.</option>
                                            <option value="Neutrophilia -relative.">Neutrophilia -relative.</option>
                                            <option value="Neutrophilia with shift to left noted.">Neutrophilia with
                                                shift to left noted.</option>
                                            <option value="Neutrophilia -relative.">Neutrophilia -relative.</option>
                                            <option value="Neutrophilia with shift to left noted.">Neutrophilia with
                                                shift to left noted.</option>
                                            <option
                                                value="Neutrophilic leucocytosis, shift to left, toxic granule present.">
                                                Neutrophilic leucocytosis, shift to left, toxic granule present.
                                            </option>
                                            <option value="Neutrophilic leucocytosis.">Neutrophilic leucocytosis.
                                            </option>
                                            <option value="Neutrophilic leucocytosis-shift to left.">Neutrophilic
                                                leucocytosis-shift to left.</option>
                                            <option value="No abnormal forms seen.">No abnormal forms seen.</option>
                                            <option value="Normal Morphology.">Normal Morphology.</option>
                                            <option value="Normal morphology.">Normal morphology.</option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Occasional Transformed lymphocytes.">Occasional Transformed
                                                lymphocytes.</option>
                                            <option value="Polymorphonuclear leucocytosis with shift to left noted.">
                                                Polymorphonuclear leucocytosis with shift to left noted.</option>
                                            <option value="Polymorphonuclear leucocytosis with shift to left.">
                                                Polymorphonuclear leucocytosis with shift to left.</option>
                                            <option value="Polymorphs show mild shift to left.">Polymorphs show mild
                                                shift to left.</option>
                                            <option value="Relative lymphocytosis.">Relative lymphocytosis.</option>
                                            <option value="Relative neutrophilia and show mild shift to left noted.">
                                                Relative neutrophilia and show mild shift to left noted.</option>
                                            <option value="Relative neutrophilia noted.">Relative neutrophilia noted.
                                            </option>
                                            <option value="Relative neutrophilia with mild shift to left.">Relative
                                                neutrophilia with mild shift to left.</option>
                                            <option value="Relative neutrophilia with shift to left noted.">Relative
                                                neutrophilia with shift to left noted.</option>
                                            <option value="Relative neutrophilia.">Relative neutrophilia.</option>
                                            <option value="Shift to left along with Transformed lymphocytes seen.">Shift
                                                to left along with Transformed lymphocytes seen.</option>
                                            <option value="Shift to left noted.">Shift to left noted.</option>
                                            <option value="Transformed lymphocytes seen.">Transformed lymphocytes seen.
                                            </option>
                                            <option value="Within normal limit.">Within normal limit.</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <!-- <label for="">WBC</label> -->
                                        <select class="form-control select2" name="wbc[]" tabindex="33">
                                            <option selected disabled>select</option>
                                            <option value="Advice : Hb variant study may help explain RBC Morphology">
                                                Advice : Hb variant study may help explain RBC Morphology</option>
                                            <option value="Advice: Iron study may prove helpful">Advice: Iron study may
                                                prove helpful.</option>
                                            <option value="Eosinophil count mildly raised">Eosinophil count mildly
                                                raised.</option>
                                            <option value="Eosinophilia noted">Eosinophilia noted.</option>
                                            <option value="Few transformed lymphocytes seen">Few transformed lymphocytes
                                                seen.</option>
                                            <option value="Leucocytosis">Leucocytosis.</option>
                                            <option value="Leucopenia along with Transformed lymphocytes seen">
                                                Leucopenia along with Transformed lymphocytes seen</option>
                                            <option value="Leucopenia and eosinophilia count proportionally high">
                                                Leucopenia and eosinophilia count proportionally high.</option>
                                            <option value="Leucopenia noted">Leucopenia noted</option>
                                            <option value="Leucopenia">Leucopenia</option>
                                            <option value="Lymphocytosis">Lymphocytosis</option>
                                            <option value="Mild degree neutrophilic leucocytosis.">Mild degree
                                                neutrophilic leucocytosis.</option>
                                            <option value="Mild Eosinophilia.">Mild Eosinophilia.</option>
                                            <option value="Mild leucopenia noted.">Mild leucopenia noted.</option>
                                            <option value="Mild Neutrophilc shift to left noted.">Mild Neutrophilc shift
                                                to left noted.</option>
                                            <option value="Mild shift to left noted.">Mild shift to left noted.</option>
                                            <option value="Neutrophilia and show mild shift to left noted.">Neutrophilia
                                                and show mild shift to left noted.</option>
                                            <option value="Neutrophilia -relative.">Neutrophilia -relative.</option>
                                            <option value="Neutrophilia with shift to left noted.">Neutrophilia with
                                                shift to left noted.</option>
                                            <option value="Neutrophilia -relative.">Neutrophilia -relative.</option>
                                            <option value="Neutrophilia with shift to left noted.">Neutrophilia with
                                                shift to left noted.</option>
                                            <option
                                                value="Neutrophilic leucocytosis, shift to left, toxic granule present.">
                                                Neutrophilic leucocytosis, shift to left, toxic granule present.
                                            </option>
                                            <option value="Neutrophilic leucocytosis.">Neutrophilic leucocytosis.
                                            </option>
                                            <option value="Neutrophilic leucocytosis-shift to left.">Neutrophilic
                                                leucocytosis-shift to left.</option>
                                            <option value="No abnormal forms seen.">No abnormal forms seen.</option>
                                            <option value="Normal Morphology.">Normal Morphology.</option>
                                            <option value="Normal morphology.">Normal morphology.</option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Occasional Transformed lymphocytes.">Occasional Transformed
                                                lymphocytes.</option>
                                            <option value="Polymorphonuclear leucocytosis with shift to left noted.">
                                                Polymorphonuclear leucocytosis with shift to left noted.</option>
                                            <option value="Polymorphonuclear leucocytosis with shift to left.">
                                                Polymorphonuclear leucocytosis with shift to left.</option>
                                            <option value="Polymorphs show mild shift to left.">Polymorphs show mild
                                                shift to left.</option>
                                            <option value="Relative lymphocytosis.">Relative lymphocytosis.</option>
                                            <option value="Relative neutrophilia and show mild shift to left noted.">
                                                Relative neutrophilia and show mild shift to left noted.</option>
                                            <option value="Relative neutrophilia noted.">Relative neutrophilia noted.
                                            </option>
                                            <option value="Relative neutrophilia with mild shift to left.">Relative
                                                neutrophilia with mild shift to left.</option>
                                            <option value="Relative neutrophilia with shift to left noted.">Relative
                                                neutrophilia with shift to left noted.</option>
                                            <option value="Relative neutrophilia.">Relative neutrophilia.</option>
                                            <option value="Shift to left along with Transformed lymphocytes seen.">Shift
                                                to left along with Transformed lymphocytes seen.</option>
                                            <option value="Shift to left noted.">Shift to left noted.</option>
                                            <option value="Transformed lymphocytes seen.">Transformed lymphocytes seen.
                                            </option>
                                            <option value="Within normal limit.">Within normal limit.</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <!-- <label for="">WBC</label> -->
                                        <select class="form-control select2" name="wbc[]" tabindex="34">
                                            <option selected disabled>select</option>
                                            <option value="Advice : Hb variant study may help explain RBC Morphology">
                                                Advice : Hb variant study may help explain RBC Morphology</option>
                                            <option value="Advice: Iron study may prove helpful">Advice: Iron study may
                                                prove helpful.</option>
                                            <option value="Eosinophil count mildly raised">Eosinophil count mildly
                                                raised.</option>
                                            <option value="Eosinophilia noted">Eosinophilia noted.</option>
                                            <option value="Few transformed lymphocytes seen">Few transformed lymphocytes
                                                seen.</option>
                                            <option value="Leucocytosis">Leucocytosis.</option>
                                            <option value="Leucopenia along with Transformed lymphocytes seen">
                                                Leucopenia along with Transformed lymphocytes seen</option>
                                            <option value="Leucopenia and eosinophilia count proportionally high">
                                                Leucopenia and eosinophilia count proportionally high.</option>
                                            <option value="Leucopenia noted">Leucopenia noted</option>
                                            <option value="Leucopenia">Leucopenia</option>
                                            <option value="Lymphocytosis">Lymphocytosis</option>
                                            <option value="Mild degree neutrophilic leucocytosis.">Mild degree
                                                neutrophilic leucocytosis.</option>
                                            <option value="Mild Eosinophilia.">Mild Eosinophilia.</option>
                                            <option value="Mild leucopenia noted.">Mild leucopenia noted.</option>
                                            <option value="Mild Neutrophilc shift to left noted.">Mild Neutrophilc shift
                                                to left noted.</option>
                                            <option value="Mild shift to left noted.">Mild shift to left noted.</option>
                                            <option value="Neutrophilia and show mild shift to left noted.">Neutrophilia
                                                and show mild shift to left noted.</option>
                                            <option value="Neutrophilia -relative.">Neutrophilia -relative.</option>
                                            <option value="Neutrophilia with shift to left noted.">Neutrophilia with
                                                shift to left noted.</option>
                                            <option value="Neutrophilia -relative.">Neutrophilia -relative.</option>
                                            <option value="Neutrophilia with shift to left noted.">Neutrophilia with
                                                shift to left noted.</option>
                                            <option
                                                value="Neutrophilic leucocytosis, shift to left, toxic granule present.">
                                                Neutrophilic leucocytosis, shift to left, toxic granule present.
                                            </option>
                                            <option value="Neutrophilic leucocytosis.">Neutrophilic leucocytosis.
                                            </option>
                                            <option value="Neutrophilic leucocytosis-shift to left.">Neutrophilic
                                                leucocytosis-shift to left.</option>
                                            <option value="No abnormal forms seen.">No abnormal forms seen.</option>
                                            <option value="Normal Morphology.">Normal Morphology.</option>
                                            <option value="Normal morphology.">Normal morphology.</option>
                                            <option value="Normocytic normochromic to microcytic hypochromic RBC.">
                                                Normocytic normochromic to microcytic hypochromic RBC.</option>
                                            <option value="Occasional Transformed lymphocytes.">Occasional Transformed
                                                lymphocytes.</option>
                                            <option value="Polymorphonuclear leucocytosis with shift to left noted.">
                                                Polymorphonuclear leucocytosis with shift to left noted.</option>
                                            <option value="Polymorphonuclear leucocytosis with shift to left.">
                                                Polymorphonuclear leucocytosis with shift to left.</option>
                                            <option value="Polymorphs show mild shift to left.">Polymorphs show mild
                                                shift to left.</option>
                                            <option value="Relative lymphocytosis.">Relative lymphocytosis.</option>
                                            <option value="Relative neutrophilia and show mild shift to left noted.">
                                                Relative neutrophilia and show mild shift to left noted.</option>
                                            <option value="Relative neutrophilia noted.">Relative neutrophilia noted.
                                            </option>
                                            <option value="Relative neutrophilia with mild shift to left.">Relative
                                                neutrophilia with mild shift to left.</option>
                                            <option value="Relative neutrophilia with shift to left noted.">Relative
                                                neutrophilia with shift to left noted.</option>
                                            <option value="Relative neutrophilia.">Relative neutrophilia.</option>
                                            <option value="Shift to left along with Transformed lymphocytes seen.">Shift
                                                to left along with Transformed lymphocytes seen.</option>
                                            <option value="Shift to left noted.">Shift to left noted.</option>
                                            <option value="Transformed lymphocytes seen.">Transformed lymphocytes seen.
                                            </option>
                                            <option value="Within normal limit.">Within normal limit.</option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-9">
                                        <label for="">PLATELET</label>
                                        <select class="form-control select2" name="platelet[]" tabindex="35">
                                            <option selected disabled>select</option>
                                            <option value="Adequate on smear with clumps">Adequate on smear with clumps
                                            </option>
                                            <option value="Adequate on smear">Adequate on smear</option>
                                            <option value="Adequate with large platelets">Adequate with large platelets
                                            </option>
                                            <option value="Adequate with normal morphology">Adequate with normal
                                                morphology</option>
                                            <option value="Appears low normal on smear">Appears low normal on smear
                                            </option>
                                            <option value="Appears marginally reduced on smear">Appears marginally
                                                reduced on smear</option>
                                            <option value="Appears reduced on smear">Appears reduced on smear</option>
                                            <option value="Low normal on smear">Low normal on smear</option>
                                            <option
                                                value="Marginally  reduced on smear and also in small clumps, Giant platelet noted">
                                                Marginally reduced on smear and also in small clumps, Giant platelet
                                                noted</option>
                                            <option value="Marginally  reduced on smear">Marginally reduced on smear
                                            </option>
                                            <option value="Markedly reduced on smear">Markedly reduced on smear</option>
                                            <option value="Mildly reduced on smear">Mildly reduced on smear</option>
                                            <option value="Plentiful on smear">Plentiful on smear</option>
                                            <option value="Reduced markedly on smear">Reduced markedly on smear</option>
                                            <option value="Reduced mildly on smear">Reduced mildly on smear </option>
                                            <option value="Reduced moderately on smear">Reduced moderately on smear
                                            </option>
                                            <option value="Reduced on smear">Reduced on smear</option>
                                            <option value="See next page">See next page</option>
                                            <option value="Thrombocytopenia seen">Thrombocytopenia seen</option>
                                            <option value="Thrombocytosis on smear">Thrombocytosis on smear</option>
                                            <option value="Thrombopenia">Thrombopenia</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Malaria Parasite">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="36">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Malaria Antigen P.V.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="37">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Malaria Antigen P.F.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="38">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Malaria Parasite">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="39">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Mantoux">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="40">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Tuppd">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="41">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Induration After">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="42">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Glucose (Fasting)">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="43">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="<110">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Glucose (Random)">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="44">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="80 - 120">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Glucose (PP)">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]" tabindex="45">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option disabled selected>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="< 140">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor" rows="10" placeholder="Notes" name="notes"></textarea>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="save"
                                        tabindex="38">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
        <!-- Upload Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title"><strong>Upload Reports</strong></h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>

                <div class="box-body">
                    <!-- Main content -->
                    <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                    <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                    <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                    <input class="form-control" type="hidden" name="servname" value="<?php echo $servname; ?>">
                                    <input class="form-control" type="hidden" value="Hematology" name="modality">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="file" name="file[]" required class="form-control" id="file"
                                                accept=".jpeg,.jpg,.png,.pdf,.webp" multiple>
                                        </div>
                                    </div>
                                    <br>
                                    <center>
                                        <button class="btn btn-md btn-primary" type="submit" name="Filesave"
                                            tabindex="38">SAVE</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    
    $sql = "MERGE INTO PathoReport AS target
            USING (VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)) AS source (rno, pname, opid, servname, subtest, unit, normrang, inval, status, addedBy, notes, modality, subgroup)
            ON target.rno = source.rno AND target.subtest = source.subtest
            WHEN MATCHED THEN
                UPDATE SET target.pname = source.pname, target.opid = source.opid, target.servname = source.servname, 
                           target.unit = source.unit, target.normrang = source.normrang, target.inval = source.inval, 
                           target.status = source.status, target.addedBy = source.addedBy, target.notes = source.notes, 
                           target.modality = source.modality, target.subgroup = source.subgroup
            WHEN NOT MATCHED THEN
                INSERT (rno, pname, opid, servname, subtest, unit, normrang, inval, status, addedBy, notes, modality, subgroup)
                VALUES (source.rno, source.pname, source.opid, source.servname, source.subtest, source.unit, 
                        source.normrang, source.inval, source.status, source.addedBy, source.notes, source.modality, 
                        source.subgroup);";

    $stmt = sqlsrv_prepare($conn, $sql, array(&$rno, &$pname, &$opid, &$servname, &$subtest, &$unit, &$normrang, &$inval, &$status, &$login_username, &$notes, &$modality, &$subgroup));

    if (!$stmt) {
        die("Statement preparation failed: " . print_r(sqlsrv_errors(), true));
    }

    foreach ($_POST['inval'] as $i => $inval) {
        if (!empty($inval)) {
            $rno = isset($_POST['rno']) ? $_POST['rno'] : '';
            $pname = isset($_POST['pname']) ? $_POST['pname'] : '';
            $opid = isset($_POST['opid']) ? $_POST['opid'] : '';
            $servname = isset($_POST['servname']) ? $_POST['servname'] : '';
            $subtest = isset($_POST['subtest'][$i]) ? $_POST['subtest'][$i] : '';
            $unit = isset($_POST['unit'][$i]) ? $_POST['unit'][$i] : '';
            $normrang = isset($_POST['normrang'][$i]) ? $_POST['normrang'][$i] : '';
            $status = isset($_POST['status'][$i]) ? $_POST['status'][$i] : '';
            $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
            $modality = isset($_POST['modality']) ? $_POST['modality'] : '';
            $subgroup = isset($_POST['subgroup']) ? $_POST['subgroup'] : '';
            // $rcb = isset($_POST['rcb'][$i]) ? $_POST['rcb'][$i] : '';
            // $wbc = isset($_POST['wbc'][$i]) ? $_POST['wbc'][$i] : '';
            // $platelet = isset($_POST['platelet'][$i]) ? $_POST['platelet'][$i] : '';

            if (!sqlsrv_execute($stmt)) {
                die("Statement execution failed: " . print_r(sqlsrv_errors(), true));
            } else {
                echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href = "HematologyPdf2?rno=' . $rno . '&id=' . $id . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}


include ('footer.php');
?>

<!-- Upload File Format -->
<script>
    const fileInput = document.getElementById('file');
    fileInput.addEventListener('change', () => {
        const allowedExtensions = /(\.jpeg|\.jpg|\.png|\.pdf|\.webp)$/i;
        const maxSizeMB = 5;
        const fileSizeMB = fileInput.files[0].size / (1024 * 1024);
        const fileName = fileInput.value;
        if (!allowedExtensions.exec(fileName)) {
            swal({
                title: 'Invalid!',
                text: 'Invalid file format. Only PDF, WEBP, JPEG, JPG and PNG files are allowed.',
                icon: 'error',
                button: 'Ok',
            });
            fileInput.value = '';
            return false;
        } else if (fileSizeMB > maxSizeMB) {
            swal({
                title: 'Invalid!',
                text: 'File size exceeds the maximum allowed size of 5 MB.',
                icon: 'error',
                button: 'Ok',
            });
            fileInput.value = '';
            return false;
        }
    });
</script>
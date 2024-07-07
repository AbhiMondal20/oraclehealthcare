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
FROM billing AS b INNER JOIN registration AS r ON b.rno = r.rno WHERE b.id = '$id' AND b.rno = '$rno'";
$res = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    $id = $row['id'];
    $opid = $row['opid'];
    $pname = $row['pname'];
    $servname = $row['servname'];
    $age = $row['rage'];
    $gender = $row['rsex'];
    $doc = $row['rdoc'];
}

$inval = array();
$subtest = array();

// Assuming you have fetched $rno, $opid, $pname, and $servname from somewhere

$sql = "SELECT servname, subtest, unit, inval, status FROM PathoReport WHERE rno = '$rno' AND opid = '$opid' AND pname = '$pname' AND servname = '$servname'";
$res = mysqli_query($conn, $sql);
if ($res === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    $inval[] = array(
        'subtest' => $row['subtest'],
        'value' => $row['inval']
    );
    $subtest[] = $row['subtest'];
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

        <!-- LFT Test Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Reg. No: &nbsp;
                        <?php echo $rno ?>&nbsp;&nbsp;&nbsp;
                        OP Id: &nbsp;
                        <?php echo $opid ?>
                        &nbsp;&nbsp;&nbsp;Name: &nbsp;&nbsp;&nbsp;
                        <?php echo $pname ?>&nbsp;/
                        <?php echo $age ?>&nbsp;/
                        <?php echo $gender; ?>&nbsp;&nbsp;&nbsp;Doctor: &nbsp;
                        <?php echo $doc ?>&nbsp;&nbsp;<strong style="background-color: #22cab9;">Test Reports:
                            &nbsp;&nbsp;
                            <?php echo $servname; ?>
                        </strong>
                    </h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-12" style="max-height: 450px; overflow-x: scroll;">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
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
                            <form method="POST" enctype="multipart/form-data">
                                <h3 for="">LIVER FUNCTION TEST</h3>
                                <div class="form-group row">
                                    <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                    <input class="form-control" type="hidden" name="pname"
                                        value="<?php echo $pname; ?>">
                                    <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                    <input class="form-control" type="hidden" name="subgroup"
                                        value="LIVER FUNCTION TEST">
                                    <input class="form-control" type="hidden" name="servname"
                                        value="<?php echo $servname; ?>">
                                    <input class="form-control" type="hidden" value="Biochemistry" name="modality">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Bilirubin (T)") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Bilirubin (T)" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="1" onchange="updateIntval()"
                                            id="bilirubin">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="0.3 - 1.0 mg/dL" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Conjugated") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Conjugated"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="2" id="conjugated"
                                            onchange="updateIntval()">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="0.1 - 0.3 mg/dL" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Unconjugated") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>

                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Unconjugated"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="3" onchange="updateIntval()"
                                            id="unconjugated">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="0.2 - 0.7 mg/dl." readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum GOT") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum GOT"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="4">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="U/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="10-35(M),10-31(F) U/L" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum GPT") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum GPT"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="5">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="U/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="09-43(M),09-33(F) U/L" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Alkaline Phosphatase") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Alkaline Phosphatase" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="6">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="U/L. " readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="< 258 U/L. "
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Total Protein") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Total Protein"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" id="totalprotin" onchange="Intvalp()"
                                            tabindex="7">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl."
                                            onchange="Intvalp()" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value=" 5.5 - 8.0 mg/dl." readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Albumin") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Albumin"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="8" onchange="Intvalp()"
                                            id="albumin">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="gm/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="3.5 - 5.5 gm/dl." readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Globulin") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Globulin"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="9" id="Globulin">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="gm/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value=" 2.8 - 3.5 Ratio" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';

                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "AG Ratio") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="AG Ratio"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" id="agration" onchange="Intvalp()"
                                            tabindex="10">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" readonly value="Ratio">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="1.1 and 2.5"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum GGT") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum GGT"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="11">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="U/L." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="00  - 50"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor" rows="10" placeholder="Notes" name="notes"></textarea>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="LFTsave"
                                        tabindex="38">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>

        <!-- ELECTROLYTES Test Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">ELECTROLYTES</h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-12" style="max-height: 450px; overflow-x: scroll;">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
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
                            <form method="POST" enctype="multipart/form-data">
                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup" value="ELECTROLYTES">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" value="Biochemistry" name="modality">
                                <div class="form-group row">
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Sodium") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum Sodium"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="12">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mEq/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="136 - 145 mEq/L" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Sodium") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum Potassium"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value ?>" tabindex="13">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mEq/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="3.5 - 5.0 mEq/L" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Chloride") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum Chloride"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="14">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mEq/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="98 - 106 mEq/L"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Bicarbonate") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Bicarbonate" readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="15">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mEq/L" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="22 - 30 mEq/L"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor1" rows="10" placeholder="Notes" name="notes"></textarea>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="ELEsave"
                                        tabindex="38">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>

        <!-- LIPID PROFILE TEST Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">LIPID PROFILE TEST</h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-12" style="max-height: 450px; overflow-x: scroll;">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
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
                            <form method="POST" enctype="multipart/form-data">
                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup" value="LIPID PROFILE TEST">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" value="Biochemistry" name="modality">
                                <?php
                                $value = '';
                                foreach ($inval as $item) {
                                    if ($item['subtest'] === "Serum Cholestrol") {
                                        $value = $item['value'];
                                        break;
                                    }
                                }
                                ?>
                                <div class="form-group row mt-3">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Cholestrol" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" id="cholestrol" onchange="UpdateLipid()" tabindex="16">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg./dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="150-260 mg./dl." readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Triglycerides") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Triglycerides" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" id="triglycerides" onchange="UpdateLipid()" tabindex="17">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg./dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="65-170 mg./dl. " readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum H.D.L. Cholesterol") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum H.D.L. Cholesterol" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" id="hdlCholesterol" onchange="UpdateLipid()" tabindex="18">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg./dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="35-80(M),42-88(F)" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum L.D.L. Cholesterol") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum L.D.L. Cholesterol" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" id="ldlCholesterol" onchange="UpdateLipid()" tabindex="19">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="gm/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="Desirable <130 " readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum V.L.D.L. Cholesterol") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum V.L.D.L. Cholesterol" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" onchange="UpdateLipid()"
                                            id="vldlcholesterol" name="inval[]" value="<?php echo $value; ?>"
                                            tabindex="20">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="gm/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Cholesterol /HDL ratio") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Cholesterol /HDL ratio" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" onchange="UpdateLipid()" id="cholestrolHDL"
                                            tabindex="21">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
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
                                            value="<3 in low,  3-5 in avg , >5 in high risk" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum LDL/HDL ratio") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum LDL/HDL ratio" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="22" id="LDLHDL">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
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
                                        <input class="form-control" type="text" name="normrang[]" value="(1.5 - 3.5 )"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor2" rows="10" placeholder="Notes" name="notes"></textarea>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="LIPIDsave"
                                        tabindex="38">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>

        <!-- UREA/CALCIUM/URIC ACID/CPK TEST Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">UREA/CALCIUM/URIC ACID/CPK</h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>
                <div class="col-12" style="max-height: 450px; overflow-x: scroll;">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
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
                            <form method="POST" enctype="multipart/form-data">
                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup" value="Clinical Biochemistry">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" value="Biochemistry" name="modality">

                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Urea") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum Urea"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="24">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg./dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="12 - 40" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Creatinine") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Creatinine" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="25">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg./dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="Upto 1.5 "
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Calcium") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum Calcium"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="26">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg./dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="8.5-11.0"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Phosphorous") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum Phosphorous" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="28">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="gm/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="2.5-4.8 ">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum  Amylase (37 C)") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum  Amylase (37 C)" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="29">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" name="IU/L.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="Upto  86 "
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum  Lipase  (37 C)") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Serum  Lipase  (37 C)" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="30">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" name="U/L.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="Upto  60 "
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "LDH") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="LDH" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="31">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="U/L." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="230 - 460"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum CPK") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum CPK"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="32">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="IU/L." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="25 - 200"
                                            readonly>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Serum Uric Acid") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="Serum Uric Acid"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="33">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]"
                                            value="3.4 - 7.0(M),2.4 - 5.7(F)" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "G-6-PD") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="G-6-PD"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="34">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="U/gm Hb" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="6.4 - 18.7"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "(HbA1C) Glyco") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="(HbA1C) Glyco"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="35">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="%" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "BUN") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="BUN" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="36">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value="mg/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="6 - 20 "
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "NPN") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="subtest[]" value="NPN" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="37">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status[]" class="form-control">
                                            <option>--Select--</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Abnormal">Abnormal</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="unit[]" value=" mg/dl." readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="normrang[]" value="21 - 44 "
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor3" rows="10" placeholder="Notes"
                                            name="UREAnotes"></textarea>
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
                                    <input class="form-control" type="hidden" name="pname"
                                        value="<?php echo $pname; ?>">
                                    <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                    <input class="form-control" type="hidden" name="servname"
                                        value="<?php echo $servname; ?>">
                                    <input class="form-control" type="hidden" value="Biochemistry" name="modality">

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


<script>

    // WITH ROUND OFF

    //  function updateIntval() {
    //     var bilirubinInput = parseFloat(document.getElementById('bilirubin').value);
    //     var conjugatedInput = parseFloat(document.getElementById('conjugated').value);
    //     var unconjugatedInput = bilirubinInput - conjugatedInput;
    //     // Round off to the nearest integer
    //     var roundedUnconjugated = Math.round(unconjugatedInput);
    //     document.getElementById('unconjugated').value = roundedUnconjugated;
    // }

    // WITHOUT ROUND OFF
    function updateIntval() {
        var bilirubinInput = parseFloat(document.getElementById('bilirubin').value);
        var conjugatedInput = parseFloat(document.getElementById('conjugated').value);
        var unconjugatedInput = (bilirubinInput - conjugatedInput).toFixed(1); // Round to two decimal places
        document.getElementById('unconjugated').value = unconjugatedInput;
    }

    function Intvalp() {
        var totalprotinInput = parseFloat(document.getElementById('totalprotin').value);
        var albuminInput = parseFloat(document.getElementById('albumin').value);
        var ualbuminInput = (totalprotinInput - albuminInput).toFixed(1);
        var Agration = (albuminInput / ualbuminInput).toFixed(1);;
        document.getElementById('Globulin').value = ualbuminInput;
        document.getElementById('agration').value = Agration;
    }

    // LIPIT Profile calculation
    function UpdateLipid() {
        var cholestrolInput = parseFloat(document.getElementById('cholestrol').value);
        var triglyceridesInput = parseFloat(document.getElementById('triglycerides').value);
        var hdlCholesterolInput = parseFloat(document.getElementById('hdlCholesterol').value);
        var tghdl = (triglyceridesInput + hdlCholesterolInput).toFixed(1);
        var totalans = (cholestrolInput - hdlCholesterolInput - (triglyceridesInput / 5)).toFixed(1);
        var vldlvalue = (triglyceridesInput / 5).toFixed(1);
        var schdlc = (cholestrolInput / hdlCholesterolInput).toFixed(1);

        // L.D.L. Cholesterol
        var ldlvalue = document.getElementById('ldlCholesterol').value = totalans;
        //  V.L.D.L. Cholesterol
        document.getElementById('vldlcholesterol').value = vldlvalue;
        // Cholesterol / HDL ratio
        document.getElementById('cholestrolHDL').value = schdlc;
        // LDL/HDL ratio
        var ldlhdlratio = ((ldlvalue) / (hdlCholesterolInput)).toFixed(1);
        document.getElementById('LDLHDL').value = ldlhdlratio;
    }
</script>
<?php

// File Upload Code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Filesave'])) {
    $fileCount = count($_FILES['file']['name']);
    $tmp_dir = './uploads/';
    $img_upload = array();
    $upload_success = true;

    for ($i = 0; $i < $fileCount; $i++) {
        $img_name = $_FILES['file']['name'][$i];
        $thambname = uniqid('', true);
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_size = $_FILES['file']['size'][$i] / (1024 * 1024);
        $img_dir = $tmp_dir . $thambname . "." . $img_ext;

        // Debugging: Print file information
        echo "File name: " . $img_name . "<br>";
        echo "File type: " . $_FILES['file']['type'][$i] . "<br>";
        echo "File size: " . $img_size . " MB<br>";

        if ($img_size > 5) {
            echo "<script>
                swal('Error!', 'Image size is greater than 5 MB.', 'error');
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>";
            $upload_success = false;
            break;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $img_dir)) {
            $img_upload[] = 'uploads/' . $thambname . "." . $img_ext;
        } else {
            $upload_success = false;
            break;
        }
    }

    if ($upload_success) {
        $img_upload_str = implode(', ', $img_upload);

        $rno = isset($_POST['rno']) ? $_POST['rno'] : '';
        $pname = isset($_POST['pname']) ? $_POST['pname'] : '';
        $opid = isset($_POST['opid']) ? $_POST['opid'] : '';
        $servname = isset($_POST['servname']) ? $_POST['servname'] : '';
        $modality = isset($_POST['modality']) ? $_POST['modality'] : '';
        $addedBy = $login_username;

        $sql = "INSERT INTO PathoReport (rno, pname, opid, servname, addedBy, modality, uploadReport) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            die("Error preparing statement: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssssss", $rno, $pname, $opid, $servname, $addedBy, $modality, $img_upload_str);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                swal('Success!', 'Files uploaded successfully.', 'success');
                setTimeout(function(){
                    window.location.href = 'uploadReportPreview?rno=" . $rno . "&modality=" . $modality . "&servname=" . $servname . "';
                }, 1000);
            </script>";
        } else {
            echo "<script>
                swal('Error!', 'Failed to upload files.', 'error');
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>";
        }

        mysqli_stmt_close($stmt);
    }
}



// LFT Code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['LFTsave'])) {
    // SQL statement with ON DUPLICATE KEY UPDATE
    $sql = "INSERT INTO PathoReport (rno, pname, opid, servname, subtest, unit, normrang, inval, status, addedBy, notes, modality, subgroup)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            pname = VALUES(pname), opid = VALUES(opid), servname = VALUES(servname), unit = VALUES(unit), normrang = VALUES(normrang),
            inval = VALUES(inval), status = VALUES(status), addedBy = VALUES(addedBy), notes = VALUES(notes), modality = VALUES(modality),
            subgroup = VALUES(subgroup)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Statement preparation failed: " . mysqli_error($conn));
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
            $addedBy = $login_username;

            mysqli_stmt_bind_param($stmt, "sssssssssssss", $rno, $pname, $opid, $servname, $subtest, $unit, $normrang, $inval, $status, $addedBy, $notes, $modality, $subgroup);
            if (!mysqli_stmt_execute($stmt)) {
                die("Statement execution failed: " . mysqli_error($conn));
            } else {
                echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href = "BiochemistryPdf2?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}


// ELECTROLYTES

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ELEsave'])) {
    // Prepare the SQL statement
    $sql = "INSERT INTO PathoReport (rno, pname, opid, servname, subtest, unit, normrang, inval, status, addedBy, notes, modality, subgroup)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            pname = VALUES(pname), opid = VALUES(opid), servname = VALUES(servname), unit = VALUES(unit), normrang = VALUES(normrang),
            inval = VALUES(inval), status = VALUES(status), addedBy = VALUES(addedBy), notes = VALUES(notes), modality = VALUES(modality),
            subgroup = VALUES(subgroup)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Statement preparation failed: " . mysqli_error($conn));
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
            $addedBy = $login_username;

            mysqli_stmt_bind_param($stmt, "sssssssssssss", $rno, $pname, $opid, $servname, $subtest, $unit, $normrang, $inval, $status, $addedBy, $notes, $modality, $subgroup);
            if (!mysqli_stmt_execute($stmt)) {
                die("Statement execution failed: " . mysqli_error($conn));
            } else {
                echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href = "BiochemistryPdf2?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}



// LIPID PROFILE TEST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['LIPIDsave'])) {
    $sql = "INSERT INTO PathoReport (rno, pname, opid, servname, subtest, unit, normrang, inval, status, addedBy, notes, modality, subgroup)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            pname = VALUES(pname), opid = VALUES(opid), servname = VALUES(servname), unit = VALUES(unit), normrang = VALUES(normrang),
            inval = VALUES(inval), status = VALUES(status), addedBy = VALUES(addedBy), notes = VALUES(notes), modality = VALUES(modality),
            subgroup = VALUES(subgroup)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Statement preparation failed: " . mysqli_error($conn));
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
            $addedBy = $login_username;

            mysqli_stmt_bind_param($stmt, "sssssssssssss", $rno, $pname, $opid, $servname, $subtest, $unit, $normrang, $inval, $status, $addedBy, $notes, $modality, $subgroup);
            if (!mysqli_stmt_execute($stmt)) {
                die("Statement execution failed: " . mysqli_error($conn));
            } else {
                echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href = "BiochemistryPdf2?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}

// UREA/CALCIUM/URIC ACID/CPK PROFILE TEST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UREAnotes'])) {
    $sql = "INSERT INTO PathoReport (rno, pname, opid, servname, subtest, unit, normrang, inval, status, addedBy, notes, modality, subgroup)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
            pname = VALUES(pname), opid = VALUES(opid), servname = VALUES(servname), unit = VALUES(unit), normrang = VALUES(normrang),
            inval = VALUES(inval), status = VALUES(status), addedBy = VALUES(addedBy), notes = VALUES(notes), modality = VALUES(modality),
            subgroup = VALUES(subgroup)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Statement preparation failed: " . mysqli_error($conn));
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
            $addedBy = $login_username;

            mysqli_stmt_bind_param($stmt, "sssssssssssss", $rno, $pname, $opid, $servname, $subtest, $unit, $normrang, $inval, $status, $addedBy, $notes, $modality, $subgroup);
            if (!mysqli_stmt_execute($stmt)) {
                die("Statement execution failed: " . mysqli_error($conn));
            } else {
                echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href = "BiochemistryPdf2?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
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
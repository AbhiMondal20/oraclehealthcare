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
$res = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($res)) {
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
while ($row = mysqli_fetch_array($res)) {
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
                                    <input class="form-control" type="hidden" name="subgroup" value="">
                                    <input class="form-control" type="hidden" name="modality" value="Hematology">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Heamoglobin") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Heamoglobin"
                                            readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="1">
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
                                            value="Men- 13.5-18.0 gm/dl. <br> Women- 11.5-16.4 gm/dl.">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "E.S.R.") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="E.S.R."
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="2">
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
                                        <input type="text" name="normrang[]" class="form-control"
                                            value="Westergren <br> 00-10 mm /1st  hr.">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor" rows="10" placeholder="Notes" name="notes"></textarea>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="HGBsave">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Count -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">Total Count</h4>
                    <ul class="box-controls pull-right">
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
                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup" value="Total Count">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" name="modality" value="Hematology">
                                <div class="form-group row mt-3">
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "R.B.C Count") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="R.B.C Count"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="3">
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
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "W.B.C Count") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="W.B.C Count"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="4">
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
                                    <?php
                                    // update code
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Platelet Count") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Platelet Count"
                                            readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="5">
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

                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor1" rows="10" placeholder="Notes" name="notes"></textarea>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="TCsave">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Absoluate Value -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">Absoluate Value</h4>
                    <ul class="box-controls pull-right">
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
                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup" value="Absolute Value">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" name="modality" value="Hematology">
                                <?php
                                $tests = [
                                    ["PCV", "35-45 %", "%"],
                                    ["MCV", "76-96 fl", "fl"],
                                    ["MCH", "27-33 pg", "pg"],
                                    ["MCHC", "30-35 mg./dl.", "%"],
                                    ["Bleeding Time", "Duke's Method", ""],
                                    ["Minutes", "", ""],
                                    ["Second", "1 - 5 mins", ""],
                                    ["Coagulation Time", "", ""],
                                    ["Minutes", "", ""],
                                    ["Seconds", "2 - 9 mins", "Capillary Method"]
                                ];

                                foreach ($tests as $index => $test) {
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === $test[0]) {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="form-group row mt-3">
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="subtest[]"
                                                value="<?php echo $test[0]; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="inval[]"
                                                value="<?php echo $value; ?>" tabindex="<?php echo $index + 6; ?>">
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
                                            <input class="form-control" type="text" name="unit[]"
                                                value="<?php echo $test[2]; ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="normrang[]"
                                                value="<?php echo $test[1]; ?>" readonly>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <textarea id="editor2" rows="10" placeholder="Notes" name="notes"></textarea>
                                    </div>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="AVsave">SAVE</button>
                                </center>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- DIFFERENCIAL -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">DIFFERENCIAL</h4>
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
                                    <label class="col-form-label">RCB</label>
                                </div>
                            </div>
                            <form method="POST" enctype="multipart/form-data">
                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup" value="DIFFERENCIAL COUNT">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" name="modality" value="Hematology">

                                <div class="form-group row mt-3">
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>

                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Malaria Parasite">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="36">
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
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Antigen P.V.") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Malaria Antigen P.V.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="37">
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
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Antigen P.F.") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]"
                                            value="Malaria Antigen P.F.">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="inval[]"
                                            value="<?php echo $value; ?>" tabindex="38">
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
                                <div class="col-md-12 mb-4">
                                    <textarea id="editor3" rows="10" placeholder="Notes" name="notes"></textarea>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="Dsave">SAVE</button>
                                </center>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DIFFERENCIAL COUNT -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">DIFFERENCIAL COUNT</h4>
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
                                    <label class="col-form-label">RCB</label>
                                </div>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup" value="DIFFERENCIAL COUNT">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" name="modality" value="Hematology">

                                <div class="form-group row mt-3">
                                    <div class="col-md-6">
                                        <input type="text" name="rcb[]" tabindex="27" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="rcb[]" tabindex="28" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-6">
                                        <input type="text" name="rcb[]" tabindex="29" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="rcb[]" tabindex="30" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-6">
                                        <input type="text" name="rcb[]" tabindex="31" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <textarea id="editor8" rows="10" placeholder="Notes" name="notes"></textarea>
                                </div>

                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="DCsave">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MALARIYA PARASITE -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">MALARIYA PARASITE</h4>
                    <ul class="box-controls pull-right">
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
                                <input type="hidden" class="form-control" name="rno" value="<?php echo $rno; ?>">
                                <input type="hidden" class="form-control" name="pname" value="<?php echo $pname; ?>">
                                <input type="hidden" class="form-control" name="opid" value="<?php echo $opid; ?>">
                                <input type="hidden" class="form-control" name="subgroup" value="MALARIYA PARASITE">
                                <input type="hidden" class="form-control" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input type="hidden" class="form-control" name="modality" value="Hematology">
                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="subtest[]"
                                            value="Malaria Parasite">
                                    </div>
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="36">
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
                                        <input class="form-control" type="text" name="subtest[]">
                                    </div>
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="36">
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
                                    <div class="form-group row mt-3">
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="subtest[]">
                                        </div>
                                        <?php
                                        $value = '';
                                        foreach ($inval as $item) {
                                            if ($item['subtest'] === "Malaria Parasite") {
                                                $value = $item['value'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" value="<?php echo $value; ?>"
                                                name="inval[]" tabindex="36">
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
                                </div>
                                <div class="col-md-12 mb-4">
                                    <textarea id="editor5" rows="10" placeholder="Notes" name="notes"></textarea>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="MPsave">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MANTOUX/SUGAR/CUSTOMIZE -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided-up">
                <div class="box-header with-border">
                    <h4 class="box-title">MANTOUX/SUGAR/CUSTOMIZE</h4>
                    <ul class="box-controls pull-right">
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

                                <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                <input class="form-control" type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">
                                <input class="form-control" type="hidden" name="subgroup"
                                    value="MANTOUX/SUGAR/CUSTOMIZE">
                                <input class="form-control" type="hidden" name="servname"
                                    value="<?php echo $servname; ?>">
                                <input class="form-control" type="hidden" name="modality" value="Hematology">

                                <div class="form-group row mt-3">
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]" value="Mantoux">
                                    </div>
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" value="<?php echo $value; ?>" type="text"
                                            name="inval[]" tabindex="40">
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
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="41">
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
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="42">
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
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="43">
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
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="44">
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
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="45">
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
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" name="subtest[]">
                                    </div>
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="45">
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
                                        <input class="form-control" type="text" name="subtest[]">
                                    </div>
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="45">
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
                                        <input class="form-control" type="text" name="subtest[]">
                                    </div>
                                    <?php
                                    $value = '';
                                    foreach ($inval as $item) {
                                        if ($item['subtest'] === "Malaria Parasite") {
                                            $value = $item['value'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" value="<?php echo $value; ?>"
                                            name="inval[]" tabindex="45">
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
                                <div class="col-md-12 mb-4">
                                    <textarea id="editor6" rows="10" placeholder="Notes" name="notes"></textarea>
                                </div>
                                <center>
                                    <button class="btn btn-md btn-primary" type="submit" name="MSCsave">SAVE</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['HGBsave'])) {

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
                        window.location.href = "HematologyPdf?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}

// TCsave
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['TCsave'])) {

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
                        window.location.href = "HematologyPdf?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}

// AVsave

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['AVsave'])) {

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
                        window.location.href = "HematologyPdf?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}


// Dsave
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Dsave'])) {

    $sql = "INSERT INTO PathoReport (rno, pname, opid, servname, subtest, unit, normrang, inval, status, addedBy, notes, modality, subgroup) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
                        window.location.href = "HematologyPdf?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}

// DCsave2
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DCsave'])) {
    if (isset($_POST['rcb']) && is_array($_POST['rcb'])) {

        $sql = "INSERT INTO PathoReport (rno, pname, opid, servname, subtest, rcb, status, addedBy, notes, modality, subgroup)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                pname = VALUES(pname), opid = VALUES(opid), servname = VALUES(servname), subtest = VALUES(subtest), status = VALUES(status), addedBy = VALUES(addedBy), notes = VALUES(notes), modality = VALUES(modality), subgroup = VALUES(subgroup)";

        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            die("Statement preparation failed: " . mysqli_error($conn));
        }

        foreach ($_POST['rcb'] as $i => $rcb) {
            if (!empty($rcb)) {
                $rno = isset($_POST['rno']) ? $_POST['rno'] : '';
                $pname = isset($_POST['pname']) ? $_POST['pname'] : '';
                $opid = isset($_POST['opid']) ? $_POST['opid'] : '';
                $servname = isset($_POST['servname']) ? $_POST['servname'] : '';
                $subtest = isset($_POST['subtest'][$i]) ? $_POST['subtest'][$i] : '';
                $status = isset($_POST['status'][$i]) ? $_POST['status'][$i] : '';
                $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
                $modality = isset($_POST['modality']) ? $_POST['modality'] : '';
                $subgroup = isset($_POST['subgroup']) ? $_POST['subgroup'] : '';
                $addedBy = $login_username;

                mysqli_stmt_bind_param($stmt, "sssssssssss", $rno, $pname, $opid, $servname, $subtest, $rcb, $status, $addedBy, $notes, $modality, $subgroup);

                if (!mysqli_stmt_execute($stmt)) {
                    die("Statement execution failed: " . mysqli_stmt_error($stmt));
                } else {
                    echo '<script>
                        swal("Success!", "", "success");
                        setTimeout(function(){
                            window.location.href = "HematologyPdf?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                        }, 1000);
                    </script>';
                }
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "No valid input values found.";
    }
}

// MPsave
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MPsave'])) {

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
                        window.location.href = "HematologyPdf?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
                    }, 1000);
                </script>';
            }
        }
    }
}

// MSCsave
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MSCsave'])) {

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
                        window.location.href = "HematologyPdf?rno=' . $rno . '&modality=' . $modality . '&subgroup=' . $subgroup . '";
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
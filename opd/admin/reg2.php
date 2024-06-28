<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
if (isset($_GET['rno'])) {
    // $rno = $_GET['rno'];
    $sql = "SELECT rno, opid, se, rdate, rtime, paymentType, rtitle, rfname, rmname, addedBy, rlname, rsex, rage, fname, radd1, radd2, rcity, rdist, rstate, phone, dept, rdoc, rdocname, wamt, rcountry
FROM registration WHERE rno = '$rno'";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $rno = $row['rno'];
        $opid = $row['opid'];
        $se = $row['se'];
        $rdate = $row['rdate'];
        $rtime = $row['rtime'];
        $paymentType = $row['paymentType'];
        $rtitle = $row['rtitle'];
        $rfname = $row['rfname'];
        $rmname = $row['rmname'];
        $rlname = $row['rlname'];
        $rsex = $row['rsex'];
        $rage = $row['rage'];
        $fname = $row['fname'];
        $radd1 = $row['radd1'];
        $radd2 = $row['radd2'];
        $rcity = $row['rcity'];
        $rdist = $row['rdist'];
        $rstate = $row['rstate'];
        $rcity = $row['rcity'];
        $phone = $row['phone'];
        $rdoc = $row['rdoc'];
        $rdocname = $row['rdocname'];
        $wamt = $row['wamt'];
        $dept = $row['dept'];
        $rcountry = $row['rcountry'];
        $addedBy = $row['addedBy'];
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Registration</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Registration </li>
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
                        <form novalidate method="POST" action="">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="controls">
                                            <h5>MR. No. <span class="text-danger">*</span></h5>
                                            <?php
                                            $sql = "SELECT TOP 1 rno FROM registration ORDER BY id DESC";
                                            $stmt = sqlsrv_query($conn, $sql);
                                            if ($stmt === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            } else {
                                                $next_rno = "MR000001";
                                                if (sqlsrv_has_rows($stmt)) {
                                                    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                                    $last_rno = $row['rno'];
                                                    if (!empty($last_rno)) {
                                                        $last_number = intval(substr($last_rno, 2));
                                                        $next_number = $last_number + 1;
                                                        $next_rno = "MR" . str_pad($next_number, 6, "0", STR_PAD_LEFT); // Format next rno
                                                    }
                                                }
                                            }
                                            ?>
                                            <!-- <form action="reg.php" method="GET"> -->
                                            <div class="input-group">
                                                <input type="search" class="form-control" name="rno"
                                                    placeholder="MR000001" class="form-control" required
                                                    value="<?php echo $next_rno; ?>"
                                                    data-validation-required-message="This field is required"
                                                    aria-label="Search" aria-describedby="button-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn" type="submit" id="button-addon3"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-search">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                                        </svg></button>
                                                </div>
                                            </div>
                                            <!-- </form> -->
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>OP No.</h5>
                                            <div class="controls">
                                                <?php
                                                $sql = "SELECT TOP 1 opid FROM registration ORDER BY id DESC";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                } else {
                                                    $next_opid = "000001";
                                                    if (sqlsrv_has_rows($stmt)) {
                                                        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                                        $last_opid = $row['opid'];
                                                        if (!empty($last_opid)) {
                                                            $last_number = intval(substr($last_opid, 2));
                                                            $next_number = $last_number + 1;
                                                            $next_opid = "OP" . str_pad($next_number, 6, "0", STR_PAD_LEFT);
                                                        }
                                                    }
                                                }
                                                ?>
                                                <input type="text" name="opid" placeholder="OP000001"
                                                    class="form-control" required value="<?php echo $next_opid; ?>"
                                                    readonly data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5> <span class="text-danger">*</span></h5>
                                                <input type="text" name="se" class="form-control"
                                                    placeholder="2024-2025" required value="2024-2025" readonly
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Reg. Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" class="form-control" required name="rdate"
                                                    value="<?php echo date('Y-m-d'); ?>"
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
                                                    die(print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $title = $row['title'];
                                                        echo '<option value="' . $title . '">' . $title . '</option>';
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
                                                    tabindex="1"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Middle Name</h5>
                                                <input type="text" class="form-control" name="rmname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Last Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rlname"
                                                    tabindex="2"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Gender <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="rsex" tabindex="3">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Age (Years) <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rage"
                                                    tabindex="4"
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="phone"
                                                    tabindex="5" id="phoneInput" maxlength="10" minlength="10"
                                                    data-validation-required-message="This field is required"
                                                    onblur="checkPhoneNumber()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>F/H/S/D/W <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="fname"
                                                    tabindex="6"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="radd1"
                                                    tabindex="7"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Area </h5>
                                                <input type="text" class="form-control" name="radd2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>City <span class="text-danger">*</span></h5>
                                            <input list="city" name="rcity" id="rcity" class="form-control"
                                                tabindex="8">
                                            <datalist id="city">
                                                <option selected disabled>Select City</option>
                                                <?php
                                                $sql = "SELECT Cityname FROM citymaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $Cityname = $row['Cityname'];
                                                        echo '<option value="' . $Cityname . '">' . $Cityname . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                            <!-- <select class="form-select select2" id="rcity" name="rcity" tabindex="8">
                                                <option selected disabled>Select City</option> -->
                                            <?php
                                            // $sql = "SELECT Cityname FROM citymaster";
                                            // $stmt = sqlsrv_query($conn, $sql);
                                            // if ($stmt === false) {
                                            //     die(print_r(sqlsrv_errors(), true));
                                            // } else {
                                            //     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            //         $Cityname = $row['Cityname'];
                                            //         echo '<option value="' . $Cityname . '">' . $Cityname . '</option>';
                                            //     }
                                            // }
                                            ?>
                                            <!-- </select> -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>District <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="rdist" id="rdist">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>State <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="rstate" id="rstate">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Country <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="rcountry" id="rcountry">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Department</h5>
                                            <input list="deptlist" name="dept" id="dept" tabindex="9"
                                                onchange="getDeptDoctors(this.value)" class="form-control">
                                            <datalist id="deptlist">
                                                <option selected disabled>Select City</option>
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Consult Doctor <span class="text-danger">*</span></h5>
                                            <input list="doctlist" name="rdoc" id="rdoc" required tabindex="10"
                                                onchange="getDocname(this.value)" class="form-control">
                                            <datalist id="doctlist">
                                                <option selected disabled>Select Doctor</option>
                                                <?php
                                                $sql = "SELECT docName FROM docmaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $docName = $row['docName'];
                                                        echo '<option value="' . $docName . '">' . $docName . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Fee <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" name="wamt" id="wamt" required
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Ref. Source </h5>
                                            <input list="rdocnamelist" name="rdocname" class="form-control">
                                            <datalist id="rdocnamelist">
                                                <option selected disabled>Select Doctor</option>
                                                <?php
                                                $sql = "SELECT docName FROM docmaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $docName = $row['docName'];
                                                        echo '<option value="' . $docName . '">' . $docName . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Patient Type </h5>
                                            <select class="form-select" name="runit" tabindex="11">
                                                <option selected disabled>Select</option>
                                                <option value="CAMP">CAMP</option>
                                                <option value="EMG">EMG</option>
                                                <option value="MLC">MLC</option>
                                                <option value="REF">REF</option>
                                                <option value="WALK-IN">WALK-IN</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Payment Type <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="paymentType" required tabindex="12">
                                                <option value="Cash">Cash</option>
                                                <option value="Card">Card</option>
                                                <option value="NEFT">NEFT</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Credit">Credit</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="addedBy"
                                        value="<?php echo $login_username; ?>">
                                </div>
                            </div>
                            <center>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="save" tabindex="13">SAVE</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
</section>
</div>
</div>
<!-- /.content-wrapper -->
<script>

    // City to dist Dependency
    $(document).ready(function () {
        $('#rcity').change(function () {
            var selectedCity = $(this).val();
            getDistrictStateCountry(selectedCity);
        });

        function getDistrictStateCountry(rcity) {
            $.ajax({
                url: "load/get_dist.php",
                type: "POST",
                data: { rcity: rcity },
                dataType: "json",
                success: function (data) {
                    $("#rdist").val(data.distname);
                    $("#rstate").val(data.state);
                    $("#rcountry").val(data.country);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });


    function getDeptDoctors(dept) {
        $.ajax({
            url: "load/doc_fetch_by_dept.php",
            type: "POST",
            data: { dept: dept },
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    console.error(data.error);
                } else {
                    var dataList = $('#doctlist');
                    dataList.empty(); // Clear existing options
                    dataList.append('<option selected disabled>Select Doctor</option>');
                    $.each(data, function (index, doctor) {
                        dataList.append($('<option>', {
                            value: doctor.docName,
                            text: doctor.docName
                        }));
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        $('#dept').change(function () {
            $('#wamt').val('');
        });

        $('#rdoc').change(function () {
            $('#wamt').val('');
        });
    });

    // Function to fetch fee for the selected doctor
    function getDocname(docName) {
        if (!docName) {
            // If no doctor is selected, clear the fee input field
            $("#wamt").val('');
            return; // Exit the function early
        }

        $.ajax({
            url: "load/doc_fetch_price.php",
            type: "POST",
            data: { docName: docName },
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    console.error(data.error);
                } else {
                    $("#wamt").val(data.fee);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }


    // Mobile number check
    function checkPhoneNumber() {
        var phoneNumber = document.getElementById('phoneInput').value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "exists") {
                    swal({
                        title: 'Phone number already registered!',
                        text: 'Please enter a different phone number.',
                        icon: 'warning',
                        button: 'OK',
                    });
                    document.getElementById('phoneInput').value = '';
                }
            }
        };
        xhttp.open("GET", "load/checkPhoneNumber.php?phoneNumber=" + phoneNumber, true);
        xhttp.send();
    }
</script>

<?php
if (isset($_POST['save'])) {
    $rno = $_POST['rno'];
    $opid = $_POST['opid'];
    $se = $_POST['se'];
    $rdate = $_POST['rdate'];
    $rtime = date('H:i:s A');
    // payment type = status
    $paymentType = $_POST['paymentType'];
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
    $phone = $_POST['phone'];
    $rdoc = $_POST['rdoc'];
    $rdocname = $_POST['rdocname'];
    $wamt = floatval($_POST['wamt']);
    $dept = $_POST['dept'];
    $rcountry = $_POST['rcountry'];
    $addedBy = $_POST['addedBy'];

    $sql = "INSERT INTO registration (rno, opid, se, rdate, rtime, paymentType, rtitle, rfname, rmname, addedBy, rlname, rsex, rage, fname, radd1, radd2, rcity, rdist, rstate, phone, dept, rdoc, rdocname, wamt, rcountry) 
    VALUES ('$rno', '$opid', '$se', '$rdate', '$rtime', '$paymentType', '$rtitle', '$rfname', '$rmname', '$addedBy', '$rlname', '$rsex', '$rage', '$fname', '$radd1', '$radd2', '$rcity', '$rdist', '$rstate', '$phone', '$dept', '$rdoc', '$rdocname', '$wamt', '$rcountry')";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href="reg-pdf?opid=' . $opid . '&rno=' . $rno . '";
                    }, 1000);
              </script>';
    }
}

// window.location.href = "reg-pdf?opid=' . $opid . '&rno=' . $rno . '";
// window.open("http://server/Reports/report/registration_receipt", "_blank");
// window.location.href="reg-pdf?opid=' . $opid . '&rno=' . $rno . '";
// setTimeout(function(){
//     windows.location.href="http://server/Reports/report/registration_receipt";
// }, 1000);


include ('footer.php');

?>
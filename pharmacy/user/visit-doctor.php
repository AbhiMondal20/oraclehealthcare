<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
$next_rno = $_GET['rno'];
$sql = "SELECT rno, se,opid, rdate, rtime, paymentType, rtitle, rfname, rmname, addedBy, rlname, rsex, rage, fname, radd1, radd2, rcity, rdist, rstate, phone, dept, rdoc, rdocname, wamt, rcountry
FROM registration WHERE rno = '$next_rno'";
$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $se = $row['se'];
    $rdate = $row['rdate'];
    $opid = $row['opid'];
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

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Revisit</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Revisit </li>
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
                                    <div class="col-md-3">
                                        <div class="controls">
                                            <h5>MR. No. <span class="text-danger">*</span></h5>
                                            <input type="text" name="rno" placeholder="MR000001" class="form-control"
                                                required value="<?php echo $next_rno; ?>" readonly
                                                data-validation-required-message="This field is required">
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>OP No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="opid" placeholder="OP000001"
                                                    class="form-control" required value="<?php echo $opid; ?>"
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
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $se; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Revisit Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" class="form-control" required name="revisitDate"
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
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                } else {
                                                    while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
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
                                                <input type="text" class="form-control " required name="rfname"
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $rfname; ?>">
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
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $rlname; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Gender <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="rsex">
                                                <option value="Male" <?php if ($rsex == 'Male')
                                                    echo ' selected'; ?>>Male
                                                </option>
                                                <option value="Female" <?php if ($rsex == 'Female')
                                                    echo ' selected'; ?>>
                                                    Female</option>
                                                <option value="Others" <?php if ($rsex == 'Others')
                                                    echo ' selected'; ?>>
                                                    Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Age (Years) <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rage"
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $rage; ?>">
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
                                                    id="phoneInput" maxlength="10" minlength="10"
                                                    value="<?php echo $phone; ?>" required
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
                                                    value="<?php echo $radd1; ?>" required
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Area </h5>
                                                <input type="text" class="form-control" name="radd2"
                                                    value="<?php echo $radd2; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>City <span class="text-danger">*</span></h5>
                                            <input list="city" name="rcity" required id="rcity" class="form-control"
                                                tabindex="8" value="<?php echo $rcity; ?>">
                                            <datalist id="city">
                                                <option selected disabled>Select City</option>
                                                <?php
                                                $sql = "SELECT Cityname FROM citymaster";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                } else {
                                                    while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                                        $Cityname = $row['Cityname'];
                                                        echo '<option value="' . $Cityname . '"';
                                                        if ($Cityname == $rcity) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . $Cityname . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>District <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" required name="rdist" id="rdist"
                                                value="<?php echo $rdist; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>State <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" required name="rstate" id="rstate"
                                                value="<?php echo $rstate; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Country <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" required name="rcountry"
                                                id="rcountry" value="<?php echo $rcountry; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Department</h5>
                                            <input list="deptlist" name="dept" id="dept" tabindex="9"
                                                onchange="getDeptDoctors(this.value)" class="form-control" value="<?php echo $dept; ?>">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Consult Doctor <span class="text-danger">*</span></h5>
                                            <input list="doctlist" name="rdoc" id="rdoc" required tabindex="10"
                                                onchange="getDocname(this.value)" class="form-control" value="<?php echo $rdoc; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Fee</h5>
                                                <input type="text" class="form-control" name="wamt"
                                                    value="<?php echo $wamt; ?>" id="wamt" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Visit Type </h5>
                                            <select class="form-select" name="visitType" id="visit-type"
                                                onchange="updateFee()">
                                                <option value="Re Visit">Re Visit</option>
                                                <option value="Main Visit">Main Visit</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Ref. Source <span class="text-danger">*</span></h5>
                                            <input list="rdocnamelist" name="rdocname" class="form-control" value="<?php echo $rdocname; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Patient Type </h5>
                                            <select class="form-select select2" name="runit">
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
                                            <select class="form-select select2" name="paymentType" required>
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
</section>
</div>
</div>
<!-- /.content-wrapper -->

<!-- Visit Revisit script -->
<script>
    function updateFee() {
        var visitType = document.getElementById('visit-type').value;
        var feeInput = document.getElementById('wamt');

        if (visitType === 'Re Visit') {
            feeInput.value = '0';
            feeInput.setAttribute('readonly', true);
        } else {
            feeInput.removeAttribute('readonly');
            feeInput.value = "<?php echo $wamt; ?>";
        }
    }
    updateFee();
</script>

<!-- City Dist State Country Script -->
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

</script>
<!-- Dept Dr. List Script -->
<script>
    $(document).ready(function () {
        // Function to fetch doctors for the selected department
        $('#dept').change(function () {
            var dept = $(this).val();
            $.ajax({
                url: "load/doc_fetch_by_dept.php",
                type: "POST",
                data: { dept: dept },
                dataType: "json",
                success: function (data) {
                    $('#rdoc').empty().append('<option selected disabled>Select Doctor</option>');
                    $.each(data, function (index, doctor) {
                        $('#rdoc').append('<option value="' + doctor.docName + '">' + doctor.docName + '</option>');
                    });
                    $('#wamt').val('');
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Function to fetch fee for the selected doctor
        $('#rdoc').change(function () {
            var docName = $(this).val();
            if (!docName) {
                $('#wamt').val('');
                return;
            }
            $.ajax({
                url: "load/doc_fetch_price.php",
                type: "POST",
                data: { docName: docName },
                dataType: "json",
                success: function (data) {
                    $('#wamt').val(data.fee);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Function to get department for the selected doctor
        // function getDocDept(docName) {
        //     $.ajax({
        //         url: "load/doc_fetch_dept.php",
        //         type: "POST",
        //         data: { docName: docName },
        //         dataType: "json",
        //         success: function (data) {
        //             $('#dept').val(data.dept);
        //         },
        //         error: function (xhr, status, error) {
        //             console.error(xhr.responseText);
        //         }
        //     });
        // }
    });


</script>

<!-- Dr Fee Script -->
<script>
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
</script>
<!-- // Mobile number check -->
<script>
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
    // Validate and sanitize user input
    $rno = isset($_POST['rno']) ? $_POST['rno'] : '';
    $opid = isset($_POST['opid']) ? $_POST['opid'] : '';
    $visitType = isset($_POST['visitType']) ? $_POST['visitType'] : '';
    $revisitDate = isset($_POST['revisitDate']) ? $_POST['revisitDate'] : '';

    // Perform any additional validation as needed

    // Prepare the SQL statement using prepared statements to prevent SQL injection
    $sql = "UPDATE registration SET visitType = ?, visitDate = ? WHERE rno = ? AND opid = ?";
    $params = array($visitType, $revisitDate, $rno, $opid);
    $stmt = mysqli_prepare($conn, $sql, $params);

    // Execute the prepared statement
    if ($stmt === false) {
        die(print_r(mysqli_errors(), true));
    }

    if (mysqli_execute($stmt) === false) {
        die(print_r(mysqli_errors(), true));
    } else {
        // Output success message and redirect to PDF page
        echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href="revisit-pdf?opid=' . $opid . '&rno=' . $rno . '";
                    }, 1000);
              </script>';
    }

    // Clean up resources
    mysqli_free_stmt($stmt);
}

// window.location.href = "reg-pdf?opid=' . $opid . '&rno=' . $rno . '";
// window.open("http://server/Reports/report/registration_receipt", "_blank");
// window.location.href="reg-pdf?opid=' . $opid . '&rno=' . $rno . '";
// setTimeout(function(){
//     windows.location.href="http://server/Reports/report/registration_receipt";
// }, 1000);


include ('footer.php');

?>
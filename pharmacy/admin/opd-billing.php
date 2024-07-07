<?php
session_start();
if (isset ($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$rno = "";
$id = "";
if (isset ($_GET['id']) && isset ($_GET['rno'])) {
    $id = $_GET['id'];
    $rno = $_GET['rno'];
}
$rdate = "";
$rtitle = "";
$rtime = "";
$se = "";
$rfname = "";
$rmname = "";
$rlname = "";
$rstatus = "";
$fname = "";
$rsex = "";
$rage = "";
$fname = "";
$rrace = "";
$radd1 = "";
$radd2 = "";
$rcity = "";
$rdoc = "";
$rdist = "";
$rstate = "";
$rcountry = "";
$wamt = "";
$sql = "SELECT id, rno, rdate, rtime, rstatus,rtitle, se, rdoc, rfname, rmname, rlname, fname, rsex, rage, fname, rrace, radd1, radd2, rcity, rdist, rstate, rcountry, wamt
FROM registration WHERE rno = '$rno' AND id = '$id'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die (print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $rstatus = $row['rstatus'];
    $rno = $row['rno'];
    $rdate = $row['rdate']->format('Y-m-d');
    $rtitle = $row['rtitle'];
    $rtime = $row['rtime'];
    $se = $row['se'];
    $rfname = $row['rfname'];
    $rmname = $row['rmname'];
    $rlname = $row['rlname'];
    $fname = $row['fname'];
    $rsex = $row['rsex'];
    $rage = $row['rage'];
    $fname = $row['fname'];
    $rrace = $row['rrace'];
    $radd1 = $row['radd1'];
    $radd2 = $row['radd2'];
    $rcity = $row['rcity'];
    $rdoc = $row['rdoc'];
    $rdist = $row['rdist'];
    $rstate = $row['rstate'];
    $rcountry = $row['rcountry'];
    $wamt = $row['wamt'];
}
?>
<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">OPD Billing</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="reg-list"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Billing</li>
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
                        <div class="col-lg-12">
                            <form novalidate method="POST" action="">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>OPD / IPD <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="rstatus">
                                                <option value="OPD" <?php if ($rstatus == 'OPD')
                                                    echo ' selected'; ?>>OPD
                                                </option>
                                                <option value="IPD" <?php if ($rstatus == 'IPD')
                                                    echo ' selected'; ?>>IPD
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Reg. No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="rno" placeholder="Reg. No" class="form-control"
                                                    required value="<?php echo $rno; ?>" readonly
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="pname"
                                                    value="<?php echo $rfname; ?> <?php echo $rmname; ?> <?php echo $rlname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" name="phone"
                                                    value="<?php echo $rrace; ?>" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Doctor <span class="text-danger">*</span></h5>
                                            <select class="form-select select2" name="rdocname">
                                                <?php
                                                $sql = "SELECT docName FROM docmaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die (print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $docName = $row['docName'];
                                                        echo '<option value="' . $docName . '"';
                                                        if ($rdoc == $docName) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . $docName . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <label for="">Bill Details</label>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Bill No: <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <?php
                                                $sql = "SELECT TOP 1 billno FROM billingDetails ORDER BY id DESC";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die (print_r(sqlsrv_errors(), true));
                                                } else {
                                                    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                                    $last_billno = $row['billno'];
                                                    if ($last_billno == '') {
                                                        $next_billno = "237495";
                                                    } else {
                                                        $next_billno = strval(intval($last_billno) + 1);
                                                    }
                                                }
                                                ?>
                                                <input type="text" name="billno" placeholder="237495"
                                                    class="form-control" required value="<?php echo $next_billno; ?>"
                                                    readonly data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Bill Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" placeholder="" class="form-control" required
                                                    name="billdate"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="Services">Services</label>
                                        <select class="form-select select2" name="servname[]" id="servname"
                                            onchange="getservname(this.value)">
                                            <option>Select Services</option>
                                            <?php
                                                $sql = "SELECT servname FROM servmaster";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die (print_r(sqlsrv_errors(), true));
                                                } else {
                                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $servname_ = $row['servname'];
                                                        echo "<option value='$servname_'>$servname_</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="Price">Price</label>
                                        <select class="form-select select2" name="servrate[]" id="servrate">
                                            <option>Select Price</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="add"></label>
                                        <button type="button" id="addBtn"
                                            class="btn btn-md btn-primary mt-4">Add</button>
                                    </div>
                                </div>
                                <table
                                    class="table table-bordered table-hover display nowrap margin-top-10 w-p100 dataTable">
                                    <thead>
                                        <tr>
                                            <th>Services</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="TOTAL Amount"
                                                    name="totalPrice" id="totalPrice"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Total Adjusted:</td>
                                            <td><input type="text" class="form-control" placeholder="Total Adjusted"
                                                    name="totalAdj" id="totalAdj"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">GST %:</td>
                                            <td><input type="text" class="form-control" placeholder="GST %" name="gst"
                                                    id="gst"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Bill Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="Bill Amount"
                                                    name="billAmount" id="billAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Paid Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="Paid Amount"
                                                    name="paidAmount" id="paidAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Balance:</td>
                                            <td><input type="text" class="form-control" placeholder="Balance"
                                                    name="balance" id="balance"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Payment Type:</td>
                                            <td>
                                                <select class="form-select select2" name="paymentType">
                                                    <option selected disabled>Payment Type</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Card">Card</option>
                                                    <option value="NEFT">NEFT</option>
                                                    <option value="Cheque">Cheque</option>
                                                    <option value="Credit">Credit</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                        </div>
                        <center>
                            <div class="text-xs-right">
                                <button type="submit" class="btn btn-info" name="billSave">SAVE</button>
                            </div>
                        </center>
                        <div class="text-xs-right mt-4">
                            <!-- <button type="clear" class="btn btn-info">CLEAR</button> -->
                            <button type="button" class="btn btn-info">Total Collection</button>
                            <button type="button" class="btn btn-info">Delivery Report</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target=".bs-example-modal-lg">List of Register Patient</button>
                            <button type="button" class="btn btn-primary">List of Admitted Patient</button>
                            <a href="money-receipt-list" class="btn btn-info">Money Receipt</a>
                            <a href="index" class="btn btn-info"><i class="fa-solid fa-x"></i></a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    const tbodyEl = document.querySelector("tbody");
    const tableEl = document.querySelector("table");
    const addBtn = document.getElementById("addBtn");
    const totalPriceEl = document.getElementById("totalPrice");
    const totalAdjEl = document.getElementById("totalAdj");
    const gstEl = document.getElementById("gst");
    const billAmountEl = document.getElementById("billAmount");
    const paidAmountEl = document.getElementById("paidAmount");
    const balanceEl = document.getElementById("balance");
    let prices = [];
    function calculateTotalPrice() {
        let totalPrice = 0;
        prices.forEach(price => {
            totalPrice += parseFloat(price) || 0;
        });

        const totalAdj = parseFloat(totalAdjEl.value) || 0;
        const gst = parseFloat(gstEl.value) || 0;

        const adjustedTotalPrice = totalPrice - totalAdj;
        const billAmount = adjustedTotalPrice + (adjustedTotalPrice * gst / 100);
        const balance = billAmount - (parseFloat(paidAmountEl.value) || 0);

        totalPriceEl.value = totalPrice.toFixed(2);
        billAmountEl.value = billAmount.toFixed(2);
        balanceEl.value = balance.toFixed(2);
    }

    // Event listeners for input fields to trigger calculation
    const inputs = document.querySelectorAll("#totalPrice, #totalAdj, #gst, #paidAmount");
    inputs.forEach(input => {
        input.addEventListener("input", calculateTotalPrice);
    });

    calculateTotalPrice();

    function onAddRow() {
        const servrate = document.getElementById("servrate").value.replace(/,/g, '');
        const servname = document.getElementById("servname").value;
        const newRow = `
        <tr>
            <td><input class="form-control" type="text" value="${servname}" readonly name="servname[]"></td>
            <td><input class="form-control" type="text" value="${servrate}" readonly name="servrate[]"</td>
            <td><button class="deleteBtn btn-primary btn-md">Delete</button></td>
        </tr>
        `;
        tbodyEl.innerHTML += newRow;
        prices.push(parseFloat(servrate));
        calculateTotalPrice();
    }

    function onDeleteRow(e) {
        if (!e.target.classList.contains("deleteBtn")) {
            return;
        }
        const btn = e.target;
        const row = btn.closest("tr");
        const rowIndex = Array.from(row.parentNode.children).indexOf(row);
        prices.splice(rowIndex, 1);
        row.remove();
        calculateTotalPrice();
    }
    addBtn.addEventListener("click", onAddRow);
    tableEl.addEventListener("click", onDeleteRow);
</script>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST["billSave"])) {
    $rstatus = $_POST["rstatus"];
    $rno = $_POST["rno"];
    $pname = $_POST["pname"];
    $phone = $_POST["phone"];
    $rdocname = $_POST["rdocname"];
    $billno = $_POST["billno"];
    $billdate = $_POST["billdate"];
    $status = $_POST["paymentType"];
    $rows = [];
    $totalPrice = floatval($_POST['totalPrice']);
    $totalAdj = $_POST['totalAdj'];
    $gst = $_POST['gst'];
    $billAmount = $_POST['billAmount'];
    $paidAmount = $_POST['paidAmount'];
    $balance = $_POST['balance'];
    $datetime = date('Y-m-d h:i:sa');
    $sql = "INSERT INTO billingDetails (rstatus, rno, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, gst, billAmount, paidAmount, balance, status, uname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array($rstatus, $rno, $pname, $phone, $rdocname, $billno, $billdate, $totalPrice, $totalAdj, $gst, $billAmount, $paidAmount, $balance, $status, $login_username);
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if ($stmt) {
        if (sqlsrv_execute($stmt)) {
            for ($i = 0; $i < count($_POST['servname']); $i++) {
                $servname = $_POST['servname'][$i];
                $servrate = $_POST['servrate'][$i];
                $sql2 = "INSERT INTO billing (rno, pname, billno, billdate, servname, servrate, uname) VALUES ('$rno', '$pname', '$billno', '$billdate', '$servname', '$servrate', '$login_username')";
                $stmt2 = sqlsrv_prepare($conn, $sql2);
                if ($stmt2) {
                    if (!sqlsrv_execute($stmt2)) {
                        echo '<script>
                                swal("Error!", "Error inserting billing item data.", "error");
                            </script>';
                        exit;
                    }
                } else {
                    echo '<script>
                            swal("Error!", "Error preparing billing item SQL statement.", "error");
                        </script>';
                    exit;
                }
            }
            echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href = "opd-bill-cum-receipt?rno=' . $rno . '&billno=' . $billno . '&billdate=' . $billdate . '";
                        window.open("", "_blank");
                    }, 1000);
                </script>';
        } else {
            echo '<script>
                    swal("Error!", "Error inserting main data.", "error");
                </script>';
        }
    } else {
        echo '<script>
                swal("Error!", "Error preparing main SQL statement.", "error");
            </script>';
    }
}
?>


<!-- load data -->
<script>
    function getservname(servname) {
        console.log(servname);
        $.ajax({
            url: "load/fetch_price.php",
            type: "POST",
            data: { servname: servname },
            dataType: "json",
            success: function (data) {
                var servrateDropdown = $("#servrate");
                servrateDropdown.empty().append('<option value="">-- Price --</option>');
                $.each(data, function (index, servmaster) {
                    servrateDropdown.append('<option value="' + servmaster.servrate + '">' + servmaster.servrate + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        function getServiceRates(servname) {
            console.log(servname);
            $.ajax({
                url: "load/get_fetch_price.php",
                type: "POST",
                data: { servname: servname },
                dataType: "json",
                success: function (data) {
                    var servrateDropdown = $(".getservrate");
                    servrateDropdown.empty().append('<option value="">-- Price --</option>');
                    $.each(data, function (index, servmaster) {
                        servrateDropdown.append('<option value="' + servmaster.getservrate + '">' + servmaster.getservrate + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">List of Register Patient</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example5" class="table nowrap margin-top-10 w-p100">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Reg. No.</th>
                                <th>Reg. Date Time.</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <!-- <th>F/H/S/D/W</th> -->
                                <th>Ph. No</th>
                                <th>City</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT TOP 900 id, rno, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rsex, rage, fname, rrace, radd1, rcity, rdist, wamt, uname
                                    FROM registration 
                                    ORDER BY id DESC";
                            $stmt = sqlsrv_query($conn, $sql);
                            if ($stmt === false) {
                                die (print_r(sqlsrv_errors(), true));
                            }
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $rno = $row['rno'];
                                $id = $row['id'];
                                $rfname = $row['rfname'];
                                ?>
                                <tr>
                                    <td>
                                        <a href="?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                                            class="btn btn-sm btn-primary"><i class="fa-solid fa-file-invoice"></i></a>
                                    </td>
                                    <td>
                                        <?php echo $rno; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['rdate']->format('Y-m-d'); ?>
                                    </td>
                                    <td>
                                        <?php echo $row['fullname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['rsex']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['rage']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['rrace']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['rcity']; ?>
                                    </td>

                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
include ('footer.php');
?>
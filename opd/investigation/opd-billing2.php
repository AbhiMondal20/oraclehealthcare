<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include 'header.php';
date_default_timezone_set("asia/kolkata");

$id = "";
$rno = "";
$opid = "";
$fullname = "";
$rdoc = "";
$phone = "";

if (isset($_GET['opid'])) {
    $opid = $_GET['opid'];
}

if (isset($_GET['rno'])) {
    $rno = $_GET['rno'];
}

$sql = "SELECT id, rno, opid, phone, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rdoc
FROM registration WHERE rno = '$rno' OR opid = '$opid'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $id = $row['id'];
    $rno = $row['rno'];
    $opid = $row['opid'];
    $fullname = $row['fullname'];
    $rdoc = $row['rdoc'];
    $phone = $row['phone'];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
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
                        <form novalidate method="POST" action="">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Reg. No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="rno" placeholder="Reg. No" class="form-control"
                                                    required value="<?php echo $rno; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>OP ID <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="opid" placeholder="OP Id" class="form-control"
                                                    required value="<?php echo $opid; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>First Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="pname"
                                                    value="<?php echo $fullname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Bill Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="datetime" class="form-control" required name="billdate"
                                                value="<?php echo date('Y-m-d H:i'); ?>" data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Phone <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="phone"
                                                    value="<?php echo $phone; ?>"
                                                    data-validation-required-message="This field is required">
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
                                                    die(print_r(sqlsrv_errors(), true));
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
                                                $sql = "SELECT TOP 1 billno FROM billing ORDER BY id DESC";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(sqlsrv_errors(), true));
                                                } else {
                                                    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                                                    $last_rcno = $row['billno'];
                                                    if ($last_rcno == '') {
                                                        $next_rcno = "237495";
                                                    } else {
                                                        $next_rcno = strval(intval($last_rcno) + 1);
                                                    }
                                                }
                                                ?>
                                                <input type="text" name="billno" placeholder="237495"
                                                    class="form-control" required value="<?php echo $next_rcno; ?>"
                                                    readonly data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>PT Category: </h5>
                                            <div class="controls">
                                                <input list="catemasterlist" class="form-control" tabindex="1"
                                                    id="catemaster" name="catemaster" onchange="loadServices()">
                                                <datalist id="catemasterlist">
                                                    <option selected disabled>Select Pt Category</option>
                                                    <?php
                                                    $sql = "SELECT cate FROM catemaster";
                                                    $stmt = sqlsrv_query($conn, $sql);
                                                    if ($stmt === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    } else {
                                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                            $cate = $row['cate'];
                                                            echo "<option value='$cate'>$cate</option>";
                                                        }
                                                    }
                                                    ?>
                                                </datalist>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <form> -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="Services">Services</label>
                                        <input list="servnameslist" id="servname" class="form-control servname"
                                            onchange="getservname(this.value)" tabindex="1">
                                        <datalist id="servnameslist">
                                            <option selected disabled>Select Doctor</option>
                                            <?php
                                            $sql = "SELECT servname FROM servmaster";
                                            $stmt = sqlsrv_query($conn, $sql);
                                            if ($stmt === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            } else {
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                    $servname = $row['servname'];
                                                    echo "<option value='$servname'>$servname</option>";
                                                }
                                            }
                                            ?>
                                        </datalist>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="Price">Price</label>
                                        <input type="text" class="form-control servrate" id="servrate">
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="add"></label>
                                        <button type="button" id="addBtn" tabindex="2"
                                            class="btn btn-md btn-primary mt-4 addBtn">Add</button>
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
                                                    name="totalPrice[]" id="totalPrice"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Total Adjusted:</td>
                                            <td><input type="text" class="form-control" placeholder="Total Adjusted"
                                                    name="totalAdj[]" id="totalAdj" oninput="handleInputChange()"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Discount %:</td>
                                            <td><input type="text" class="form-control" placeholder="Discount %"
                                                    name="discount" id="discount" oninput="handleInputChange()"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Discount Amt.:</td>
                                            <td><input type="text" class="form-control" placeholder="Discount Amt."
                                                    name="totalAdj" id="discountAmt" oninput="handleInputChange()"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Bill Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="Bill Amount"
                                                    name="billAmount[]" id="billAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Paid Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="Paid Amount"
                                                    name="paidAmount[]" id="paidAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Balance:</td>
                                            <td><input type="text" class="form-control" placeholder="Balance"
                                                    name="balance[]" id="balance"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Payment Type:</td>
                                            <td>
                                                <select class="form-select select2" name="status[]">
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
                                <a href="collection" class="btn btn-info">Total Collection</a>
                                <a href="delivery-report" class="btn btn-info">Delivery Report</a>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target=".bs-example-modal-lg">List of Register Patient</button>
                                <button type="button" class="btn btn-primary">List of Admitted Patient</button>
                                <button type="button" class="btn btn-info">Money Receipt</button>
                                <a href="index" class="btn btn-info"><i class="fa-solid fa-x"></i></a>
                            </div>
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
<!-- servname focus -->
<script>
    $(document).on('keydown', '.service-entry input', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 9) {
            var $inputs = $(this).closest('.service-entry').find('input');
            var index = $inputs.index(this);
            if (index === $inputs.length - 1) {
                e.preventDefault();
                var $addBtn = $(this).closest('.service-entry').find('.addBtn');
                $addBtn.focus();
            }
        }
    });

    // Add new service entry
    $(document).on('click', '.addBtn', function () {
        var $serviceEntry = $(this).closest('.service-entry');
        var $clone = $serviceEntry.clone();

        $clone.find('input').val('');

        $('#servname').append($clone);

        $clone.find('.servname').focus();
    });
</script>

<script>
    const tbodyEl = document.querySelector("tbody");
    const tableEl = document.querySelector("table");
    const addBtn = document.getElementById("addBtn");
    const totalPriceEl = document.getElementById("totalPrice");
    const totalAdjEl = document.getElementById("totalAdj");
    const discountEl = document.getElementById("discount");
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
        const discount = parseFloat(discountEl.value) || 0;

        const adjustedTotalPrice = totalPrice - totalAdj;
        const discountAmt = (adjustedTotalPrice * discount / 100).toFixed(2);
        const billAmount = adjustedTotalPrice - discountAmt;
        const balance = billAmount - (parseFloat(paidAmountEl.value) || 0);

        totalPriceEl.value = totalPrice.toFixed(2);
        billAmountEl.value = billAmount.toFixed(2);
        discountAmtEl.value = discountAmt;
        balanceEl.value = balance.toFixed(2);
    }

    const discountAmtEl = document.getElementById("discountAmt");

    const inputs = document.querySelectorAll("#totalPrice, #totalAdj, #discount, #paidAmount");
    inputs.forEach(input => {
        input.addEventListener("input", calculateTotalPrice);
    });

    calculateTotalPrice();
    function onAddRow() {
        const servrate = document.getElementById("servrate").value.replace(/,/g, '');
        const servname = document.getElementById("servname").value;
        const tbody = document.querySelector("tbody");
        if (!tbody) {
            console.error("Table body not found!");
            return;
        }
        const rows = tbody.querySelectorAll("tr");
        if (rows.length === 0) {
            console.log("No rows found in table body!");
        }
        const existingServices = Array.from(rows).map(row => {
            const input = row.querySelector("td:first-child input");
            return input ? input.value : null;
        });

        console.log("Existing services:", existingServices);
        if (existingServices.includes(servname)) {
            console.log("Service already added!");
            swal({
                title: 'Service already added!',
                icon: 'warning',
                button: 'OK',
            });
            return;
        }
        const newRow = `
        <tr>
            <td><input class="form-control" type="text" value="${servname}" readonly name="servnames[]"></td>
            <td><input class="form-control" type="text" value="${servrate}" readonly name="servrates[]"</td>
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
    }

</script>

<script>
    function getservname(servname) {
            $.ajax({
                url: "load/fetch_price.php",
                type: "POST",
                data: { servname: servname },
                dataType: "json",
                success: function (data) {
                    if (data.length > 0) {
                        $("#servrate").val(data[0].servrate);
                    } else {
                        $("#servrate").val("Price not available");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
</script>


<!-- Load catemaster -->
<script>
    function loadServices() {
            var catemaster = document.getElementById('catemaster').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'load/get_services.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Update servnameslist datalist
                        var servnameslist = document.getElementById('servnameslist');
                        servnameslist.innerHTML = "<option selected disabled>Select Doctor</option>";
                        response.servnames.forEach(function (servname) {
                            servnameslist.innerHTML += "<option value='" + servname + "'>" + servname + "</option>";
                        });
                        document.getElementById('servrate').value = response.servrate;
                    } else {
                        console.log(response.error);
                    }
                }
            };
            xhr.send('catemaster=' + catemaster);
        }

</script>
<!-- servname clear and teb retab -->
<script>
    document.getElementById('addBtn').addEventListener('click', function () {
        document.getElementById('servname').value = '';
        document.getElementById('servname').focus();
    });
</script>

<!-- put then totalAdj readolny -->
<script>
    function handleInputChange() {
        var totalAdj = document.getElementById("totalAdj").value;
        var discount = document.getElementById("discount").value;
        var discountAmt = document.getElementById("discountAmt");

        if (totalAdj) {
            document.getElementById("discount").readOnly = true;
            discountAmt.readOnly = true;
        } else if (discount) {
            document.getElementById("totalAdj").readOnly = true;
        } else {
            document.getElementById("discount").readOnly = false;
            discountAmt.readOnly = false;
            document.getElementById("totalAdj").readOnly = false;
        }
    }
</script>
<!-- List of Register Patient -->
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
                                <th>OP Id</th>
                                <th>Reg. Date Time.</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Ph. No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT TOP 900 id, rno, opid, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy
                                    FROM registration
                                    ORDER BY id DESC";
                            $stmt = sqlsrv_query($conn, $sql);
                            if ($stmt === false) {
                                die(print_r(sqlsrv_errors(), true));
                            }
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $id = $row['id'];
                                $rno = $row['rno'];
                                $opid = $row['opid'];
                                $fullname = $row['fullname'];
                                $rdate = $row['rdate'];
                                $rtime = $row['rtime']->format('H:m:i A');
                                $rsex = $row['rsex'];
                                $rage = $row['rage'];
                                $phone = $row['phone'];

                                ?>
                                <tr>
                                    <td>
                                        <a href="?opid=<?php echo $opid; ?>&rno=<?php echo $rno; ?>"
                                            class="btn btn-sm btn-primary"><i class="fa-solid fa-file-invoice"></i></a>
                                    </td>
                                    <td>
                                        <?php echo $rno; ?>
                                    </td>
                                    <td>
                                        <?php echo $opid; ?>
                                    </td>
                                    <td>
                                        <?php echo $rdate; ?>&nbsp;
                                        <?php echo $rtime; ?>
                                    </td>
                                    <td>
                                        <?php echo $fullname; ?>
                                    </td>
                                    <td>
                                        <?php echo $rsex; ?>
                                    </td>
                                    <td>
                                        <?php echo $rage; ?>
                                    </td>
                                    <td>
                                        <?php echo $phone; ?>
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

if (isset($_POST['billSave'])) {
    $rno1 = $_POST['rno'];
    $opid = $_POST['opid'];
    $pname = $_POST['pname'];
    $phone = $_POST['phone'];
    $rdocname = $_POST['rdocname'];
    $billno1 = $_POST['billno'];
    $billdate1 = $_POST['billdate'];
    $totalPrice = $_POST['totalPrice'];
    $totalAdj = $_POST['totalAdj'];
    $discount = $_POST['discount'];
    $billAmount = $_POST['billAmount'];
    $paidAmount = $_POST['paidAmount'];
    $balance = $_POST['balance'];
    // $discountamt = $_POST['discountAmt'];
    $ptCategory = $_POST['catemaster'];
    $username = $login_username;
    $status = isset($_POST["status"]) ? $_POST["status"] : "";

    $sqlMain = "INSERT INTO billingDetails (rno, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, discount, billAmount, paidAmount, balance, status, uname, opid, discountamt, ptCategory) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $paramsMain = array($rno1, $pname, $phone, $rdocname, $billno1, $billdate1, $totalPrice, $totalAdj, $discount, $billAmount, $paidAmount, $balance, $status, $username, $opid, $totalAdj, $ptCategory);
    $stmtMain = sqlsrv_prepare($conn, $sqlMain, $paramsMain);

    if (sqlsrv_execute($stmtMain)) {
        $processedServnames = array();
        foreach ($_POST['servnames'] as $i => $servnames) {
            if (isset($processedServnames[$servnames])) {
                continue;
            }
            $processedServnames[$servnames] = true;
            $rno = $_POST['rno'];
            $opid = $_POST['opid'];
            $billdate = $_POST['billdate'];
            $pname = $_POST['pname'];
            $billno = $_POST['billno'];
            $servrates = $_POST['servrates'][$i];

            $sql = "INSERT INTO billing (rno, pname, billno, billdate, servname, servrate, uname, opid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($rno, $pname, $billno, $billdate, $servnames, $servrates, $username, $opid);
            $stmt = sqlsrv_prepare($conn, $sql, $params);
            if (!sqlsrv_execute($stmt)) {
                die(print_r(sqlsrv_errors(), true));
            }
        }

        echo '<script>
            window.open("mpdfview?rno=' . $rno1 . '&billno=' . $billno1 . '&billdate=' . $billdate1 . '", "_blank");
        </script>';
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}

include 'footer.php';

?>
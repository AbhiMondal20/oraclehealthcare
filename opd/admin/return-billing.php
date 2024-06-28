<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Return Billing</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="reg-list"><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Return</li>
                                <li class="breadcrumb-item active" aria-current="page">Billing</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
        <?php
            $billno = "";
            $rno = "";
            $opid = "";
            $phone = "";
            $rdocname = "";
            $pname = "";

            if (isset($_POST['search'])) {

                $billno = $_POST['billno'];
                $sqlMain = "SELECT rno, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, discount, billAmount, paidAmount, balance, status, uname, opid FROM billingDetails WHERE billno = '$billno'";
                $stmt = sqlsrv_query($conn, $sqlMain);

                if ($stmt === false) {
                    // Handle SQL query error
                    die(print_r(sqlsrv_errors(), true));
                }

                if (sqlsrv_has_rows($stmt)) {
                    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                    $rno = $row['rno'];
                    $opid = $row['opid'];
                    $pname = $row['pname'];
                    $phone = $row['phone'];
                    $rdocname = $row['rdocname'];
                    $billdate1 = $row['billdate'];
                    $totalPrice = $row['totalPrice'];
                    $totalAdj = $row['totalAdj'];
                    $discount = $row['discount'];
                    $billAmount = $row['billAmount'];
                    $paidAmount = $row['paidAmount'];
                    $balance = $row['balance'];
                } else {
                    echo '<script>
                            setTimeout(function(){
                                swal("ERROR!", "No records found for the specified bill number.", "error");
                            }, 1000);
                        </script>';
                }
            }


        ?>
        <!-- else {
            echo '<script>
                setTimeout(function(){
                    swal("ERROR!", "Bill No is not Availabe", "rror");
                }, 1000);
            </script>';
        } -->
        <!-- Main content -->
        <section class="content1 m-4">
            <!-- Basic Forms -->
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h5>Bill No: <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="billno" placeholder="237495"
                                            value="<?php echo $billno; ?>" class="form-control" required
                                            data-validation-required-message="This field is required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="form-group mt-4">
                                    <h5> <span class="text-danger"></span></h5>
                                    <div class="controls ">
                                        <button type="submit" name="search" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </section>
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
                                                    value="<?php echo $pname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Bill Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" class="form-control" required name="billdate"
                                                    value="<?php echo date('Y-m-d'); ?>"
                                                    data-validation-required-message="This field is required">
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
                                                        if ($rdocname == $docName) {
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
                                <!-- <form> -->
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="Services">Services</label>
                                        <input list="servnameslist" id="servname" required class="form-control servname"
                                            onchange="getservname(this.value)" tabindex="1">
                                        <datalist id="servnameslist">
                                            <option selected disabled>Select Doctor</option>
                                            <?php
                                            $sql = "SELECT b.servname 
                                            FROM billing AS b
                                            LEFT JOIN returnBilling AS rb ON b.billno = rb.billno AND b.servname = rb.servname
                                            WHERE b.billno = '$billno' 
                                            AND rb.billno IS NULL";
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
                                        <input type="text" class="form-control servrate" id="servrate" required
                                            readonly>
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
                                            <td><input type="text" class="form-control" required
                                                    placeholder="TOTAL Amount" name="totalPrice[]" id="totalPrice"></td>
                                        </tr>
                                        <tr style="display:none">
                                            <td colspan="2">Total Adjusted:</td>
                                            <td><input type="text" class="form-control" placeholder="Total Adjusted"
                                                    name="totalAdj[]" id="totalAdj"></td>
                                        </tr>
                                        <tr style="display:none">
                                            <td colspan="2">GST %:</td>
                                            <td><input type="text" class="form-control" placeholder="GST %" name="gst[]"
                                                    id="gst"></td>
                                        </tr>
                                        <tr style="display:none">
                                            <td colspan="2">Bill No:</td>
                                            <td><input type="text" class="form-control" value="<?php echo $billno; ?>"
                                                    placeholder="Bill No" name="billno"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Bill Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="Bill Amount"
                                                    name="billAmount[]" id="billAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Return Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="Return Amount"
                                                    name="paidAmount[]" id="paidAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Balance:</td>
                                            <td><input type="text" class="form-control" placeholder="Balance"
                                                    name="balance[]" id="balance"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Remark:</td>
                                            <td>
                                                <input list="statuslist" name="status[]" class="form-control">
                                                <datalist id="statuslist">
                                                    <option value="Refunds">Refunds</option>
                                                    <option value="Services Change">Services Change</option>
                                                </datalist>
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
        // Clear input values
        console.log('Before clearing:', $clone.find('.servname').val());
        $clone.find('.servname').val('');
        $clone.find('.servrate').val('');
        console.log('After clearing:', $clone.find('.servname').val());
        // Append the cloned service entry to the container
        $('#servname').append($clone);
        // Focus on the servname input of the newly added service entry
        $clone.find('.servname').focus();
    });
</script>


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
    const inputs = document.querySelectorAll("#totalPrice, #totalAdj, #gst, #paidAmount");
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

<!-- servname clear and teb retab -->
<script>
    document.getElementById('addBtn').addEventListener('click', function () {
        document.getElementById('servname').value = '';
        document.getElementById('servname').focus();
    });
</script>
<?php
if (isset($_POST['billSave'])) {
    $rno = $_POST['rno'];
    $opid = $_POST['opid'];
    $pname = $_POST['pname'];
    $phone = $_POST['phone'];
    $rdocname = $_POST['rdocname'];
    $billno = $_POST['billno'];
    $billdate = $_POST['billdate'];
    $totalPrice = $_POST['totalPrice'];
    $totalAdj = $_POST['totalAdj'];
    $gst = $_POST['gst'];
    $billAmount = $_POST['billAmount'];
    $paidAmount = $_POST['paidAmount'];
    $balance = $_POST['balance'];
    $username = $login_username;
    $status = isset($_POST["status"]) ? $_POST["status"] : "";

    $sqlMain = "INSERT INTO returnbillingDetails (rno, opid, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, gst, billAmount, paidAmount, balance, status, addedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $paramsMain = array($rno, $opid, $pname, $phone, $rdocname, $billno, $billdate, $totalPrice, $totalAdj, $gst, $billAmount, $paidAmount, $balance, $status, $username);
    $stmtMain = sqlsrv_prepare($conn, $sqlMain, $paramsMain);

    if (sqlsrv_execute($stmtMain)) {
        $processedServnames = array();
        foreach ($_POST['servnames'] as $i => $servnames) {
            if (isset($processedServnames[$servnames])) {
                continue;
            }
            $processedServnames[$servnames] = true;

            // Service name does not exist, proceed with insertion
            $rno = $_POST['rno'];
            $opid = $_POST['opid'];
            $billdate = $_POST['billdate'];
            $pname = $_POST['pname'];
            $billno2 = $_POST['billno'];
            $rdocname = $_POST['rdocname'];
            $servrates = $_POST['servrates'][$i];
            $sql = "INSERT INTO returnBilling (rno, opid, pname, billno, billdate, rdocname, servname, servrate, addedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = array($rno, $opid, $pname, $billno2, $billdate, $rdocname, $servnames, $servrates, $username);
            $stmt = sqlsrv_prepare($conn, $sql, $params);
            if (!sqlsrv_execute($stmt)) {
                die(print_r(sqlsrv_errors(), true));
            }
        }

        $url = "returnBillPDF?rno=$rno&billno=$billno&billdate=$billdate";
        echo '<script>
                    window.open("' . $url . '", "_blank");
                </script>';


    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}


include ('footer.php');
?>
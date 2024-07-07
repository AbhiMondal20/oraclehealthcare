<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

if (isset($_GET['opid']) && isset($_GET['rno'])) {
    $rno = $_GET['rno'];
    $opid = $_GET['opid'];
}

$sql = "SELECT id, rno, opid, rdate, rtime, rfname, se, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, 
rsex, rage, fname, phone, dept, paymentType, radd1, radd2, rcity, rdist, wamt, addedBy, rdoc
FROM registration WHERE rno = '$rno' AND opid = '$opid'";
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
                            <form novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
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
                                            <h5>OP Id <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="opid" placeholder="OP Id" class="form-control"
                                                    required value="<?php echo $opid; ?>" readonly
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="pname"
                                                    value="<?php echo $fullname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" name="phone"
                                                    value="<?php echo $phone; ?>" maxlength="10">
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
                                                $sql = "SELECT TOP 1 billno FROM billingDetails ORDER BY id DESC";
                                                $stmt = sqlsrv_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(sqlsrv_errors(), true));
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
                                                <input type="date" class="form-control" required
                                                    value="<?php echo date('Y-m-d'); ?>" name="billdate"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="Services">Services</label>
                                        <select class="form-select select2" name="sservname[]" id="servname"
                                            tabindex="1" onchange="getservname(this.value)">
                                            <option value="">Select Services</option>
                                            <?php
                                            $sql = "SELECT servname FROM servmaster";
                                            $stmt = sqlsrv_query($conn, $sql);
                                            if ($stmt === false) {
                                                die(print_r(sqlsrv_errors(), true));
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
                                        <input type="text" class="form-control" name="sservrate[]" id="servrate"
                                            readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="add"></label>
                                        <button type="button" id="addBtn" tabindex="2"
                                            class="btn btn-md btn-primary mt-4">Add</button>
                                    </div>
                                </div>
                        </div>
                        <table class="table table-bordered table-hover display nowrap margin-top-10 w-p100 dataTable">
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
                                    <td><input type="text" class="form-control" placeholder="TOTAL Amount" required
                                            name="totalPrice" id="totalPrice"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total Adjusted:</td>
                                    <td><input type="text" class="form-control" placeholder="Total Adjusted"
                                            name="totalAdj" id="totalAdj"></td>
                                </tr>
                                <tr style="display:none">
                                    <td colspan="2">GST %:</td>
                                    <td><input type="text" class="form-control" placeholder="GST %" name="gst" id="gst">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Bill Amount:</td>
                                    <td><input type="text" class="form-control" placeholder="Bill Amount"
                                            name="billAmount" id="billAmount"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Paid Amount:</td>
                                    <td><input type="text" class="form-control" placeholder="Paid Amount" required
                                            name="paidAmount" id="paidAmount"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Balance:</td>
                                    <td><input type="text" class="form-control" placeholder="Balance" name="balance"
                                            id="balance"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Payment Type:</td>
                                    <td>
                                        <select class="form-select select2" name="paymentType" required>
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
        console.log("Adding row...");
        const servrate = document.getElementById("servrate").value.replace(/,/g, '');
        const servname = document.getElementById("servname").value;
        console.log("Service name:", servname);
        console.log("Service rate:", servrate);

        // Check if the table body exists
        const tbody = document.querySelector("tbody");
        if (!tbody) {
            console.error("Table body not found!");
            return;
        }

        // Check if there are existing rows in the table body
        // const rows = tbody.querySelectorAll("tr");
        // if (rows.length === 0) {
        //     console.log("No rows found in table body!");
        // }

        // const existingServices = Array.from(rows).map(row => {
        //     const input = row.querySelector("td:first-child input");
        //     return input ? input.value : null;
        // });
        // console.log("Existing services:", existingServices);
        // if (existingServices.includes(servname)) {
        //     console.log("Service already added!");
        //     swal({
        //         title: 'Service already added!',
        //         icon: 'warning',
        //         button: 'OK',
        //     });
        //     return;
        // }



        // Add service to the table
        const newRow = `
    <tr>
        <td><input class="form-control" type="text" value="${servname}" name="sservname[]" ></td>
        <td><input class="form-control" type="text" value="${servrate}" name="sservrate[]" ></td>
        <td><button class="deleteBtn btn-primary btn-md">Delete</button></td>
    </tr>
    `;
        tbody.innerHTML += newRow;
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
if (isset($_POST["billSave"])) {
    $rno = $_POST["rno"];
    $pname = $_POST["pname"];
    $phone = $_POST["phone"];
    $rdocname = $_POST["rdocname"];
    $billno = $_POST["billno"];
    $billdate = $_POST["billdate"];
    $rows = [];
    $totalPrice = floatval($_POST['totalPrice']);
    $totalAdj = $_POST['totalAdj'];
    $gst = '0';
    $billAmount = $_POST['billAmount'];
    $paidAmount = $_POST['paidAmount'];
    $balance = $_POST['balance'];
    $username = $login_username;
    $status = isset($_POST["paymentType"]) ? $_POST["paymentType"] : "";

    // if ($totalPrice === 0.00 || $paidAmount === 0.00 || $totalPrice === null || $paidAmount === null || $status === null) {
    //     echo '<script>
    //             swal("Error!", "Total Price and Paid Amount should be greater than 0.00.", "error");
    //         </script>';
    // } else {

    // $sqlMain = "INSERT INTO billingDetails ( rno, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, gst, billAmount, paidAmount, balance, status, uname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    // $paramsMain = array($rno, $pname, $phone, $rdocname, $billno, $billdate, $totalPrice, $totalAdj, $gst, $billAmount, $paidAmount, $balance, $status, $username);
    // $stmtMain = sqlsrv_prepare($conn, $sqlMain, $paramsMain);

    // if ($stmtMain) {
    // if (sqlsrv_execute($stmtMain)) {
        $success = true;

        // Loop through each set of values
        for ($i = 0; $i < count($_POST['sservname']); $i++) {
            // Get the values for the current iteration
            $servname = $_POST['sservname'][$i];
            $servrate = $_POST['sservrate'][$i];
        
            // Prepare the SQL statement for the current iteration
            $sqlBilling = "INSERT INTO billing (rno, pname, billno, billdate, servname, servrate, uname) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtBilling = sqlsrv_prepare($conn, $sqlBilling, array(&$rno, &$pname, &$billno, &$billdate, &$servname, &$servrate, &$username));
        
            if (!$stmtBilling) {
                die(print_r(sqlsrv_errors(), true));
            }
        
            // Execute the prepared statement for the current set of values
            if (!sqlsrv_execute($stmtBilling)) {
                $success = false;
                // Print detailed error for the failed execution
                echo '<script>
                            swal("Error!", "Error inserting billing item ' . ($i + 1) . ': ' . sqlsrv_errors()[0]['message'] . '", "error");
                        </script>';
            }
        }
        
        // Check if all insertions were successful
        if ($success) {
            echo '<script>
                        swal("Success!", "", "success");
                        setTimeout(function(){
                            var url = "opd-bill-cum-receipt?rno=' . $rno . '&billno=' . $billno . '&billdate=' . $billdate . '";
                            var link = document.createElement("a");
                            link.href = url;
                            link.target = "_blank";
                            link.click();
                        }, 1000);
                    </script>';
        } else {
            echo '<script>
                        swal("Error!", "Error inserting one or more billing items.", "error");
                    </script>';
        }
    }
// } else {
//     echo '<script>
//         swal("Error!", "Error preparing main SQL statement.", "error");
//     </script>';
// }
// }
// }

?>




<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["billSave"])) {
//     $rstatus = $_POST["rstatus"];
//     $rno = $_POST["rno"];
//     $pname = $_POST["pname"];
//     $phone = $_POST["phone"];
//     $rdocname = $_POST["rdocname"];
//     $billno = $_POST["billno"];
//     $billdate = $_POST["billdate"];
//     $rows = [];
//     $totalPrice = floatval($_POST['totalPrice']);
//     $totalAdj = $_POST['totalAdj'];
//     $gst = '0'; // Assuming you're not using GST for now
//     $billAmount = $_POST['billAmount'];
//     $paidAmount = $_POST['paidAmount'];
//     $balance = $_POST['balance'];
//     $username = $login_username; // Assuming you have this defined elsewhere

//     $status = isset($_POST["paymentType"]) ? $_POST["paymentType"] : ""; 

//     if ($totalPrice === 0.00 || $paidAmount === 0.00 || $totalPrice === null || $paidAmount === null || $status === null) {
//         echo '<script>
//             swal("Error!", "Total Price and Paid Amount should be greater than 0.00.", "error");
//         </script>';
//     } else {
//         // Prepare main SQL statement for billingDetails table
//         $sqlMain = "INSERT INTO billingDetails (rstatus, rno, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, gst, billAmount, paidAmount, balance, status, uname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//         $paramsMain = array($rstatus, $rno, $pname, $phone, $rdocname, $billno, $billdate, $totalPrice, $totalAdj, $gst, $billAmount, $paidAmount, $balance, $status, $username);
//         $stmtMain = sqlsrv_prepare($conn, $sqlMain, $paramsMain);

//         if ($stmtMain) {
//             if (sqlsrv_execute($stmtMain)) {
//                 $success = true;
//                 $sqlBilling = "INSERT INTO billing (rno, pname, billno, billdate, servname, servrate, uname) VALUES (?, ?, ?, ?, ?, ?, ?)";
//                 $stmtBilling = sqlsrv_prepare($conn, $sqlBilling, array(&$rno, &$pname, &$billno, &$billdate, &$servname, &$servrate, &$username));

//                 if (!$stmtBilling) {
//                     die(print_r(sqlsrv_errors(), true));
//                 }

//                 // Loop through each billing item
//                 for ($i = 0; $i < count($_POST['sservname']); $i++) {
//                     $servname = $_POST['sservname'][$i];
//                     $servrate = $_POST['sservrate'][$i];

//                     // Execute the billing statement for each item
//                     if (sqlsrv_execute($stmtBilling)) {
//                         // Successfully inserted a billing item
//                     } else {
//                         // Error inserting billing item
//                         $success = false;
//                         echo '<script>
//                         swal("Error!", "Error inserting billing item ' . ($i + 1) . '.", "error");
//                         </script>';
//                     }
//                 }

//                 if ($success) {
//                     echo '<script>
//                     swal("Success!", "", "success");
//                     setTimeout(function(){
//                         var url = "opd-bill-cum-receipt?rno=' . $rno . '&billno=' . $billno . '&billdate=' . $billdate . '";
//                         var link = document.createElement("a");
//                         link.href = url;
//                         link.target = "_blank";
//                         link.click();
//                     }, 1000);
//                 </script>';
//                 } else {
//                     echo '<script>
//                     swal("Error!", "Error inserting one or more billing items.", "error");
//                     </script>';
//                 }
//             } else {
//                 echo '<script>
//                 swal("Error!", "Error inserting main data.", "error");
//                 </script>';
//             }
//         } else {
//             echo '<script>
//             swal("Error!", "Error preparing main SQL statement.", "error");
//             </script>';
//         }
//     }
// }
?>

<?php
// Set error reporting
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// // Check if form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["billSave"])) {
//     // Assuming you have a database connection established elsewhere and stored in $conn variable

//     // Assign POST data to variables
//     $rstatus = $_POST["rstatus"];
//     $rno = $_POST["rno"];
//     $pname = $_POST["pname"];
//     $phone = $_POST["phone"];
//     $rdocname = $_POST["rdocname"];
//     $billno = $_POST["billno"];
//     $billdate = $_POST["billdate"];
//     $totalPrice = floatval($_POST['totalPrice']);
//     $totalAdj = $_POST['totalAdj'];
//     $gst = '0'; // Assuming you're not using GST for now
//     $billAmount = $_POST['billAmount'];
//     $paidAmount = $_POST['paidAmount'];
//     $balance = $_POST['balance'];
//     $username = $login_username; // Assuming you have this defined elsewhere
//     $status = isset($_POST["paymentType"]) ? $_POST["paymentType"] : ""; 

//     // Check for valid data
//     if ($totalPrice === 0.00 || $paidAmount === 0.00 || $totalPrice === null || $paidAmount === null || $status === null) {
//         echo '<script>
//             swal("Error!", "Total Price and Paid Amount should be greater than 0.00.", "error");
//         </script>';
//     } else {
//         // Prepare main SQL statement for billingDetails table
//         $sqlMain = "INSERT INTO billingDetails (rstatus, rno, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, gst, billAmount, paidAmount, balance, status, uname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//         $paramsMain = array($rstatus, $rno, $pname, $phone, $rdocname, $billno, $billdate, $totalPrice, $totalAdj, $gst, $billAmount, $paidAmount, $balance, $status, $username);
//         $stmtMain = sqlsrv_prepare($conn, $sqlMain, $paramsMain);

//         // Execute main SQL statement
//         if ($stmtMain && sqlsrv_execute($stmtMain)) {
//             $success = true;

//             // Loop through each billing item
//             for ($i = 0; $i < count($_POST['sservname']); $i++) {
//                 $servname = $_POST['sservname'][$i];
//                 $servrate = $_POST['sservrate'][$i];

//                 // Prepare SQL statement for billing table
//                 $sqlBilling = "INSERT INTO billing (rno, pname, billno, billdate, servname, servrate, uname) VALUES (?, ?, ?, ?, ?, ?, ?)";
//                 $paramsBilling = array($rno, $pname, $billno, $billdate, $servname, $servrate, $username);
//                 $stmtBilling = sqlsrv_prepare($conn, $sqlBilling, $paramsBilling);

//                 // Execute the billing statement for each item
//                 if ($stmtBilling && sqlsrv_execute($stmtBilling)) {
//                     // Successful insertion of billing item
//                 } else {
//                     $success = false;
//                     echo '<script>
//                     swal("Error!", "Error inserting billing item ' . ($i + 1) . '.", "error");
//                     </script>';
//                     break; // Break the loop if execution fails
//                 }
//             }

//             if ($success) {
//                 echo '<script>
//                 swal("Success!", "", "success");
//                 setTimeout(function(){
//                     var url = "opd-bill-cum-receipt?rno=' . $rno . '&billno=' . $billno . '&billdate=' . $billdate . '";
//                     var link = document.createElement("a");
//                     link.href = url;
//                     link.target = "_blank";
//                     link.click();
//                 }, 1000);
//                 </script>';
//             }
//         } else {
//             echo '<script>
//             swal("Error!", "Error inserting main data.", "error");
//             </script>';
//         }
//     }
// }
?>

<!-- load data -->
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
<!-- <script>
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
</script> -->


<?php
include ('footer.php');
?>
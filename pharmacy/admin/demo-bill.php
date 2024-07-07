<?php
include ('../../db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>How to add & remove table rows</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        h1 {
            text-align: center;
        }

        table,
        form {
            width: 500px;
            margin: 20px auto;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        table td,
        table th {
            border: solid 1px black;
        }

        label,
        input {
            display: block;
            margin: 10px 0;
            font-size: 20px;
        }

        button {
            display: block;
        }
    </style>
</head>

<body>
    <h1>Dynamically Add & Remove Table Rows</h1>
    <form>
        <!-- <div class="form"> -->
        <div class="input-row">
            <label for="url">servname</label>
            <!-- <input type="text" name="url" id="url" /> -->
            <select class="form-select select2" name="servname[]" id="servname" onchange="getservname(this.value)">
                <option>Select Services</option>
                <?php
                $sql = "SELECT servname FROM servmaster";
                $stmt = sqlsrv_query($conn, $sql);
                if ($stmt === false) {
                    die (print_r(sqlsrv_errors(), true));
                } else {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $servname = $row['servname'];
                        echo "<option value='$servname'>$servname</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="input-row">
            <label for="servrate">Website Name</label>
            <!-- <input type="text" name="servrate" id="servrate" /> -->
            <select class="form-select select2" name="servrate[]" id="servrate">
                <option>Select Price</option>
            </select>
        </div>
        <button>Submit</button>
        <!-- </div> -->
    </form>
    <table>
        <thead>
            <tr>
                <th>Url</th>
                <th>servrate</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total Amount:</td>
                <td><input type="text" class="form-control" placeholder="TOTAL Amount" name="totalPrice"
                        id="totalPrice"></td>
            </tr>
            <tr>
                <td colspan="2">Total Adjusted:</td>
                <td><input type="text" class="form-control" placeholder="Total Adjusted" name="totalAdj" id="totalAdj">
                </td>
            </tr>
            <tr>
                <td colspan="2">GST %:</td>
                <td><input type="text" class="form-control" placeholder="GST %" name="gst" id="gst"></td>
            </tr>
            <tr>
                <td colspan="2">Bill Amount:</td>
                <td><input type="text" class="form-control" placeholder="Bill Amount" name="billAmount" id="billAmount">
                </td>
            </tr>
            <tr>
                <td colspan="2">Paid Amount:</td>
                <td><input type="text" class="form-control" placeholder="Paid Amount" name="paidAmount" id="paidAmount">
                </td>
            </tr>
            <tr>
                <td colspan="2">Balance:</td>
                <td><input type="text" class="form-control" placeholder="Balance" name="balance" id="balance"></td>
            </tr>
            <tr>
                <td colspan="2">Payment Type:</td>
                <td>
                    <select class="form-select select2" name="servrate[]" id="servrate">
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const formEl = document.querySelector(".form");
            const tbodyEl = document.querySelector("tbody");
            const tableEl = document.querySelector("table");
            const totalPriceEl = document.getElementById("totalPrice");
            let prices = [];
            function calculateTotalPrice() {
                let totalPrice = 0;
                prices.forEach(price => {
                    totalPrice += parseFloat(price) || 0;
                });
                document.getElementById("totalPrice").value = totalPrice.toFixed(2);
            }
            function calculateValues() {
                const totalAdj = parseFloat(document.getElementById("totalAdj").value) || 0;
                const gst = parseFloat(document.getElementById("gst").value) || 0;
                const paidAmount = parseFloat(document.getElementById("paidAmount").value) || 0;
                const billAmount = (totalPriceEl - totalAdj).toFixed(2);
                const balance = (billAmount - paidAmount).toFixed(2);
                document.getElementById("billAmount").value = billAmount;
                document.getElementById("balance").value = balance;
                const gstAmount = (billAmount * (gst / 100)).toFixed(2);
                const finalBillAmount = (parseFloat(billAmount) + parseFloat(gstAmount)).toFixed(2);
                document.getElementById("gstAmount").value = gstAmount;
                document.getElementById("finalBillAmount").value = finalBillAmount;
            }

            const inputs = document.querySelectorAll("#totalPrice, #totalAdj, #gst, #paidAmount");
            inputs.forEach(input => {
                input.addEventListener("input", calculateValues);
            });

            function onAddWebsite(e) {
                e.preventDefault();
                const servrate = document.getElementById("servrate").value.replace(/,/g, ''); // Remove commas
                const servname = document.getElementById("servname").value;
                const newRow = `
        <tr>
            <td><input type="text" value="${servname}" name="servnames[]"></td>
            <td><input type="text" value="${servrate}" name="servnames[]"</td>
            <td><button class="deleteBtn">Delete</button></td>
        </tr>
        `;.
                tbodyEl.innerHTML += newRow;
                prices.push(parseFloat(servrate));
                calculateTotalPrice();
                calculateValues();

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

            formEl.addEventListener("submit", onAddWebsite);
            tableEl.addEventListener("click", onDeleteRow);
        });
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
</body>

</html>
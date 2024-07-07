<?php
include ('../../../db_conn.php');
if (isset($_POST['docName'])) {
    $docName = $_POST['docName'];
    $sql = "SELECT fee FROM docmaster WHERE docName = ?";
    $params = array($docName);
    $res = sqlsrv_query($conn, $sql, $params);
    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
    
    // Remove the decimal point and trailing zeros
    $fee = rtrim($row['fee'], '0');
    $fee = (int)$fee; // Convert to integer to remove the decimal point

    echo json_encode(array('fee' => $fee));
    exit;
}

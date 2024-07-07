<?php
include('../../../db_conn.php');

if (isset($_POST['rcity'])) {
    $rcity = $_POST['rcity'];

    $sql = "SELECT distname, state, country FROM citymaster WHERE Cityname = ?";
    $params = array($rcity);
    $res = sqlsrv_query($conn, $sql, $params);
    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $details = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
    echo json_encode($details);
    exit;
}
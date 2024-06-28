<?php
include('../../../db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['catemaster'])) {
    $catemaster = $_POST['catemaster'];
    
    $sql = "SELECT servname, servrate FROM servmaster WHERE cate = ?";
    $params = array($catemaster);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        $response = array("success" => false, "error" => print_r(sqlsrv_errors(), true));
    } else {
        $servnames = array();
        $servrate = '';
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $servnames[] = $row['servname'];
            $servrate = $row['servrate'];
        }
        $response = array("success" => true, "servnames" => $servnames, "servrate" => $servrate);
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    $response = array("success" => false, "error" => "Invalid request");
    header('Content-Type: application/json');
    echo json_encode($response);
}
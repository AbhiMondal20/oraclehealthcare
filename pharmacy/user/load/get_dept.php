<?php
include('../../../db_conn.php');

if (isset($_POST['servname']) && isset($_POST['servrate'])) {
    $servname = $_POST['servname'];
    $servrate = $_POST['servrate'];

    $sql = "SELECT dept, servrate FROM servmaster WHERE servname = ? AND servrate = ?";
    $params = array($servname, $servrate);
    $res = sqlsrv_query($conn, $sql, $params);

    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }

    $servmasters = array();
    while ($row_servmasters = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
        $servmasters[] = array('dept' => $row_servmasters['dept'], 'servrate' => $row_servmasters['servrate']);
    }
    echo json_encode($servmasters);
    exit;
}
?>

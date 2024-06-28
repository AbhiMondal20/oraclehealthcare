<?php
include ('../../../db_conn.php');

if (isset($_POST['servname'])) {
    $servname = $_POST['servname'];

    $sql = "SELECT servname, cateVal FROM servmaster WHERE servname = '$servname'";
    $params = array($servname, $cateVal);
    $res = sqlsrv_query($conn, $sql, $params);
    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $servmasters = array();
    while ($row_servmasters = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
        $servmasters[] = array('servname' => $row_servmasters['servname'], 'getservrate' => $row_servmasters['cateVal']);
    }
    echo json_encode($servmasters);
    exit;
}

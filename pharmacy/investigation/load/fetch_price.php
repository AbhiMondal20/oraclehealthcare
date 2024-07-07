<?php
include ('../../../db_conn.php');

// if (isset($_POST['servname'])) {
    // $servname = $_POST['servname'];

    $sql = "SELECT servname, cateVal FROM servmaster ";
    // $params = array($servname);
    $res = sqlsrv_query($conn, $sql);
    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $servmasters = array();
    while ($row_servmasters = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {

        // $servrate_formatted = number_format($row_servmasters['servrate'], 2);
        $servmasters[] = array('servname' => $row_servmasters['servname'], 'servrate' => $row_servmasters['cateVal']);
    }
    echo json_encode($servmasters);
    exit;
// }

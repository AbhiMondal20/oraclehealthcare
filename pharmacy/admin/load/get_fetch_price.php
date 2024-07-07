<?php
include ('../../../db_conn.php');

if (isset($_POST['servname'])) {
    $servname = $_POST['servname'];

    $sql = "SELECT servname, cateVal FROM servmaster WHERE servname = '$servname'";
    $params = array($servname, $cateVal);
    $res = mysqli_query($conn, $sql, $params);
    if ($res === false) {
        die(json_encode(array('error' => mysqli_errors())));
    }
    $servmasters = array();
    while ($row_servmasters = mysqli_fetch_array($res)) {
        $servmasters[] = array('servname' => $row_servmasters['servname'], 'getservrate' => $row_servmasters['cateVal']);
    }
    echo json_encode($servmasters);
    exit;
}

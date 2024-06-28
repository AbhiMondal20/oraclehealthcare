<?php
include('../../../db_conn.php');

if (isset($_POST['servname'])) {
    $servname = $_POST['servname'];

    $sql = "SELECT servname, servrate FROM servmaster WHERE servname = ?";
    $params = array($servname);
    $res = sqlsrv_query($conn, $sql, $params);
    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $servmasters = array();
    while ($row_servmasters = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
        // Applying number_format to servrate before adding to $servmasters array
        $servrate_formatted = number_format($row_servmasters['servrate'], 2);
        $servmasters[] = array('servname' => $row_servmasters['servname'], 'servrate' => $servrate_formatted);
    }
    echo json_encode($servmasters);
    exit;
}
?>

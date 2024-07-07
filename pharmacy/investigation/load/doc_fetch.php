<?php
include('../../../db_conn.php');

if (isset($_POST['rdocname'])) {
    $rdocname = $_POST['rdocname'];

    $sql = "SELECT docName FROM deptmaster WHERE dept = ?";
    $params = array($rdocname);
    $res = sqlsrv_query($conn, $sql, $params);
    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $docNames = array();
    while ($row_docNames = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
        $docNames[] = array('docName' => $row_docNames['docName']);
    }
    echo json_encode($docNames);
    exit;
}

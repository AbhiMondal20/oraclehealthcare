<?php
include ('../../../db_conn.php');
// if (isset($_POST['docName'])) {
    // $docName = $_POST['docName'];
    $sql = "SELECT dept FROM docmaster";
    // $params = array($docName);
    $res = sqlsrv_query($conn, $sql);
    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
    $dept = $row['dept'];

    echo json_encode(array('dept' => $dept));
    // exit;
// }
 
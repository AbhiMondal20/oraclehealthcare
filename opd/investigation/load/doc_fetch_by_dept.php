<?php
include ('../../../db_conn.php');

if (isset($_POST['dept'])) {
    $dept = $_POST['dept'];

    $sql = "SELECT docName, fee FROM docmaster WHERE dept = ?";
    $params = array($dept);
    $res = sqlsrv_query($conn, $sql, $params);

    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }
    $doctors = array();
    while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
        $fee = (int) $row['fee'];
        $doctors[] = array('docName' => $row['docName'], 'fee' => $fee);
    }

    echo json_encode($doctors);
} else {
    echo json_encode(array('error' => 'Department not selected'));
}

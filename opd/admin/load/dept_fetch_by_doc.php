<?php
include ('../../../db_conn.php');

// if (isset($_POST['docName'])) {
//     $docName = $_POST['docName'];

    $sql = "SELECT docName, dept, fee FROM docmaster";
    // $params = array($docName);
    $res = sqlsrv_query($conn, $sql);

    if ($res === false) {
        die(json_encode(array('error' => sqlsrv_errors())));
    }

    $depts = array();
    while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
        $fee = (int) $row['fee'];
        $docName = $row['docName'];
        $depts[] = array('dept' => $row['dept'], 'docName' => $docName, 'fee' => $fee);
    }
    echo json_encode($depts);
// } else {
//     echo json_encode(array('error' => 'Doctor not selected'));
// }

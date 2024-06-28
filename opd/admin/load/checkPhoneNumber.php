<?php
include ('../../../db_conn.php');
if(isset($_GET['phoneNumber'])) {
    $phoneNumber = $_GET['phoneNumber'];
    
    $sql = "SELECT COUNT(*) as count FROM registration WHERE phone = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array(&$phoneNumber));
    
    if (sqlsrv_execute($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row['count'] > 0) {
            echo "exists";
        } else {
            echo "not_exists";
        }
    } else {
        echo "error_executing";
    }
} else {
    echo "error_no_phoneNumber";
}

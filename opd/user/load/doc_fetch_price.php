<?php
include('../../../db_conn.php');

if (isset($_POST['docName'])) {
    $docName = $_POST['docName'];

    // Prepare the SQL statement
    $sql = "SELECT fee FROM docmaster WHERE docName = ?";
    $params = array($docName);
    $res = sqlsrv_query($conn, $sql, $params);

    // Check if query executed successfully
    if ($res === false) {
        // Handle errors
        die(json_encode(array('error' => sqlsrv_errors())));
    }

    // Fetch the data
    $row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
    
    // Check if data exists
    if ($row) {
        // Prepare the response
        $fee = (int)$row['fee']; // Convert fee to integer
        $response = array('fee' => $fee);

        // Return JSON response
        echo json_encode($response);
    } else {
        // Return error response if no data found
        echo json_encode(array('error' => 'Fee not found'));
    }
} else {
    // Return error response if docName parameter is not set
    echo json_encode(array('error' => 'Parameter not set'));
}
?>

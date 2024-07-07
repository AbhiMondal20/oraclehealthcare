<?php
// Include database connection
include('../../../db_conn.php');

if (isset($_POST['docName'])) {
    $docName = $_POST['docName'];

    // SQL query to select fee from docmaster based on docName
    $sql = "SELECT fee FROM docmaster WHERE docName = ?";

    // Initialize statement object
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die(json_encode(array('error' => mysqli_error($conn))));
    }

    // Bind parameter to statement
    mysqli_stmt_bind_param($stmt, "s", $docName);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Get result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if query execution was successful
    if (!$result) {
        die(json_encode(array('error' => mysqli_stmt_error($stmt))));
    }

    // Fetch row from the result set
    $row = mysqli_fetch_assoc($result);

    // Check if a row was fetched
    if (!$row) {
        die(json_encode(array('error' => 'Doctor not found')));
    }

    // Extract fee from the fetched row
    // Remove trailing zeros and cast to integer
    // $fee = (int) rtrim($row['fee'], '0'); 
    $fee = $row['fee']; 
    

    // Return fee as JSON response
    echo json_encode(array('fee' => $fee));

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
}
?>

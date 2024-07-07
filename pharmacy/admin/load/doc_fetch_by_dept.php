<?php
// Include database connection
include('../../../db_conn.php');

// Check if 'dept' is set in POST data
if (isset($_POST['dept'])) {
    // Sanitize and assign POST variable
    $dept = $_POST['dept'];

    // SQL query to select docName and fee from docmaster based on dept
    $sql = "SELECT docName, fee FROM docmaster WHERE dept = ?";

    // Initialize statement object
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die(json_encode(array('error' => mysqli_error($conn))));
    }

    // Bind parameter to statement
    mysqli_stmt_bind_param($stmt, "s", $dept);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Get result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if query execution was successful
    if (!$result) {
        die(json_encode(array('error' => mysqli_stmt_error($stmt))));
    }

    // Initialize array to store doctors
    $doctors = array();

    // Fetch rows from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $fee = (int) $row['fee']; // Cast fee to integer if needed
        $doctors[] = array('docName' => $row['docName'], 'fee' => $fee);
    }

    // Return doctors array as JSON response
    echo json_encode($doctors);

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Return error if 'dept' is not set
    echo json_encode(array('error' => 'Department not selected'));
}
?>

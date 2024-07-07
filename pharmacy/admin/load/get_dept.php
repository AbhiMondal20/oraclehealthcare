<?php
// Include database connection
include('../../../db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['servname']) && isset($_POST['servrate'])) {
    
    // Sanitize and assign POST variables
    $servname = $_POST['servname'];
    $servrate = $_POST['servrate'];

    // Prepare SQL statement
    $sql = "SELECT dept, servrate FROM servmaster WHERE servname = ? AND servrate = ?";
    
    // Initialize statement object
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die(json_encode(array('error' => mysqli_error($conn))));
    }
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sd", $servname, $servrate); 

    mysqli_stmt_execute($stmt);

    // Get result set
    $result = mysqli_stmt_get_result($stmt);

    // Check for errors
    if (!$result) {
        die(json_encode(array('error' => mysqli_stmt_error($stmt))));
    }

    // Fetch results into an array
    $servmasters = array();
    while ($row_servmasters = mysqli_fetch_assoc($result)) {
        $servmasters[] = array('dept' => $row_servmasters['dept'], 'servrate' => $row_servmasters['servrate']);
    }

    // Output JSON encoded array
    echo json_encode($servmasters);

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    exit;
}
?>

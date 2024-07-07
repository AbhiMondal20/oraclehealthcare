<?php
// Include database connection
include('../../../db_conn.php');

// Check if 'phoneNumber' is set in GET data
if(isset($_GET['phoneNumber'])) {
    // Sanitize and assign GET variable
    $phoneNumber = $_GET['phoneNumber'];
    
    // SQL query to count rows where phone number matches
    $sql = "SELECT COUNT(*) AS count FROM registration WHERE phone = ?";
    
    // Initialize statement object
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Error: " . mysqli_error($conn));
    }
    
    // Bind parameter to statement
    mysqli_stmt_bind_param($stmt, "s", $phoneNumber);
    
    // Execute statement
    mysqli_stmt_execute($stmt);
    
    // Get result set
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if query execution was successful
    if (!$result) {
        echo "error_executing";
    } else {
        // Fetch row from the result set
        $row = mysqli_fetch_assoc($result);
        
        // Check if a row was fetched and count > 0
        if ($row && $row['count'] > 0) {
            echo "exists";
        } else {
            echo "not_exists";
        }
    }
    
    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "error_no_phoneNumber";
}
?>

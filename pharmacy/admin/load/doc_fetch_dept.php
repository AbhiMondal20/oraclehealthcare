<?php
// Include database connection
include('../../../db_conn.php');

// Check if the request method is POST and if 'docName' is set
// if (isset($_POST['docName'])) {
    // Sanitize and assign POST variables (if needed)
    // $docName = $_POST['docName'];

    // SQL query to select department from docmaster
    $sql = "SELECT dept FROM docmaster";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check if query execution was successful
    if ($res === false) {
        die(json_encode(array('error' => mysqli_error($conn))));
    }

    // Fetch the first row from the result set
    $row = mysqli_fetch_assoc($res);

    // Check if a row was fetched
    if (!$row) {
        die(json_encode(array('error' => 'No department found')));
    }

    // Extract department from the fetched row
    $dept = $row['dept'];

    // Return department as JSON response
    echo json_encode(array('dept' => $dept));

    // Close the connection
    mysqli_close($conn);
    exit;
// }
?>

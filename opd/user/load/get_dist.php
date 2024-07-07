<?php
// Include database connection
include('../../../db_conn.php');

if (isset($_POST['rcity'])) {
    $rcity = $_POST['rcity'];

    $sql = "SELECT distname, state, country FROM citymaster WHERE Cityname = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die(json_encode(array('error' => mysqli_error($conn))));
    }

    mysqli_stmt_bind_param($stmt, "s", $rcity);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Check if query execution was successful
    if (!$result) {
        die(json_encode(array('error' => mysqli_stmt_error($stmt))));
    }

    // Fetch row from the result set as an associative array
    $details = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Check if details were fetched
    if (!$details) {
        die(json_encode(array('error' => 'City details not found')));
    }

    // Return details as JSON response
    echo json_encode($details);

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
} else {
    echo json_encode(array('error' => 'No rcity parameter provided'));
}

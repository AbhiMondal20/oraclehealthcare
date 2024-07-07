<?php
include('../../../db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['catemaster'])) {
    $catemaster = $_POST['catemaster'];
    
    $sql = "SELECT servname, servrate FROM servmaster WHERE cate = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        $response = array("success" => false, "error" => mysqli_error($conn));
    } else {
        mysqli_stmt_bind_param($stmt, 's', $catemaster);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $servnames = array();
        $servrates = array(); // To handle multiple service rates
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $servnames[] = $row['servname'];
            $servrates[] = $row['servrate'];
        }
        $response = array("success" => true, "servnames" => $servnames, "servrates" => $servrates);
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    $response = array("success" => false, "error" => "Invalid request");
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

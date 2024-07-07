<?php
include('../../../db_conn.php');
// Retrieve the city parameter from the GET request
$city = $_GET['city'];

// Query to fetch districts based on the selected city
$sql = "SELECT distname FROM citymaster WHERE Cityname = ?";
$params = array($city);
$stmt = sqlsrv_query($conn, $sql, $params);

// Fetch districts and store in an array
$districts = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $districts[] = $row['distname'];
}

// Return districts as JSON
echo json_encode($districts);

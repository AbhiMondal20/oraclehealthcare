<?php
include ('../../../db_conn.php');

// Check if the connection is successful
if ($conn === false) {
    die(print_r(mysqli_errors(), true));
}

$sql = "SELECT dept, modality, servname, ServFlag, cate, cateVal, code FROM servmaster";
$result = mysqli_query($conn, $sql);

// Create CSV content
$csv_data = "Department, Modality, Test Name, status, Category, Test Price, Code, \n";
while ($row = mysqli_fetch_array($result)) {
    $csv_data .= '"' . $row["dept"] . '","' . $row["modality"] . '","' . $row["servname"] . '","' . $row["ServFlag"] . '","' . $row["cate"] . '","' . $row["cateVal"].'","' . $row["code"]."\"\n";
}

// Create CSV file
$csv_filename = "TestDetails.csv";
$csv_file = fopen($csv_filename, "w");
fwrite($csv_file, $csv_data);
fclose($csv_file);

// Download CSV file
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $csv_filename . '"');
readfile($csv_filename);
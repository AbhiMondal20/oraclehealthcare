<?php
include ('../../../db_conn.php');

// Check if the connection is successful
if ($conn === false) {
    die(print_r(mysqli_errors(), true));
}

$sql = "SELECT dept, docregno, docName, sp, fee FROM docmaster";
$result = mysqli_query($conn, $sql);

// Create CSV content
$csv_data = "Department, Registration Number, Doctor Name, Specialization, Fee\n";
while ($row = mysqli_fetch_array($result)) {
    $csv_data .= '"' . $row["dept"] . '","' . $row["docregno"] . '","' . $row["docName"] . '","' . $row["sp"] . '","' . $row["fee"] . "\"\n";
}

// Create CSV file
$csv_filename = "doctors.csv";
$csv_file = fopen($csv_filename, "w");
fwrite($csv_file, $csv_data);
fclose($csv_file);

// Download CSV file
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $csv_filename . '"');
readfile($csv_filename);
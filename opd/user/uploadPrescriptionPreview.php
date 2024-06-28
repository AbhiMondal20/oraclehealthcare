<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Upload </h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Prescription</li>
                                <li class="breadcrumb-item active" aria-current="page">Preview</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <?php
// $id = $_GET['pid'];
// $id = urldecode($id);
// $id = str_replace("'", "", $id);
$opid = $_GET['opid'];
$rno = $_GET['rno'];

$sql = "SELECT uploadPrescription FROM registration WHERE rno = '$rno' AND opid = '$opid'";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    echo "Error fetching data: " . print_r(sqlsrv_errors(), true);
} else {
    if (sqlsrv_has_rows($stmt)) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $uploadedFiles = explode(', ', $row['uploadPrescription']);
            foreach ($uploadedFiles as $file) {
                echo "<div>";
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "<img src='$file' alt='File Preview' width='100%'><br><br>";
                } else if (in_array($fileExtension, ['pdf'])) {
                    echo "<embed src='$file' type='application/pdf' width='100%' height='900'><br>";
                } else {
                    echo "File Preview Not Available<br>";
                }

                echo "</div>";
            }
        }
    } else {
        echo "No data found";
    }
    sqlsrv_free_stmt($stmt);
}
?>


    </div>
</div>

<?php
include ('footer.php');

?>
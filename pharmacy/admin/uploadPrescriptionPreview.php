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
$stmt = mysqli_query($conn, $sql);

if ($stmt === false) {
    echo "Error fetching data: " . print_r(mysqli_errors(), true);
} else {
    if (mysqli_num_rows($stmt)) {
        while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
            $uploadedFiles = explode(', ', $row['uploadPrescription']);
            foreach ($uploadedFiles as $file) {
                echo "<div>";
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "<img src='./../user/$file' alt='File Preview' width='100%'><br><br>";
                } else if (in_array($fileExtension, ['pdf'])) {
                    echo "<embed src='./../user/$file' type='application/pdf' width='100%' height='900'><br>";
                } else {
                    echo "File Preview Not Available<br>";
                }

                echo "</div>";
            }
        }
    } else {
        echo "No data found";
    }
}
?>


    </div>
</div>

<?php
include ('footer.php');

?>
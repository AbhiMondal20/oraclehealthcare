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
                                <li class="breadcrumb-item" aria-current="page">Report</li>
                                <li class="breadcrumb-item active" aria-current="page">Preview</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <?php
$modality = $_GET['modality'];
$rno = $_GET['rno'];
$servname = $_GET['servname'];

$sql = "SELECT uploadReport FROM PathoReport WHERE modality = ? AND rno = ? AND servname = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

// Bind parameters to the statement
mysqli_stmt_bind_param($stmt, "sss", $modality, $rno, $servname);

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    die("Error executing statement: " . mysqli_error($conn));
}

// Get result set
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error fetching result set: " . mysqli_error($conn));
}

// Check if there are rows returned
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $uploadedFiles = explode(', ', $row['uploadReport']);
        foreach ($uploadedFiles as $file) {
            echo "<div>";
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "<img src='$file' alt='File Preview' width='100%'><br><br>";
            } elseif (in_array($fileExtension, ['pdf'])) {
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

// Free result set
mysqli_free_result($result);
?>



    </div>
</div>

<?php
include ('footer.php');

?>
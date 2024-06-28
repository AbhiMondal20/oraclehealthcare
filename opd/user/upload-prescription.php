<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$id = $_GET['id'];
$rno = $_GET['rno'];

$sql = "SELECT TOP 1 id, rno, opid, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS pname, rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy FROM registration WHERE id = '$id' AND rno = '$rno'";
$res = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
    $id = $row['id'];
    $opid = $row['opid'];
    $pname = $row['pname'];
    $age = $row['rage'];
    $gender = $row['rsex'];
    $doc = $row['rdoc'];
}
?>
<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Upload Prescription</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Upload</li>
                                <li class="breadcrumb-item active" aria-current="page">Prescription</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- LFT Test Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Reg. No: &nbsp;
                        <?php echo $rno ?>&nbsp;&nbsp;&nbsp;
                        OP Id: &nbsp;
                        <?php echo $opid ?>
                        &nbsp;&nbsp;&nbsp;Name: &nbsp;&nbsp;&nbsp;
                        <?php echo $pname ?>&nbsp;/
                        <?php echo $age ?>&nbsp;/
                        <?php echo $gender; ?>&nbsp;&nbsp;&nbsp;Doctor: &nbsp;
                        <?php echo $doc ?>&nbsp;&nbsp;
                    </h4>
                </div>
            </div>
        </div>
        <!-- Upload Reports -->
        <div class="col-xl-12 col-12 mt-2">
            <div class="box box-slided">
                <div class="box-header with-border">
                    <h4 class="box-title"><strong>Upload Prescription</strong></h4>
                    <ul class="box-controls pull-right">
                        <li><a class="box-btn-slide" href="#"></a></li>
                        <li><a class="box-btn-fullscreen" href="#"></a></li>
                    </ul>
                </div>

                <div class="box-body">
                    <!-- Main content -->
                    <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input class="form-control" type="hidden" name="rno" value="<?php echo $rno; ?>">
                                    <input class="form-control" type="hidden" name="opid" value="<?php echo $opid; ?>">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="file" name="file[]" required class="form-control" id="file"
                                                accept=".jpeg,.jpg,.png,.pdf,.webp" multiple>
                                        </div>
                                    </div>
                                    <br>
                                    <center>
                                        <button class="btn btn-md btn-primary" type="submit" name="Filesave"
                                            tabindex="38">SAVE</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>
</div>

<?php

// File Upload Code
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Filesave'])) {
    $fileCount = count($_FILES['file']['name']);
    $tmp_dir = './uploads/';
    $img_upload = array();
    $upload_success = true;

    for ($i = 0; $i < $fileCount; $i++) {
        $img_name = $_FILES['file']['name'][$i];
        $thambname = uniqid('', true);
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_size = $_FILES['file']['size'][$i] / (1024 * 1024);
        $img_dir = $tmp_dir . $thambname . "." . $img_ext;

        // Debugging: Print file information
        echo "File name: " . $img_name . "<br>";
        echo "File type: " . $_FILES['file']['type'][$i] . "<br>";
        echo "File size: " . $img_size . " MB<br>";

        if ($img_size > 5) {
            echo "<script>
                swal('Error!', 'Image size is greater than 5 MB.', 'error');
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>";
            $upload_success = false;
            break;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $img_dir)) {
            $img_upload[] = 'uploads/' . $thambname . "." . $img_ext;
        } else {
            $upload_success = false;
            break;
        }
    }

    if ($upload_success) {
        $img_upload_str = implode(', ', $img_upload);
        $rno = isset($_POST['rno']) ? $_POST['rno'] : '';
        $opid = isset($_POST['opid']) ? $_POST['opid'] : '';
        $sql = "UPDATE registration SET uploadPrescription = ? WHERE rno = ? AND opid = ?";
        $params = array($img_upload_str, $rno, $opid);
        $stmt = sqlsrv_prepare($conn, $sql, $params);

        if (sqlsrv_execute($stmt)) {
            echo "<script>
                swal('Success!', 'Files uploaded successfully.', 'success');
                setTimeout(function(){
                    window.location.href = 'uploadPrescriptionPreview?rno=" . $rno . "&opid=" . $opid."';
                }, 1000);
            </script>";
        } else {
            echo "<script>
                swal('Error!', 'Failed to upload files.', 'error');
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            </script>";
        }
    }
}

include ('footer.php');

?>

<!-- Upload File Format -->
<script>
    const fileInput = document.getElementById('file');
    fileInput.addEventListener('change', () => {
        const allowedExtensions = /(\.jpeg|\.jpg|\.png|\.pdf|\.webp)$/i;
        const maxSizeMB = 5;
        const fileSizeMB = fileInput.files[0].size / (1024 * 1024);
        const fileName = fileInput.value;
        if (!allowedExtensions.exec(fileName)) {
            swal({
                title: 'Invalid!',
                text: 'Invalid file format. Only PDF, WEBP, JPEG, JPG and PNG files are allowed.',
                icon: 'error',
                button: 'Ok',
            });
            fileInput.value = '';
            return false;
        } else if (fileSizeMB > maxSizeMB) {
            swal({
                title: 'Invalid!',
                text: 'File size exceeds the maximum allowed size of 5 MB.',
                icon: 'error',
                button: 'Ok',
            });
            fileInput.value = '';
            return false;
        }
    });
</script>
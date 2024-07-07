<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

?>

<script>
    new DataTable('#example', {
        columnDefs: [{ orderable: false, targets: 0 }],
        order: [[1, 'asc']]
    });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">OPD Registration List</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Registration List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-right">
                    <a href="reg" class="btn btn-info"><i class="fa-solid fa-circle-plus"></i> New Registration</a>
                </div>

            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>Reg. Date Time.</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <!-- <th>F/H/S/D/W</th> -->
                                        <th>Ph. No</th>
                                        <th>City</th>
                                        <th>Fee</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT id, rno, opid, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy, uploadPrescription
                                    FROM registration";
                                    $stmt = mysqli_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(mysqli_errors(), true));
                                    }
                                    while ($row = mysqli_fetch_array($stmt)) {
                                        $rno = $row['rno'];
                                        $id = $row['id'];
                                        $rfname = $row['rfname'];
                                        $wamt = number_format($row['wamt'], 2);
                                        $opid = $row['opid'];
                                        $uploadPrescription = $row['uploadPrescription'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $rno; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['rdate']; ?>
                                                <?php echo $row['rtime']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['fullname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['rsex']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['rage']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['phone']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['rcity']; ?>
                                            </td>
                                            <td>
                                                <?php echo $wamt; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="list-icons d-inline-flex">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-file-text"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <!-- <a href="#" class="dropdown-item"><i class="fa fa-download"></i> Download</a> -->
                                                            <a href="reg-pdf?opid=<?php echo $opid ?>&rno=<?php echo $rno ?>"
                                                                class="dropdown-item"><i class="fa fa-print"></i>
                                                                Print</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="update-reg?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                                                                class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="visit-doctor?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                                                                class="dropdown-item">
                                                                <i class="fa-solid fa-user-doctor"></i> Visit Doctor</a>
                                                            <a href="opd-billing2?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                                                                class="dropdown-item">OPD Billing</a>
                                                            <a href="#" class="dropdown-item"> IPD Admisstion</a>
                                                            <?php
                                                                if ($uploadPrescription === NULL) {
                                                                    echo '<a href="upload-prescription?id=' . $id . '&rno=' . $rno . '" class="dropdown-item" target="_BLANK"><i class="fa-solid fa-upload"></i> Prescription</a>';
                                                                } else {
                                                                    echo '<a href="uploadPrescriptionPreview?rno=' . $rno . '&opid=' . $opid . '" class="dropdown-item" target="_BLANK"><i class="fa-solid fa-prescription"></i>Prescription</a>';
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
</div>

<?php
include ('footer.php');
?>
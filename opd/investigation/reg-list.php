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
                    <h4 class="page-title">Patient List</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Patient List</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive" style="max-height: 500px; overflow-x: scroll;">
                            <table id="example" class="table table-hover display nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>OP ID.</th>
                                        <th>Reg. Date Time.</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <!-- <th>F/H/S/D/W</th> -->
                                        <th>Ph. No</th>
                                        <th>City</th>
                                        <th>Dept.</th>
                                        <th>Doctor</th>
                                        <th>Fee</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT TOP 900 id, rno, opid, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy, rdoc, dept
                                    FROM registration 
                                    ORDER BY id DESC";
                                    $stmt = sqlsrv_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        $id = $row['id'];
                                        $rno = $row['rno'];
                                        $opid = $row['opid'];
                                        $id = $row['id'];
                                        $rfname = $row['rfname'];
                                        $doctor = $row['rdoc'];
                                        $dept = $row['dept'];
                                        $wamt = number_format($row['wamt'], 2);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $rno; ?>
                                            </td>
                                            <td>
                                                <?php echo $opid; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['rdate']; ?>
                                                <?php echo $row['rtime']->format('H:i:s') ?>
                                            </td>
                                            <td>
                                                <?php echo $row['fullname']; ?>&nbsp;
                                                (
                                                <?php echo $row['rage']; ?> )
                                            </td>
                                            <td>
                                                <?php echo $row['rsex']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['phone']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['rcity']; ?>
                                            </td>
                                            <td>
                                                <?php echo $dept; ?>
                                            </td>
                                            <td>
                                                <?php echo $doctor; ?>
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
                                                            <a href="reg-pdf?opid=<?php echo $opid; ?>&rno=<?php echo $rno; ?>"
                                                                class="dropdown-item"><i class="fa fa-print"></i>
                                                                Reprint</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="update-reg?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                                                                class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="opd-billing2?opid=<?php echo $opid; ?>&rno=<?php echo $rno; ?>"
                                                                class="dropdown-item"> OPD Billing</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="uploadPrescriptionPreview?opid=<?php echo $opid; ?>&rno=<?php echo $rno; ?>" class="dropdown-item"><i class="fa-solid fa-prescription"></i>Prescription</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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
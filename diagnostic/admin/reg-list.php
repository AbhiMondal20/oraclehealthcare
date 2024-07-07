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
                    <h4 class="page-title">Registration List</h4>
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

            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive" style="max-height: 500px; overflow-x: scroll;">
                            <table id="example5" class="table nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>OP Id</th>
                                        <th>Bill No</th>
                                        <th>Bill Date</th>
                                        <th>Name </th>
                                        <th>Gender </th>
                                        <th>Modality</th>
                                        <th>Test</th>
                                        <th>Doctor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT b.id, b.rno, b.opid, b.billdate, b.billno, b.pname, b.uname, b.servname, r.rsex, r.rage, r.rdoc, s.modality
                                    FROM billing AS b
                                    INNER JOIN registration AS r ON b.rno = r.rno
                                    INNER JOIN servmaster AS s ON b.servname = s.servname
                                    WHERE s.dept = 'PATHOLOGY'
                                    GROUP BY   b.id, b.rno, b.opid, b.billdate, b.billno, b.pname, b.uname, b.servname, r.rsex, r.rage, r.rdoc, s.modality";
                                    $stmt_billing = mysqli_query($conn, $sql);
                                    if ($stmt_billing === false) {
                                        die(print_r(mysqli_errors(), true));
                                    }
                                    while ($row_billing = mysqli_fetch_array($stmt_billing, MYSQLI_ASSOC)) {
                                        $id = $row_billing['id'];
                                        $rno = $row_billing['rno'];
                                        $opid = $row_billing['opid'];
                                        $billdate = $row_billing['billdate'];
                                        $billno = $row_billing['billno'];
                                        $pname = $row_billing['pname'];
                                        $addedBy = $row_billing['uname'];
                                        $servname = $row_billing['servname'];
                                        $rsex = $row_billing['rsex'];
                                        $rage = $row_billing['rage'];
                                        $rdoc = $row_billing['rdoc'];
                                        $modality = $row_billing['modality'];
                                        $sql_pathoreport = "SELECT servname AS PServname, billno AS Pbillno, uploadReport, inval, id AS pid, subgroup FROM PathoReport WHERE servname ='$servname'";
                                        $stmt_pathoreport = mysqli_query($conn, $sql_pathoreport);
                                        if ($stmt_pathoreport === false) {
                                            die(print_r(mysqli_errors(), true));
                                        }
                                        $PServname = "";
                                        $inval = null;
                                        while ($row_pathoreport = mysqli_fetch_array($stmt_pathoreport, MYSQLI_ASSOC)) {
                                            $PServname = $row_pathoreport['PServname'];
                                            $uploadReport = $row_pathoreport['uploadReport'];
                                            $inval = $row_pathoreport['inval'];
                                            $pid = $row_pathoreport['pid'];
                                            $subgroup = $row_pathoreport['subgroup'];
                                            $Pbillno = $row_pathoreport['Pbillno'];
                                        }

                                        $bgColor = ($PServname == $servname && $Pbillno == $billno) ? 'background-color:#198754; color:#fff' : '';
                                        
                                        $title = ($PServname == $servname && $Pbillno == $billno) ? 'Report Done' : 'Pending';
                                        // success = 198754
                                        // pending = F7CB73
                                        ?>
                                        <tr title="<?php echo $title; ?>" style="<?php echo $bgColor; ?>">
                                            <td><?php echo $rno; ?></td>
                                            <td><?php echo $opid; ?></td>
                                            <td><?php echo $billno; ?></td>
                                            <td><?php echo $billdate; ?></td>
                                            <td><?php echo $pname; ?> (<?php echo $rage; ?>)</td>
                                            <td><?php echo $rsex; ?></td>
                                            <td><?php echo $modality; ?></td>
                                            <td><?php echo $servname; ?></td>
                                            <td><?php echo $rdoc; ?></td>
                                            <td class="text-center">
                                                <div class="list-icons d-inline-flex">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-file-text"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <?php
                                                            // if ($inval != NULL && $PServname != NULL && $PServname == $row_billing['servname']) {
                                                            //     echo '<a href="update'.$modality.'?id='.$id.'&rno='.$rno.'&modality='.$modality.'" class="dropdown-item">
                                                            //     <i class="fa-solid fa-pen-to-square"></i>Update</a>';
                                                            // }else{
                                                            echo '<a href="' . $modality . '?id=' . $id . '&rno=' . $rno . '&modality=' . $modality . '" class="dropdown-item">
                                                                <i class="fa-solid fa-flag"></i>Reports</a>';
                                                            // }  
                                                            ?>
                                                            <div class="dropdown-divider"></div>
                                                            <?php
                                                            if ($inval != NULL && $PServname != NULL && $PServname == $row_billing['servname']) {
                                                                echo '<a href="BiochemistryPdf2?rno=' . $rno . '&id=' . $id . '&modality=' . $modality . '&subgroup=' . $subgroup . '" class="dropdown-item"><i class="fa-solid fa-download"></i> Download</a>';
                                                            } else {
                                                                echo '<a href="uploadReportPreview?rno=' . $rno . '&modality=' . $modality . '&servname=' . $servname . '" class="dropdown-item"><i class="fa-solid fa-download"></i> Download</a>';
                                                            }
                                                            ?>
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
<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

if (isset($_GET['type']) && $_GET['type'] === 'delete' && isset($_GET['srno']) && $_GET['srno'] > 0) {
    $srno = $_GET['srno'];
    $sql2 = "DELETE FROM docmaster WHERE srno = ?";
    $stmt = sqlsrv_prepare($conn, $sql2, array(&$srno));

    if (sqlsrv_execute($stmt)) {
        echo "<script>
                swal('Success!', '', 'success');
                setTimeout(function(){
                    window.location.href = 'doctor-master';
                }, 2000);
              </script>";
        exit;
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}

?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Doctor</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Doctor</li>
                                <li class="breadcrumb-item active" aria-current="page">Master</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-right">
                    <a href="add-doctor-master" class="btn btn-info"><i class="fa-solid fa-circle-plus"></i> Add Doctor</a>
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
                                        <th>SL. No</th>
                                        <th>Department</th>
                                        <th>Doc. Reg. No</th>
                                        <th>Doctor</th>
                                        <th>Fees</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT srno, docName, sp, fee, docregno, dept FROM docmaster 
                                    ORDER BY srno DESC";
                                    $stmt = sqlsrv_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }
                                    $sno = 0;
                                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                        $srno = $row['srno'];
                                        $docName = $row['docName'];
                                        $sp = $row['sp'];
                                        $dept = $row['dept'];
                                        $docregno = $row['docregno'];
                                        $fee = $row['fee'];
                                        $sno = $sno + 1;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $sno; ?>
                                            </td>
                                            <td>
                                                <?php echo $dept; ?>
                                            </td>
                                            <td>
                                                <?php echo $docregno; ?>
                                            </td>
                                            <td>
                                                <?php echo $docName; ?>
                                            </td>
                                            <td>
                                                <?php echo $fee; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="list-icons d-inline-flex">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-file-text"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <div class="dropdown-divider"></div>
                                                            <a href="update-doctor-master?srno=<?php echo $srno; ?>"
                                                                class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                                                                <a href="javascript:void(0)" onclick="return confirmDelete(<?php echo $srno; ?>);" class="delete dropdown-item"><i class="fa-solid fa-trash"></i> Delete</a>

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
<script>
function confirmDelete(srno) {
    swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this session!',
        icon: 'warning',
        buttons: {
            cancel: {
                text: 'Cancel',
                visible: true,
                closeModal: true
            },
            confirm: {
                text: 'Yes, delete it!',
                value: true,
                visible: true,
                closeModal: true
            }
        }
    }).then((value) => {
        if (value) {
            window.location.href = "?type=delete&srno=" + srno;
        }
    });
    return false;
}
</script>

<?php
    include ('footer.php');
?>
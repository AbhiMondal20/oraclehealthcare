<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

if (isset($_GET['type']) && $_GET['type'] === 'delete' && isset($_GET['codes']) && is_array($_GET['codes'])) {
    $codes = $_GET['codes'];

    // Prepare the SQL statement
    $sql = "DELETE FROM servmaster WHERE code IN (";
 
    // Add placeholders for each code
    foreach ($codes as $code) {
        $sql .= '?,';
    }

    // Remove the trailing comma from the SQL query
    $sql = rtrim($sql, ',') . ')';
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Execute the statement with parameters
    if (mysqli_execute($stmt)) {
        echo "<script>
                swal('Success!', 'Records have been deleted successfully.', 'success');
                setTimeout(function(){
                    window.location.href = 'test-master';
                }, 2000);
              </script>";
        exit;
    } else {
        die("Deletion failed: " . print_r(mysqli_errors(), true));
    }
}


?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Test Master</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Test</li>
                                <li class="breadcrumb-item active" aria-current="page">Master</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-right">
                    <a href="add-test-master" class="btn btn-info"><i class="fa-solid fa-circle-plus"></i> Add Test</a>
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
                                        <th>Code</th>
                                        <th>Department</th>
                                        <th>Modality</th>
                                        <th>Test</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT srno, dept, modality, servname ,code FROM servmaster 
                                    WHERE srno IN (
                                        SELECT MAX(srno) FROM servmaster GROUP BY code
                                    )";
                                    $stmt = mysqli_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(mysqli_errors(), true));
                                    }
                                    $sno = 0;
                                    while ($row = mysqli_fetch_array($stmt)) {
                                        $srno = $row['srno'];
                                        $servname = $row['servname'];
                                        $dept = $row['dept'];
                                        $modality = $row['modality'];
                                        $code = $row['code'];
                                        $sno = $sno + 1;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $srno; ?>
                                            </td>
                                            <td>
                                                <?php echo $code; ?>
                                            </td>
                                            <td>
                                                <?php echo $dept; ?>
                                            </td>
                                            <td>
                                                <?php echo $modality; ?>
                                            </td>
                                            <td>
                                                <?php echo $servname; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="list-icons d-inline-flex">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-file-text"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <div class="dropdown-divider"></div>
                                                            <a href="update-test-master?srno=<?php echo $srno; ?>&dept=<?php echo $dept; ?>&modality=<?php echo $modality; ?>&servname=<?php echo $servname; ?>&code=<?php echo $code; ?>"
                                                                class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                                                            <!-- <a href="javascript:void(0)"
                                                                onclick="return confirmDelete(<?php echo $code; ?>);"
                                                                class="delete dropdown-item"><i
                                                                    class="fa-solid fa-trash"></i> Delete</a> -->
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
    function confirmDelete(code) {
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
                window.location.href = "?type=delete&code=" + code;
            }
        });
        return false;
    }
</script>

<?php
include ('footer.php');

?>
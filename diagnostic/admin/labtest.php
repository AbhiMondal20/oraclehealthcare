<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

if (isset($_GET['type']) && $_GET['type'] === 'delete' && isset($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $sql2 = "DELETE FROM pathomaster WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql2, array(&$id));
    if (mysqli_execute($stmt)) {
        echo "<script>
                swal('Success!', '', 'success');
                setTimeout(function(){
                    window.location.href = 'test-master';
                }, 2000);
              </script>";
        exit;
    } else {
        die(print_r(mysqli_errors(), true));
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
                                        <th>Modality</th>
                                        <th>Test Head</th>
                                        <th>Sub Test</th>
                                        <th>Unit</th>
                                        <th>Normal Rang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT id, test, modality, subtest, unit, normrang FROM pathomaster 
                                    ORDER BY id DESC";
                                    $stmt = mysqli_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(mysqli_errors(), true));
                                    }
                                    $sno = 0;
                                    while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                        $id = $row['id'];
                                        $test = $row['test'];
                                        $subtest = $row['subtest'];
                                        $modality = $row['modality'];
                                        $unit = $row['unit'];
                                        $normrang = $row['normrang'];
                                        $sno = $sno + 1;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $sno; ?>
                                            </td>
                                            <td>
                                                <?php echo $modality; ?>
                                            </td>
                                            <td>
                                                <?php echo $test; ?>
                                            </td>
                                            <td>
                                                <?php echo $subtest; ?>
                                            </td>
                                            <td>
                                                <?php echo $unit; ?>
                                            </td>
                                            <td>
                                                <?php echo $normrang; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="list-icons d-inline-flex">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-file-text"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <div class="dropdown-divider"></div>
                                                            <a href="update-lab-master?id=<?php echo $id; ?>"
                                                                class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                                                                <a href="javascript:void(0)" onclick="return confirmDelete(<?php echo $id; ?>);" class="delete dropdown-item"><i class="fa-solid fa-trash"></i> Delete</a>

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
function confirmDelete(id) {
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
            window.location.href = "?type=delete&id=" + id;
        }
    });
    return false;
}
</script>

<?php
include ('footer.php');

?>
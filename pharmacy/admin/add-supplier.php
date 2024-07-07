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
                    <h4 class="page-title">Supplier</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Add Supplier</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-right">
                    <a href="supplier-master" class="btn btn-info"><i class="fa-solid fa-circle-plus"></i> New
                        Supplier</a>
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
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Ph. No</th>
                                        <th>Email</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 0;
                                    $sql = "SELECT id, name, phone, email, address, city, dist, state, country, gst, status, addedBy FROM ph_supplier";
                                    $stmt = mysqli_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(mysqli_errors(), true));
                                    }
                                    while ($row = mysqli_fetch_array($stmt)) {
                                        $sno += 1;
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $phone = $row['phone'];
                                        $email = $row['email'];
                                        $address = $row['address'];
                                        $dist = $row['dist'];
                                        $state = $row['state'];
                                        $city = $row['city'];
                                        $country = $row['country'];
                                        $addedBy = $row['addedBy'];
                                        $status = $row['status'];
                                        $gst = $row['gst'];
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $sno; ?>
                                            </td>
                                            <td>
                                                <?php echo $name; ?>
                                            </td>
                                            <td>
                                                <?php echo $phone; ?>
                                            </td>
                                            <td>
                                                <?php echo $email; ?>
                                            </td>
                                            <td>
                                                <?php echo $city; ?>
                                            </td>
                                            <td>
                                                <?php echo $address; ?>
                                            </td>
                                            <td>
                                                <?php echo $status; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="list-icons d-inline-flex">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-file-text"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <a href="update-supplier?id=<?php echo $id; ?>&name=<?php echo $name; ?>"
                                                        class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
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
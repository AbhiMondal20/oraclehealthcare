<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>

<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-primary"><i class="mdi mdi-wheelchair-accessibility"></i>
                                </h1>
                                <?php
                                $date = date('Y-m-d');
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration WHERE rdate = '$date'";
                                $stmt = mysqli_query($conn, $sql);
                                if ($stmt) {
                                    $row = mysqli_fetch_assoc($stmt);
                                    $total = $row['totalRegistrations'];
                                } else {
                                    $total = 0;
                                    // Optionally, handle the error
                                    // echo "Error: " . mysqli_error($conn);
                                }
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>

                                <span class="badge badge-pill badge-primary px-10 mb-10">Today Sale</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="mdi mdi-wheelchair-accessibility"></i>
                                </h1>
                                <?php
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration";
                                $stmt = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($stmt);
                                $total = $row['totalRegistrations'];
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>
                                <span class="badge badge-pill badge-success px-10 mb-10">Purchase</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
<?php
include ('footer.php');
?>
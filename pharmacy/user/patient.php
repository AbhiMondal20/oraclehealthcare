<?php
session_start();
if (isset ($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>
<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Patient List</h3>
                            <h6 class="box-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <!-- table-bordered  table-hover -->
                                <table id="example" class="table display nowrap margin-top-10 w-p100">
                                    <thead>
                                        <tr>
                                            <th>Reg No</th>
                                            <th>ADM. REF</th>
                                            <th>ADM. DATE</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th>Consultant</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT regno, pname, plname, page, psex, refno, pdate, pcons, padd   FROM AdmitCard2324 
                                        WHERE regno IN (SELECT MAX(regno) FROM AdmitCard2324 GROUP BY regno)";
                                        $stmt = sqlsrv_query($conn, $sql);
                                        if ($stmt === false) {
                                            die (print_r(sqlsrv_errors(), true));
                                        }
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            $regno = $row['regno'];
                                            $pname = $row['pname'];
                                            $plname = $row['plname'];
                                            $age = $row['page'];
                                            $gender = $row['psex'];
                                            $refno = $row['refno'];
                                            // $pdate = $row['pdate']; 
                                            $pdate = $row['pdate']->format('Y-m-d');
                                            $con_doc = $row['pcons'];
                                            $padd = $row['padd'];
                                            ?>
                                            <tr>
                                                <td>
                                                <a href="discharge?regno=<?php echo $regno; ?>&pname=<?php echo $pname ?>" target="_BLANK">  <?php echo $regno; ?> </a>
                                                </td>
                                                <td>
                                                <a href="discharge?regno=<?php echo $regno; ?>&pname=<?php echo $pname ?>" target="_BLANK"><?php echo $refno; ?></a>
                                                </td>
                                                <td>
                                                    <?php echo $pdate; ?>
                                                </td>
                                                <td>
                                                <a href="discharge?regno=<?php echo $regno; ?>&pname=<?php echo $pname ?>" target="_BLANK"><?php echo $pname; ?>
                                                    <?php echo $plname; ?></a>
                                                </td>
                                                <td>
                                                    <?php echo $gender; ?>
                                                </td>
                                                <td>
                                                    <?php echo $age; ?>
                                                </td>
                                                <td>
                                                    <?php echo $con_doc; ?>
                                                </td>
                                                <td>
                                                    <?php echo $padd; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        sqlsrv_free_stmt($stmt);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
include ('footer.php');
?>
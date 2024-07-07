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
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Microbiolog</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Microbiolog</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <section class="content1">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form novalidate method="POST" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Reg. No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="rno" placeholder="Reg. No"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Form Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="form" placeholder="DD-MM-YYYY"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>To Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="to" placeholder="DD-MM-YYYY"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls mt-4">
                                                <h5><span class="text-danger"></span></h5>
                                                <button type="submit" name="search"
                                                    class="btn btn-primary btn-md">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
        <section class="content1">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-hover display nowrap">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>Bill No.</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Test</th>
                                        <th>Doctor</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset ($_POST['search'])) {
                                        $rno = $_POST['rno'];
                                        $to = $_POST['to'];
                                        $form = $_POST['form'];
                                        $sql = "SELECT MAX(b.servname) AS servname, MAX(b.billdate) AS billdate, MAX(b.billno) AS billno, MAX(b.pname) AS pname, MAX(b.id) AS id, MAX(b.rno) AS rno, MAX(r.rage) AS age, MAX(r.rsex) AS sex, MAX(bd.rdocname) AS docname, MAX(bd.uname) AS uname
                                        FROM billing AS b
                                        INNER JOIN registration AS r ON b.rno = r.rno
                                        INNER JOIN billingDetails AS bd ON r.rno = bd.rno
                                        WHERE b.billdate BETWEEN ? AND ?";
                                        if (!empty ($rno)) {
                                            $sql .= " OR b.rno = ?";
                                        }
                                        $sql .= " GROUP BY b.servname";
                                        $sql .= " ORDER BY MAX(b.id) DESC";
                                        if (!empty ($rno)) {
                                            $stmt = sqlsrv_query($conn, $sql, array(&$form, &$to, &$rno));
                                        } else {
                                            $stmt = sqlsrv_query($conn, $sql, array(&$form, &$to));
                                        }
                                        if ($stmt === false) {
                                            die (print_r(sqlsrv_errors(), true));
                                        }
                                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                            $rno = $row['rno'];
                                            $id = $row['id'];
                                            $billno = $row['billno'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rno; ?>
                                                </td>
                                                <td>
                                                    <?php echo $billno; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['billdate']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['pname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['age']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['sex']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['servname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['docname']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['uname']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="microbiology-1?id=<?php echo $id ?>&rno=<?php echo $rno; ?>&billno=<?php echo $billno; ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fa fa-file-text"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
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
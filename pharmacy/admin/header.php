<?php
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}

date_default_timezone_set("asia/kolkata");

include ('function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/icon-1.svg">
    <title>Rhythm Hospital Management Software</title>
    <link rel="stylesheet" href="css/vendors_css.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/skin_color.css">
</head>

<!-- CK Editor -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script> -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/super-build/ckeditor.js"></script> -->

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css"
    integrity="sha512-/k658G6UsCvbkGRB3vPXpsPHgWeduJwiWGPCGS14IQw3xpr63AEMdA8nMYG2gmYkXitQxDTn6iiK/2fD4T87qA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- fontawsome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"
    integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA=="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
<!-- sweet alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-success fixed">
    <div class="wrapper">
        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">
                <!-- Logo -->
                <a href="index" class="logo">
                    <!-- logo-->
                    <div class="logo-mini w-50">
                        <span class="light-logo"><img src="../images/logo-letter.png" alt="logo"></span>
                        <span class="dark-logo"><img src="../images/logo-letter.png" alt="logo"></span>
                    </div>
                    <div class="logo-lg">
                        <span class="light-logo"><img src="../images/logo-dark-text.png" alt="logo"></span>
                        <span class="dark-logo"><img src="../images/logo-light-text.png" alt="logo"></span>
                    </div>
                </a>
            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                        <li class="btn-group nav-item">
                            <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light"
                                data-toggle="push-menu" role="button">
                                <i data-feather="align-left"></i>
                            </a>
                        </li>
                        <li class="btn-group d-lg-inline-flex d-none">
                            <div class="app-menu">
                                <div class="search-bx mx-5">
                                    <form>
                                        <div class="input-group">
                                            <input type="search" class="form-control" placeholder="Search"
                                                aria-label="Search" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addon3"><i
                                                        data-feather="search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                            <a href="#" data-provide="fullscreen"
                                class="waves-effect waves-light nav-link full-screen btn-warning-light"
                                title="Full Screen">
                                <i data-feather="maximize"></i>
                            </a>
                        </li>

                        <!-- User Account-->
                        <li class="dropdown user user-menu">
                            <a href="#"
                                class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent py-0 no-shadow"
                                data-bs-toggle="dropdown" title="User">
                                <div class="d-flex pt-5">
                                    <div class="text-end me-10">
                                        <p class="pt-5 fs-14 mb-0 fw-700 text-primary"
                                            style="text-transform: capitalize;">
                                            <?php echo $login_username; ?>
                                        </p>
                                    </div>
                                    <img src="../images/avatar/avatar-1.png"
                                        class="avatar rounded-10 bg-primary-light h-40 w-40" alt="" />
                                </div>
                            </a>
                            <ul class="dropdown-menu animated flipInX">
                                <li class="user-body">
                                    <a class="dropdown-item" href="#"><i class="ti-user text-muted me-2"></i>
                                        Profile</a>
                                    <a class="dropdown-item" href="#"><i class="ti-settings text-muted me-2"></i>
                                        Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../../logout"><i class="ti-lock text-muted me-2"></i>
                                        Logout</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <!-- sidebar-->
            <section class="sidebar position-relative">
                <div class="multinav">
                    <div class="multinav-scroll" style="height: 100%;">
                        <!-- sidebar menu-->
                        <ul class="sidebar-menu" data-widget="tree">
                            <li>
                                <a href="index">
                                    <i data-feather="monitor"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i data-feather="file"></i>
                                    <span>Master</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="add-supplier">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Add Supplier</a>
                                    </li>
                                    <li>
                                        <a href="unit-master">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Unit Master
                                        </a>
                                    </li>
                                    <li>
                                        <a href="medicine-group">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Medicine Group
                                        </a>
                                    </li>
                                    <li>
                                        <a href="medicine-category">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Medicine Category
                                        </a>
                                    </li>
                                    <li>
                                        <a href="medicine-master">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Medicine Master
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="reg-list">
                                    <i class="fa-solid fa-hospital-user"></i>
                                    <span>Patient List</span>
                                </a>
                            </li>
                            <li>
                                <a href="reg">
                                    <i class="fa-solid fa-hospital-user"></i>
                                    <span>New Registration</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i data-feather="file"></i>
                                    <span>Billing</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="opd-billing2">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                            <span>OPD Billing</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="return-billing">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                            <span>Return Billing</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="money-receipt-list">
                                    <i data-feather="inbox"></i>
                                    <span>Money Receipt</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i data-feather="file"></i>
                                    <span>Reports</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="user-wise-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>User Wise Report
                                        </a>
                                        <a href="total-cash-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Total Cash Reports
                                        </a>
                                        <a href="daily-cash-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Daily Cash Report
                                        </a>
                                        <a href="doctor-wise-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Doctor Wise Report
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i data-feather="file"></i>
                                    <span>Billing Reports</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="user-wise-bill-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>User Wise Bill Report
                                        </a>
                                        <a href="total-cash-bill-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Total Cash Bill Reports
                                        </a>
                                        <a href="daily-cash-bill-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Daily Cash Bill Report
                                        </a>
                                        <a href="return-bill-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Return Bill
                                        </a>
                                        <a href="due-bill-report">
                                            <i class="icon-Commit"><span class="path1"></span><span
                                                    class="path2"></span></i>Due Bill
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </aside>
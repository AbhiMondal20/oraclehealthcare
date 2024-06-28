<?php
session_start();
if (isset ($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="opd/images/favicon.ico">
    <title>Rhythm Healthcare - Main Dashboard </title>
    <link rel="stylesheet" href="opd/admin/css/vendors_css.css">
    <!-- Style-->
    <link rel="stylesheet" href="opd/admin/css/style.css">
    <link rel="stylesheet" href="opd/admin/css/skin_color.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="hold-transition light-skin sidebar-mini theme-success fixed">
    <div class="wrapper">
        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">
                <!-- Logo -->
                <a href="index" class="logo">
                    <!-- logo-->
                    <div class="logo-mini w-50">
                        <span class="light-logo"><img src="opd/images/logo-letter.png" alt="logo"></span>
                        <span class="dark-logo"><img src="opd/images/logo-letter.png" alt="logo"></span>
                    </div>
                    <div class="logo-lg">
                        <span class="light-logo"><img src="opd/images/logo-dark-text.png" alt="logo"></span>
                        <span class="dark-logo"><img src="opd/images/logo-light-text.png" alt="logo"></span>
                    </div>
                </a>
            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
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
                                    <img src="opd/images/avatar/avatar-1.png"
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
                                    <a class="dropdown-item" href="logout"><i class="ti-lock text-muted me-2"></i>
                                        Logout</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Content Wrapper. Contains page content -->
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
                                        <h2>4,569</h2>
                                        <span class="badge badge-pill badge-primary px-10 mb-10">Patient</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <div class="box">
                                <div class="box-body">
                                    <div class="text-center">
                                        <h1 class="fs-50 text-warning"><i class="mdi mdi-file-document"></i></h1>
                                        <h2>23,009</h2>
                                        <span class="badge badge-pill badge-warning px-10 mb-10">Encounters</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <div class="box">
                                <div class="box-body">
                                    <div class="text-center">
                                        <h1 class="fs-50 text-info"><i class="mdi mdi-calendar-multiple"></i></h1>
                                        <h2>56</h2>
                                        <span class="badge badge-pill badge-info px-10 mb-10">Appointments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <div class="box">
                                <div class="box-body">
                                    <div class="text-center">
                                        <h1 class="fs-50 text-success"><i class="mdi mdi-heart-pulse"></i></h1>
                                        <h2>12,100</h2>
                                        <span class="badge badge-pill badge-success px-10 mb-10">Lab</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <div class="box">
                                <div class="box-body">
                                    <div class="text-center">
                                        <h1 class="fs-50 text-danger"><i class="fa-solid fa-prescription"></i></h1>
                                        <h2>14,023</h2>
                                        <span class="badge badge-pill badge-danger px-10 mb-10">Prescription</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <div class="box">
                                <div class="box-body">
                                    <div class="text-center">
                                        <h1 class="fs-50 text-dark"><i class="mdi mdi-redo-variant"></i></h1>
                                        <h2>4,567</h2>
                                        <span class="badge badge-pill badge-dark px-10 mb-10">Referral</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
        <script src="opd/admin/js/vendors.min.js"></script>
        <script src="opd/admin/js/pages/chat-popup.js"></script>
        <script src="opd/admin/assets/icons/feather-icons/feather.min.js"></script>
</body>

</html>
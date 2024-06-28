<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $username = $_SESSION['username'];
} else {
    echo "<script>location.href='/login';</script>";
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
    <!-- Vendors Style-->
    <link rel="stylesheet" href="opd/admin/css/vendors_css.css">
    <!-- Style-->
    <link rel="stylesheet" href="opd/admin/css/style.css">
    <link rel="stylesheet" href="opd/admin/css/skin_color.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
                                            <?php echo $username; ?>
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
                                    <a class="dropdown-item" href="logout"><i
                                            class="ti-lock text-muted me-2"></i>
                                        Logout</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xl-2 col-md-6 col-6">
                            <a href="opd/admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center">
                                            <h1 class="fs-50 text-primary"><i class="fa-solid fa-hospital"></i></h1>
                                            <span class="badge badge-pill badge-primary px-10 mb-10">OPD</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <a href="diagnostic/admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center">
                                            <h1 class="fs-50 text-primary"><i class="fa-solid fa-hospital"></i></h1>
                                            <span class="badge badge-pill badge-primary px-10 mb-10">Diagnostic</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <a href="pharmacy/admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center">
                                            <h1 class="fs-50 text-primary"><i class="fa-solid fa-hospital"></i></h1>
                                            <span class="badge badge-pill badge-primary px-10 mb-10">Pharmacy</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </div>
</body>
<footer class="main-footer">
    &copy;
    <script>document.write(new Date().getFullYear())</script> <a href="">Rhythm</a>. All Rights Reserved.
</footer>

<!-- Vendor JS -->
<script src="opd/admin/js/vendors.min.js"></script>
<script src="opd/admin/js/pages/chat-popup.js"></script>
<script src="opd/assets/icons/feather-icons/feather.min.js"></script>

<script src="opd/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
<script src="opd/assets/vendor_components/echarts/dist/echarts-en.min.js"></script>

<!-- Rhythm Admin App -->
<script src="opd/admin/js/template.js"></script>
<script src="opd/admin/js/pages/dashboard4.js"></script>



<script src="opd/assets/vendor_components/date-paginator/moment.min.js"></script>
<script src="opd/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="opd/assets/vendor_components/date-paginator/bootstrap-datepaginator.min.js"></script>

<script src="opd/assets/icons/feather-icons/feather.min.js"></script>
<script src="opd/assets/vendor_components/datatable/datatables.min.js"></script>


<script src="opd/admin/js/pages/validation.js"></script>
<script src="opd/admin/js/pages/form-validation.js"></script>

<script src="opd/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
<script src="opd/assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="opd/assets/vendor_components/select2/dist/js/select2.full.js"></script>
<script src="opd/assets/vendor_plugins/input-mask/jquery.inputmask.js"></script>
<script src="opd/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="opd/assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="opd/assets/vendor_components/moment/min/moment.min.js"></script>
<script src="opd/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="opd/assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="opd/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="opd/assets/vendor_plugins/iCheck/icheck.min.js"></script>

<!-- Rhythm Admin App -->
<script src="opd/admin/js/pages/advanced-form-element.js"></script>

<script src="opd/admin/js/pages/dashboard.js"></script>
<script src="opd/admin/js/pages/data-table.js"></script>

<script src="opd/assets/vendor_plugins/JqueryPrintArea/demo/jquery.PrintArea.js"></script>

<script src="opd/admin/js/pages/invoice.js"></script>

</body>

</html>
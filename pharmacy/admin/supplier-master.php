<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

?>
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
                                <li class="breadcrumb-item" aria-current="page">Pharmacy</li>
                                <li class="breadcrumb-item active" aria-current="page">Supplier Master</li>
                            </ol>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Basic Forms -->
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form novalidate method="POST" action="">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="name" tabindex="1" data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="phone"
                                                    tabindex="2" id="phoneInput" maxlength="10" minlength="10"
                                                    data-validation-required-message="This field is required"
                                                    onblur="checkPhoneNumber()">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Email <span class="text-danger">*</span></h5>
                                                <input type="email" class="form-control" required name="email" data-validation-required-message="This field is required" tabindex="3">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="address"
                                                    tabindex="4"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>City <span class="text-danger">*</span></h5>
                                            <input list="city" name="rcity" id="rcity" class="form-control" tabindex="5">
                                            <datalist id="city">
                                                <option selected disabled>Select City</option>
                                                <?php
                                                $sql = "SELECT Cityname FROM citymaster";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                } else {
                                                    while ($row = mysqli_fetch_array($stmt)) {
                                                        $Cityname = $row['Cityname'];
                                                        echo '<option value="' . $Cityname . '">' . $Cityname . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>District <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="rdist" id="rdist">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>State <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="rstate" id="rstate">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Country <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="rcountry" id="rcountry">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>GST <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="gst" id="gst" tabindex="6">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Status </h5>
                                            <select class="form-select" name="status" tabindex="7">
                                                <option selected disabled>Select</option>
                                                <option value="Active">Active</option>
                                                <option value="Deactive">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="addedBy" value="<?php echo $login_username; ?>" tabindex="8">
                                </div>
                            </div>
                            <center>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="save" tabindex="9">SAVE</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
</section>
</div>
</div>
<!-- /.content-wrapper -->
<script>

    // City to dist Dependency
    $(document).ready(function () {
        $('#rcity').change(function () {
            var selectedCity = $(this).val();
            getDistrictStateCountry(selectedCity);
        });

        function getDistrictStateCountry(rcity) {
            $.ajax({
                url: "load/get_dist.php",
                type: "POST",
                data: { rcity: rcity },
                dataType: "json",
                success: function (data) {
                    $("#rdist").val(data.distname);
                    $("#rstate").val(data.state);
                    $("#rcountry").val(data.country);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // Mobile number check
    function checkPhoneNumber() {
        var phoneNumber = document.getElementById('phoneInput').value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "exists") {
                    swal({
                        title: 'Phone number already registered!',
                        text: 'Please enter a different phone number.',
                        icon: 'warning',
                        button: 'OK',
                    });
                    document.getElementById('phoneInput').value = '';
                }
            }
        };
        xhttp.open("GET", "load/checkPhoneNumber.php?phoneNumber=" + phoneNumber, true);
        xhttp.send();
    }
</script>

<?php
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $dist = $_POST['rdist'];
    $state = $_POST['rstate'];
    $city = $_POST['rcity'];
    $country = $_POST['rcountry'];
    $addedBy = $_POST['addedBy'];
    $status = $_POST['status'];
    $gst = $_POST['gst'];
    $sql = "INSERT INTO `ph_supplier`(`name`, `phone`, `email`, `address`, `city`, `dist`, `state`, `country`, `gst`, `status`, `addedBy`) VALUES ('$name', '$phone', '$email', '$address', '$city', '$dist', '$state', '$country', '$gst', '$status', '$addedBy')";
    $stmt = mysqli_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(mysqli_errors(), true));
    } else {
        echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href = window.location.href;
                    }, 1000);
              </script>';
    }
}

include ('footer.php');
?>
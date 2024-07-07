<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
$id = $_GET['id'];
$name = $_GET['name'];
$sql = "SELECT phone, email, address, city, dist, state, country, gst, status, addedBy FROM ph_supplier WHERE id = '$id' AND name ='$name'";
$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($stmt)) {
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
}

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
                                                <input type="text" class="form-control" required name="name" value="<?php echo $name; ?>" tabindex="1" data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" value="<?php echo $phone; ?>" required name="phone" tabindex="2" maxlength="10" minlength="10" data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Email <span class="text-danger">*</span></h5>
                                                <input type="email" class="form-control" value="<?php echo $email; ?>" required name="email" data-validation-required-message="This field is required" tabindex="3">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="address"
                                                    tabindex="4" value="<?php echo $address; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>City <span class="text-danger">*</span></h5>
                                            <input list="city" name="city" id="rcity" value="<?php echo $city; ?>" class="form-control" tabindex="5">
                                            <datalist id="rcity">
                                                <option selected disabled>Select City</option>
                                                <?php
                                                $sql = "SELECT Cityname FROM citymaster";
                                                $result = mysqli_query($conn, $sql);
                                                
                                                if ($result === false) {
                                                    die("Error executing query: " . mysqli_error($conn));
                                                } else {
                                                    while ($row = mysqli_fetch_assoc($result)) {
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
                                            <input type="text" class="form-control" name="dist" id="rdist" value="<?php echo $dist; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>State <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="state" id="rstate" value="<?php echo $state; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Country <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="country" id="rcountry" value="<?php echo $country; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>GST <span class="text-danger">*</span></h5>
                                            <input type="text" class="form-control" name="gst" id="gst" value="<?php echo $gst; ?>" tabindex="6">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Status </h5>
                                            <select class="form-select" name="status" tabindex="7">
                                                <option selected disabled>Select</option>
                                                <option value="Active" <?php echo ($status === 'Active') ? 'selected' : ''; ?>>Active</option>
                                                <option value="Deactive" <?php echo ($status === 'Deactive') ? 'selected' : ''; ?>>Deactive</option>
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
        $('#city').change(function () {
            var selectedCity = $(this).val();
            getDistrictStateCountry(selectedCity);
        });

        function getDistrictStateCountry(city) {
            $.ajax({
                url: "load/get_dist.php",
                type: "POST",
                data: { city: city },
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
    $gst = $_POST['gst'];
    $dist = $_POST['dist'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $addedBy = $_POST['addedBy'];
    $status = $_POST['status'];
    $updatedDate = date('d-m-y H:i');

    $sql = "UPDATE `ph_supplier` SET `name`=?, `phone`=?, `email`=?, `address`=?, `city`=?, `dist`=?, `state`=?, `country`=?, `gst`=?, `status`=?, `updatedBy`=?, `updatedDate`=? WHERE id=?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die("Statement preparation failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'sssssssssssss', $name, $phone, $email, $address, $city, $dist, $state, $country, $gst, $status, $login_username, $updatedDate, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "add-supplier";
                }, 1000);
              </script>';
    } else {
        die("Statement execution failed: " . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);
}


include ('footer.php');
?>
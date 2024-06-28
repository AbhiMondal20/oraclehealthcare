<?php
session_start();
include ('header.php');
?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Discharge Summary</h4>
                        </div>
                        <div class="box-body">
                            <div class="col-sm-12">
                                <table class="table border-no no-footer" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <!-- <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Patient ID: activate to sort column descending">Patient ID
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1"
                                                aria-label="Date Check In: activate to sort column ascending">Date Check
                                                In</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1"
                                                aria-label="Patient Name: activate to sort column ascending">Patient
                                                Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1"
                                                aria-label="Doctor Assgined: activate to sort column ascending">Doctor
                                                Assgined</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Disease: activate to sort column ascending">
                                                Disease</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Status: activate to sort column ascending">
                                                Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Room No: activate to sort column ascending">Room
                                                No</th>
                                        </tr> -->
                                    </thead>
                                    <tbody>
                                        <tr class="hover-primary odd" role="row">
                                            <?php
                                            $regno = $_GET['regno'];
                                            $pname = $_GET['pname'];
                                            $sql = "SELECT * FROM AdmitCard2324 WHERE regno = '$regno' AND pname='$pname'";
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
                                            }
                                            ?>
                                            <td class="sorting_1"> Reg No: &nbsp;
                                                <?php echo $regno; ?>
                                            </td>
                                            <td> ADM. DATE : &nbsp;
                                                <?php echo $pdate; ?>
                                            </td>
                                            <td>Name:&nbsp;
                                                <?php echo $pname; ?>
                                                <?php echo $plname; ?>
                                            </td>
                                            <td>Consultant: &nbsp;
                                                <?php echo $con_doc; ?>
                                            </td>
                                            <td>Age: &nbsp;
                                                <?php echo $age; ?> YEARS
                                            </td>
                                            <td>GENDER: &nbsp;
                                                <?php echo $gender; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form class="form" method="POST">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Discharge Type</label>
                                            <select class="form-control select2" tabindex="-1" aria-hidden="true"
                                                name="dis_type">
                                                <option selected="selected">Select Discharge Type</option>
                                                <option value="CASE SUMMARY">CASE SUMMARY</option>
                                                <option value="DEATH SUMMARY">DEATH SUMMARY</option>
                                                <option value="DISCHARGE ON REQUEST">DISCHARGE ON REQUEST</option>
                                                <option value="DISCHARGE SUMMARY">DISCHARGE SUMMARY</option>
                                                <option value="GAMA SUMMARY">GAMA SUMMARY</option>
                                                <option value="LAMA SUMMARY">LAMA SUMMARY</option>
                                                <option value="LEFT AGAINEST MEDICAL ADVICE">LEFT AGAINEST MEDICAL
                                                    ADVICE</option>
                                                <option value="SURGICAL DISCHARGE SUMMARY">SURGICAL DISCHARGE SUMMARY
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <input class="form-control" type="hidden" value="<?php echo $regno; ?>" name="regno">
                                    <input class="form-control" type="hidden" value="<?php echo $refno; ?>" name="refno">
                                    <input class="form-control" type="hidden" value="<?php echo $pname; ?>" name="pname">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">DISCHARGE DATE</label>
                                            <input class="form-control" type="datetime-local" name="discharge_date">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label class="form-label">PRESENTING COMPLAINTS AT THE TIME OF ADMISSION WITH
                                            DURATION:- </label>
                                        <textarea name="presenting_complaints"
                                            placeholder="PRESENTING COMPLAINTS AT THE TIME OF ADMISSION WITH DURATION"
                                            ></textarea>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <label class="form-label">FINAL DIAGNOSIS AT THE TIME OF DISCHARGE:-</label>
                                        <textarea name="final_diagnosis"
                                            placeholder="FINAL DIAGNOSIS AT THE TIME OF DISCHARGE:-"
                                            ></textarea>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label class="form-label">PAST MEDICAL / SURGICAL HISTORY IF ANY:- </label>
                                            <textarea class="form-control"
                                                placeholder="PAST MEDICAL / SURGICAL HISTORY IF ANY:- "
                                                name="past_history" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label class="form-label">PHYSICAL EXAMINATION ON ADMISSION:-</label>
                                            <textarea name="phy_examination" class="form-control"
                                                placeholder="PHYSICAL EXAMINATION ON ADMISSION:-"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label class="form-label">SYSTEMIC EXAMINATION </label>
                                            <textarea class="form-control" placeholder="SYSTEMIC EXAMINATION "
                                                name="systemic_examin"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="form-group">
                                        <label class="form-label">SUMMARY OF INVESTIGATION:-</label>
                                        <textarea type="text" class="form-control"
                                            placeholder="SUMMARY OF INVESTIGATION:-"
                                            name="summary_invest">Enclosed</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label class="form-label">COURSE & DISCUSSION INCLUDING
                                                COMPLICATION:-</label>
                                            <textarea name="course_discussion"
                                                placeholder="COURSE & DISCUSSION INCLUDING COMPLICATION:-"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label class="form-label">CONDITION ON DISCHARGE –</label>
                                            <textarea name="condition_discharge"
                                                placeholder="CONDITION ON DISCHARGE –"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        <div class="form-group">
                                            <label class="form-label">ADVICE ON DISCHARGE </label>
                                            <textarea name="advice_on_discharge"
                                                placeholder="ADVICE ON DISCHARGE "></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <center><input type="submit" class="btn btn-primary" value="Save" name="save"></center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
if (isset($_POST['save'])) {
    $dis_type = $_POST['dis_type'];
    $regno = $_POST['regno'];
    $refno = $_POST['refno'];
    $pname = $_POST['pname'];
    $discharge_date = $_POST['discharge_date'];
    $presenting_complaints = $_POST['presenting_complaints'];
    $final_diagnosis = $_POST['final_diagnosis'];
    $past_history = $_POST['past_history'];
    $phy_examination = $_POST['phy_examination'];
    $systemic_examin = $_POST['systemic_examin'];
    $summary_invest = $_POST['summary_invest'];
    $course_discussion = $_POST['course_discussion'];
    $condition_discharge = $_POST['condition_discharge'];
    $advice_on_discharge = $_POST['advice_on_discharge'];
    $username = 'admin';

    $sql = "INSERT INTO discharge (regno, refno, pname, dis_type, discharge_date, presenting_complaints, final_diagnosis, past_history, phy_examination, systemic_examin, summary_invest, course_discussion, condition_discharge, advice_on_discharge, username)
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $params = array(
        &$regno,
        &$refno,
        &$pname,
        &$dis_type,
        &$discharge_date,
        &$presenting_complaints,
        &$final_diagnosis,
        &$past_history,
        &$phy_examination,
        &$systemic_examin,
        &$summary_invest,
        &$course_discussion,
        &$condition_discharge,
        &$advice_on_discharge,
        &$username
    );

    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error preparing statement: " . print_r(sqlsrv_errors(), true);
    } else {
        $res = sqlsrv_execute($stmt);
        if ($res === false) {
            echo "Error inserting data: " . print_r(sqlsrv_errors(), true);
        } else {
            echo "<script>
            swal({
                title: 'Successfull!',
                text: 'Thank you!',
                icon: 'success',
                button: 'Ok!',
            }).then(function() {
                window.open('discharge_pdf?regno=$regno&refno=$refno', '_blank');
            });
        </script>";
        }
    }

    // Free statement resources
    sqlsrv_free_stmt($stmt);
}

include ('footer.php');
?>
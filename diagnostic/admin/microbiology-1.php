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
                    <h4 class="page-title">Microbiology</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Microbiology</li>
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
                        <div class="4">

                        </div>
                        <div class="col-12">
                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs justify-content-end" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                                                href="#VDRL" role="tab"><span class="hidden-sm-up"><i
                                                        class="ion-home"></i></span>
                                                <span class="hidden-xs-down">VDRL</span></a>
                                        </li>
                                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#Widal"
                                                role="tab"><span class="hidden-sm-up"><i class="ion-person"></i></span>
                                                <span class="hidden-xs-down">Widal Test</span></a>
                                        </li>
                                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                href="#Prothrombin" role="tab"><span class="hidden-sm-up">
                                                    <i class="ion-email"></i></span> <span
                                                    class="hidden-xs-down">Prothrombin Time</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Remark"
                                                role="tab"><span class="hidden-sm-up">
                                                    <i class="ion-email"></i></span> <span
                                                    class="hidden-xs-down">Remark</span></a>
                                        </li>
                                    </ul>
                                    <form method="POST" action="">
                                        <div class="tab-content tabcontent-border">
                                            <div class="tab-pane active" id="VDRL" role="tabpanel">
                                                <div class="p-15">
                                                    <div class="row">
                                                        <hr>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <h5>V.D.R.L <span class="text-danger">*</span></h5>
                                                                <input type="text" name="vdrl" class="form-control">
                                                                <input type="text" name="vdrl2" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="text" name="vdrl3" class="form-control">
                                                                <input type="text" name="vdrl4" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <h5>SERUM HBsAg <span class="text-danger">*</span></h5>
                                                                <input type="text" name="serum1" class="form-control">
                                                                <input type="text" name="serum2" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="text" name="serum3" class="form-control">
                                                                <input type="text" name="serum4" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <h5>SERUM RA FACTOR<span class="text-danger">*</span>
                                                                </h5>
                                                                <input type="text" name="serum-ra-factor"
                                                                    class="form-control">
                                                                <input type="text" name="serum-ra-factor2"
                                                                    class="form-control"
                                                                    value="(Concentration of R.A. Factor is less than 10 IU/ml. of serum by latex Agglutination method.)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="text" name="serum-ra-factor3"
                                                                    class="form-control">
                                                                <input type="text" name="serum-ra-factor4"
                                                                    class="form-control">
                                                                <input type="text" name="serum-ra-factor5"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <h5>SERUM A.S.O. TITRE <span
                                                                            class="text-danger">*</span></h5>
                                                                    <input type="text" name="aso" class="form-control">
                                                                    <input type="text" name="aso2" class="form-control">
                                                                    <input type="text" name="aso3" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <input type="text" class="form-control" name="aso4">
                                                                    <input type="text" class="form-control" name="aso5">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="Widal" role="tabpanel">
                                                <div class="p-15">
                                                    <div class="row">
                                                        <label for="">WIDAL TEST</label>
                                                        <hr>
                                                        <div class="col-md-2">
                                                            <label for="">Antigen</label>
                                                            <div class="form-group">
                                                                <h5>S. Typhi 'O' <span class="text-danger">*</span></h5>
                                                                <input type="text" name="s-typhi-o"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <h5>S. Typhi 'H' <span class="text-danger">*</span></h5>
                                                                <input type="text" name="s-typhi-h"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <h5>S.Paatyphi 'AH' <span class="text-danger">*</span>
                                                                </h5>
                                                                <input type="text" name="s-paatyphi-ah'"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <h5>S.Paratyphi 'BH'</h5>
                                                                <input type="text" name="s-paratyphi-bh'"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <input type="text" name="s-paratyphi-bh2"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <h5>ALDEHYDE TEST</h5>
                                                                <input type="text" name="aldehyde-test"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <h5>Blood Group (A B O)</h5>
                                                                <input type="text" name="bood-group"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <h5>Rh/D Type</h5>
                                                                <input type="text" name="rh-d-type"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <h5>SERUM FOR C.R.P <span
                                                                            class="text-danger">*</span>
                                                                    </h5>
                                                                    <input type="text" name="serum-cpr"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    </h5>
                                                                    <input type="text" name="serum-cpr2"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    </h5>
                                                                    <input type="text" name="serum-cpr3"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    </h5>
                                                                    <input type="text" name="serum-cpr3"
                                                                        value="(Serum Concentration of C.R.P is less than 0.6 mg/dl. By latex Agglutination method.)"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="Prothrombin" role="tabpanel">
                                                <div class="p-15">
                                                    <div class="row">
                                                        <hr>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <input type="text" name="prothrombin"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label for="">Prothrombin Time:</label>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">CONTROL</label>
                                                                <div class="controls">
                                                                    <input type="text" name="control"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">TEST</label>
                                                                <div class="controls">
                                                                    <input type="text" name="test" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <h5>RATIO</h5>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control"
                                                                        name="ratio">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="">INDEX</label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control"
                                                                        name="index">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="">HIV</label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control" name="hiv">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="">Serum HCV</label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control"
                                                                        name="serum-hcv">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="">TPHA</label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control" name="tpha">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <input type="text" class="form-control"
                                                                        name="tpha2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="Remark" role="tabpanel">
                                                <div class="p-15">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <h5>Remark <span class="text-danger">*</span></h5>
                                                                <div class="controls">
                                                                    <textarea cols="20" rows="10" name="remark"
                                                                        class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <center>
                                                <button type="submit" class="btn btn-primary" name="save">SAVE</button>
                                            </center>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
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
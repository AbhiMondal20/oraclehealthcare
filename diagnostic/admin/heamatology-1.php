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
                    <h4 class="page-title">Heamatology</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href=""><i class="mdi mdi-home-outline"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Heamatology</li>
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
                                        <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#HM"
                                                role="tab"><span class="hidden-sm-up"><i class="ion-home"></i></span>
                                                <span class="hidden-xs-down">HM/PCV/MCV/MCH/BT/CT</span></a>
                                        </li>
                                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#TC"
                                                role="tab"><span class="hidden-sm-up"><i class="ion-person"></i></span>
                                                <span class="hidden-xs-down">TC/DC/RBC/WBC/MP</span></a>
                                        </li>
                                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#MP"
                                                role="tab"><span class="hidden-sm-up">
                                                    <i class="ion-email"></i></span> <span
                                                    class="hidden-xs-down">MP</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Mantoux"
                                                role="tab"><span class="hidden-sm-up">
                                                    <i class="ion-email"></i></span> <span
                                                    class="hidden-xs-down">Mantoux/Sugar/Customize</span></a>
                                        </li>
                                    </ul>
                                    <form method="POST" action="">
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active" id="HM" role="tabpanel">
                                            <div class="p-15">
                                                <div class="row">
                                                    <label for="">Blood Analysis</label>
                                                    <hr>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>No of Lines <span class="text-danger">*</span></h5>
                                                            <input type="text" name="lines" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Heamoglobin <span class="text-danger">*</span></h5>
                                                            <input type="text" name="heamoglobin" class="form-control">
                                                            <input type="text" name="heamoglobin2"
                                                                value="(Cyanmethaemoglobin Method )"
                                                                class="form-control">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5>gm/dl <span class="text-danger">*</span></h5>
                                                            <input type="text" name="gm-dl"
                                                                value="Men- 13.5-18.0 gm/dl.">
                                                            <input type="text" name="gm-dl2"
                                                                value="Women- 11.5-16.4 gm/dl.">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <h5>E.S.R. <span class="text-danger">*</span></h5>
                                                                <input type="text" name="esr"
                                                                    class="form-control">MM/1st hr
                                                                <input type="text" name="esr2" class="form-control"
                                                                    value="Westergren">
                                                                <input type="text" name="esr3" class="form-control"
                                                                    value="00-10 mm /1st  hr.">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label for="">Total Count</label>
                                                    <hr>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>R.B.C Count <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="rbc">
                                                                <input type="text" class="form-control" name="rbc2"
                                                                    value="4.0-6.5 X 10^6   /cmm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Unit <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="rbc-unit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>W.B.C Count <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="wbc">
                                                                <input type="text" class="form-control" name="wbc2"
                                                                    value="4000-11000   /cmm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Unit <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="wbc-unit">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Platelet Count <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="platelet">
                                                                <input type="text" class="form-control" name="platelet2"
                                                                    value="1.5-4.0 X 10^5   /cmm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Unit <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="wbc-unit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label for="">Absoluate Value</label>
                                                    <hr>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h5>Actual Ranges </h5>
                                                            <input type="text" class="form-control" name="pcv"
                                                                placeholder="PCV %">
                                                            <input type="text" class="form-control" name="mcv"
                                                                placeholder="MCV fl">
                                                            <input type="text" class="form-control" name="mch"
                                                                placeholder="MCH pg">
                                                            <input type="text" class="form-control" name="mchc"
                                                                placeholder="MCHC %">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h5>Normal Ranges </h5>
                                                            <input type="text" class="form-control" name="nor-rng1"
                                                                placeholder="35-45 %">
                                                            <input type="text" class="form-control" name="nor-rng2"
                                                                placeholder="76-96 fl">
                                                            <input type="text" class="form-control" name="nor-rng3"
                                                                placeholder="27-33 pg">
                                                            <input type="text" class="form-control" name="nor-rng4"
                                                                placeholder="30-35  mg./dl.">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">Bleeding Time</label>
                                                            <input type="text" class="form-control" name="bleeding-time"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">Minutes</label>
                                                            <input type="text" class="form-control" name="bleeding-min"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">Seconds</label>
                                                            <input type="text" class="form-control" name="bleeding-sec"
                                                                placeholder="1 - 5 mins">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2"></label>
                                                            <input type="text" class="form-control" name="bleeding-sec"
                                                                placeholder="" value="Duke's Method">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">Coagulation Time</label>
                                                            <input type="text" class="form-control"
                                                                name="coagulation-time" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">Minutes</label>
                                                            <input type="text" class="form-control"
                                                                name="coagulation-min" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="">Seconds</label>
                                                            <input type="text" class="form-control"
                                                                name="coagulation-sec" placeholder="2 - 9 mins"
                                                                value="2 - 9 mins">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="" class="mt-2"></label>
                                                            <input type="text" class="form-control"
                                                                name="coagulation-sec" placeholder=""
                                                                value="Capillary Method">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="uname"
                                                        value="<?php echo $login_username; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="TC" role="tabpanel">
                                            <div class="p-15">
                                                <div class="row">
                                                    <label for="">Differencial Count</label>
                                                    <hr>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Neutrophil <span class="text-danger">*</span></h5>
                                                            <input type="text" name="neutrophil" class="form-control">
                                                            <input type="text" name="neutrophil2" class="form-control"
                                                                placeholder="" value="40-74 %">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Lymphocyte <span class="text-danger">*</span></h5>
                                                            <input type="text" name="lymphocyte" class="form-control">
                                                            <input type="text" name="lymphocyte2" value="20-45 %"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Eosinophil <span class="text-danger">*</span></h5>
                                                            <input type="text" name="eosinophil" value="">
                                                            <input type="text" name="eosinophil2" value="01-06 %">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Monocyte</h5>
                                                            <input type="text" name="monocyte" value="">
                                                            <input type="text" name="monocyte2" value="00-10 %">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Basophil</h5>
                                                            <input type="text" name="basophil" value="">
                                                            <input type="text" name="basophil2" value="00-01 %">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Band Cell</h5>
                                                            <input type="text" name="band-cell" value=""
                                                                placeholder="%">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Promyelocytes</h5>
                                                            <input type="text" name="promyelocytes" value=""
                                                                placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Reticulocyte Count</h5>
                                                            <input type="text" name="reticulocyte-count" value=""
                                                                placeholder="%">
                                                            <input type="text" name="reticulocyte-count2" value=""
                                                                placeholder="%">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <h5>Myelocytes <span class="text-danger">*</span></h5>
                                                                <input type="text" name="myelocytes"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <h5>Blast Cell <span class="text-danger">*</span></h5>
                                                                <input type="text" name="blast-cell"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <h5>Metamyelocytes <span class="text-danger">*</span>
                                                                </h5>
                                                                <input type="text" name="metamyelocytes"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <h5>Note <span class="text-danger">*</span></h5>
                                                                <input type="text" name="note" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <h5>Micro Filaria <span class="text-danger">*</span>
                                                                </h5>
                                                                <input type="text" name="micro-filaria"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h3>Peripheral Blood Semar</h3>
                                                    <hr>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5>RCB <span class="text-danger"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="rcb">
                                                                    <option value="">--</option>
                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5><span class="text-danger mt-3"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="rcb">
                                                                    <option value="">--</option>

                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5><span class="text-danger mt-3"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="rcb1">
                                                                    <option value="">--</option>

                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5> <span class="text-danger mt-3"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="rcb2">
                                                                    <option value="">--</option>

                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5>WBC <span class="text-danger"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="wbc">
                                                                    <option value="">--</option>
                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5><span class="text-danger mt-3"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="wbc1">
                                                                    <option value="">--</option>

                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5><span class="text-danger mt-3"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="wbc2">
                                                                    <option value="">--</option>

                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5> <span class="text-danger mt-3"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="wbc3">
                                                                    <option value="">--</option>

                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <h5>Platelet <span class="text-danger mt-3"></span></h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="wbc3">
                                                                    <option value="">--</option>

                                                                    <option value="Acanthocytes">Acanthocytes</option>
                                                                    <option value="Hypochromic with anisocytosis">
                                                                        Hypochromic with anisocytosis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Malaria Parasite <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control"
                                                                    name="malaria-parasite">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Malaria Antigen P.V. <span class="text-danger">*</span>
                                                            </h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control"
                                                                    name="malaria-parasite">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Malaria Antigen P.F. <span class="text-danger">*</span>
                                                            </h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control"
                                                                    name="malaria-parasite">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="uname"
                                                        value="<?php echo $login_username; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="MP" role="tabpanel">
                                            <div class="p-15">
                                                <div class="row">
                                                    <hr>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <h5>Malaria Parasite <span class="text-danger"></span></h5>
                                                            <div class="controls">
                                                                <input type="text" name="malaria-parasite"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="malaria-parasite2"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="malaria-parasite3"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <h5>Comment <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="comment">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            </h5>
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="comment2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="comment3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="comment4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" class="form-control" name="comment5">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" class="form-control" name="uname"
                                                        value="<?php echo $login_username; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="Mantoux" role="tabpanel">
                                            <div class="p-15">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <h5>Mantoux <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" name="mantoux" class="form-control">
                                                                <input type="text" name="mantoux2" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <h5>Tuppd <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" name="tuppd" class="form-control">
                                                                <input type="text" name="tuppd2" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <h5>Induration After <span class="text-danger">*</span></h5>
                                                            <div class="controls">
                                                                <input type="text" name="indurationa-fter"
                                                                    class="form-control">
                                                                <input type="text" name="indurationa-fter2"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h5>Blood Group (A B O) <span class="text-danger">*</span>
                                                            </h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="rcb">
                                                                    <option value="">--</option>
                                                                    <option value="A">A</option>
                                                                    <option value="B">B</option>
                                                                    <option value="O">O</option>
                                                                    <option value="AB">AB</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <h5>Rh Type <span class="text-danger">*</span>
                                                            </h5>
                                                            <div class="controls">
                                                                <select class="form-select" name="rcb">
                                                                    <option value="">--</option>
                                                                    <option value="Positive">Positive</option>
                                                                    <option value="Negative">Negative</option>
                                                                    <option value="+">+</option>
                                                                    <option value="-">-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="iSerum" value="Serum Glucose (Fasting)"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="iSerum1" value=""
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="iSerum2" value="<110"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="iSerum3" value="mg/dl."
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum" value="Serum Glucose (Random)"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum1" value=""
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum2" value="<80 - 120"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum3" value="mg/dl."
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum-glucose-pp" value="Serum Glucose (PP)" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum" value="Serum Glucose (Random)"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum1" value=""
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum2" value="< 140 "
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <input type="text" name="serum3" value="mg/dl."
                                                                    class="form-control">
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
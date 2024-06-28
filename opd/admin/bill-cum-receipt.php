<?php
include ('function.php');
require ('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A5-L',
    'allow_remote_images' => true,
    'debug' => true,
]);
$rno1 = isset($_GET['rno']) ? $_GET['rno'] : '';
$billno1 = isset($_GET['billno']) ? $_GET['billno'] : '';

if (!empty($rno1) && !empty($billno1)) {
    $sql1 = "SELECT bd.pname AS pname, 
                bd.phone AS phone, 
                bd.rdocname AS rdocname,
                bd.billdate AS billdate, 
                bd.totalPrice AS totalPrice, 
                bd.totalAdj AS totalAdj, 
                bd.discount AS discount, 
                bd.billAmount AS billAmount, 
                bd.paidAmount AS paidAmount, 
                bd.balance AS balance, 
                bd.status AS status, 
                rs.rage AS rage, 
                rs.rsex AS rsex,
                rs.radd1 AS add1,
                rs.radd2 AS add2,
                rs.rcity AS city,
                rs.opid AS opid
                FROM billingDetails AS bd 
                INNER JOIN registration AS rs 
                ON bd.rno = rs.rno
                WHERE bd.rno = ? AND bd.billno = ?";

    $params1 = array($rno1, $billno1);
    $stmt1 = sqlsrv_query($conn, $sql1, $params1);

    if ($stmt1 === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    if ($row = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
        $pname = $row['pname'];
        $phone = $row['phone'];
        $billdate = $row['billdate'];
        $totalPrice = $row['totalPrice'];
        $rdocname = $row['rdocname'];
        $totalAdj = $row['totalAdj'];
        $discount = $row['discount'];
        $billAmount = $row['billAmount'];
        $paidAmount = $row['paidAmount'];
        $balance = $row['balance'];
        $status = $row['status'];
        $gender = $row['rsex'];
        $age = $row['rage'];
        $add1 = $row['add1'];
        $add2 = $row['add2'];
        $city = $row['city'];
        $opid = $row['opid'];
    } else {
        echo "No data found for the provided rno and billno.";
    }
    sqlsrv_free_stmt($stmt1);
}

$header = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>
    </title>
    <style>
        .page-break{
            page-break-after: always;
        }
        #header{
            position: fixed; 
            width: 100%; 
            top: 0; 
            left: 0; 
            right: 0;

        }
        .stl_ sup {
            vertical-align: baseline;
            position: relative;
        }

        .stl_ sub {
            vertical-align: baseline;
            position: relative;
        }

        .stl_ a:link {
            text-decoration: none;
        }

        .stl_ a:visited {
            text-decoration: none;
        }

    
        .stl_ie {
            font-size: 1pt;
        }

        .stl_ie body {
            font-size: 12em;
        }

        @media print {
            .stl_view {
                font-size: 1em;
                transform: scale(1);
            }
        }

        .stl_grlink {
            position: relative;
            width: 100%;
            height: 100%;
            z-index: 1000000;
        }

        .stl_01 {
            position: absolute;
            white-space: nowrap;
        }

        .stl_02 {
            font-size: 1em;
            line-height: 0.0em;
            border-style: none;
            display: block;
            margin: 0em;
        }

        @supports(-ms-ime-align:auto) {
            .stl_02 {
                overflow: hidden;
            }
        }

        .stl_03 {
            position: relative;
        }

        .stl_04 {
            position: absolute;
            left: 0em;
            top: 0em;
        }

        .stl_05 {
            position: relative;
            width: 51em;
        }

        .stl_06 {
            height: 6.6em;
        }

        .stl_ie .stl_06 {
            height: 66em;
        }

        @font-face {
            font-family: "BCKMED+Arial Bold";
            
        }

        .stl_07 {
            font-size: 0.838406em;
            font-family: "BCKMED+Arial Bold";
            color: #000000;
        }

        .stl_08 {
            line-height: 1.117188em;
        }

        .stl_09 {
            letter-spacing: 0.0012em;
        }

        .stl_ie .stl_09 {
            letter-spacing: 0.0155px;
        }

        @font-face {
            font-family: "GPQQJR+Arial";
        }

        .stl_10 {
            font-size: 0.838406em;
            font-family: "GPQQJR+Arial";
            color: #000000;
        }

        .stl_11 {
            letter-spacing: 0.0004em;
        }

        .stl_ie .stl_11 {
            letter-spacing: 0.0049px;
        }

        .stl_12 {
            letter-spacing: 0.0038em;
        }

        .stl_ie .stl_12 {
            letter-spacing: 0.0515px;
        }

        .stl_13 {
            letter-spacing: 0em;
        }

        .stl_ie .stl_13 {
            letter-spacing: 0px;
        }

        .stl_14 {
            letter-spacing: 0.0054em;
        }

        .stl_ie .stl_14 {
            letter-spacing: 0.0731px;
        }

        .stl_15 {
            letter-spacing: 0.0022em;
        }

        .stl_ie .stl_15 {
            letter-spacing: 0.03px;
        }

        .stl_16 {
            letter-spacing: 0.0014em;
        }

        .stl_ie .stl_16 {
            letter-spacing: 0.0184px;
        }

        .stl_17 {
            letter-spacing: 0.001em;
        }

        .stl_ie .stl_17 {
            letter-spacing: 0.0134px;
        }

        .stl_18 {
            letter-spacing: 0.0023em;
        }

        .stl_ie .stl_18 {
            letter-spacing: 0.0306px;
        }

        .stl_19 {
            letter-spacing: 0.0002em;
        }

        .stl_ie .stl_19 {
            letter-spacing: 0.0026px;
        }

        .stl_20 {
            letter-spacing: 0.0013em;
        }

        .stl_ie .stl_20 {
            letter-spacing: 0.0174px;
        }

        .stl_21 {
            letter-spacing: -0.0018em;
        }

        .stl_ie .stl_21 {
            letter-spacing: -0.0246px;
        }

        @font-face {
            font-family: "VOBGOI+Century Gothic";
        }

        .stl_22 {
            font-size: 0.838406em;
            font-family: "VOBGOI+Century Gothic";
            color: #000000;
        }

        .stl_23 {
            line-height: 1.191406em;
        }

        .stl_24 {
            letter-spacing: -0.0036em;
        }

        .stl_ie .stl_24 {
            letter-spacing: -0.0484px;
        }

        .stl_25 {
            letter-spacing: 0.0017em;
        }

        .stl_ie .stl_25 {
            letter-spacing: 0.0231px;
        }

        .stl_26 {
            letter-spacing: 0.0024em;
        }

        .stl_ie .stl_26 {
            letter-spacing: 0.0316px;
        }

        .stl_27 {
            letter-spacing: -0.0033em;
        }

        .stl_ie .stl_27 {
            letter-spacing: -0.0446px;
        }

        .stl_28 {
            letter-spacing: -0.0026em;
        }

        .stl_ie .stl_28 {
            letter-spacing: -0.0355px;
        }

        .stl_29 {
            letter-spacing: -0.0003em;
        }

        .stl_ie .stl_29 {
            letter-spacing: -0.0038px;
        }

        .stl_30 {
            letter-spacing: 0.0029em;
        }

        .stl_ie .stl_30 {
            letter-spacing: 0.0385px;
        }

        .stl_31 {
            letter-spacing: 0.003em;
        }

        .stl_ie .stl_31 {
            letter-spacing: 0.0397px;
        }

        .stl_32 {
            letter-spacing: -0.0037em;
        }

        .stl_ie .stl_32 {
            letter-spacing: -0.0499px;
        }

        .stl_33 {
            letter-spacing: 0.0006em;
        }

        .stl_ie .stl_33 {
            letter-spacing: 0.0085px;
        }

        .stl_34 {
            letter-spacing: 0.002em;
        }

        .stl_ie .stl_34 {
            letter-spacing: 0.027px;
        }

        .stl_35 {
            font-size: 0.668731em;
            font-family: "VOBGOI+Century Gothic";
            color: #000000;
        }

        .stl_36 {
            letter-spacing: 0.0063em;
        }

        .stl_ie .stl_36 {
            letter-spacing: 0.067px;
        }

        .stl_37 {
            letter-spacing: -0.0016em;
        }

        .stl_ie .stl_37 {
            letter-spacing: -0.0218px;
        }

        .stl_38 {
            letter-spacing: -0.0008em;
        }

        .stl_ie .stl_38 {
            letter-spacing: -0.0111px;
        }

        @font-face {
            font-family: "AUBQOC+Century Gothic Bold";
        }

        .stl_39 {
            font-size: 0.838406em;
            font-family: "AUBQOC+Century Gothic Bold";
            color: #000000;
        }

        .stl_40 {
            line-height: 1.212402em;
        }

        .stl_41 {
            letter-spacing: 0.0084em;
        }

        .stl_ie .stl_41 {
            letter-spacing: 0.1128px;
        }

        .stl_42 {
            letter-spacing: 0.0026em;
        }

        .stl_ie .stl_42 {
            letter-spacing: 0.0355px;
        }

        .stl_43 {
            letter-spacing: 0.0031em;
        }

        .stl_ie .stl_43 {
            letter-spacing: 0.0414px;
        }

        .stl_44 {
            letter-spacing: 0.0019em;
        }

        .stl_ie .stl_44 {
            letter-spacing: 0.0259px;
        }

        .stl_45 {
            letter-spacing: -0.0001em;
        }

        .stl_ie .stl_45 {
            letter-spacing: -0.0007px;
        }

        .stl_46 {
            letter-spacing: 0.0001em;
        }

        .stl_ie .stl_46 {
            letter-spacing: 0.0013px;
        }

        .stl_47 {
            letter-spacing: -0.002em;
        }

        .stl_ie .stl_47 {
            letter-spacing: -0.0264px;
        }

        .stl_48 {
            letter-spacing: -0.0002em;
        }

        .stl_ie .stl_48 {
            letter-spacing: -0.003px;
        }

        .stl_49 {
            letter-spacing: -0.0045em;
        }

        .stl_ie .stl_49 {
            letter-spacing: -0.0599px;
        }

        .stl_50 {
            letter-spacing: 0.0021em;
        }

        .stl_ie .stl_50 {
            letter-spacing: 0.0276px;
        }

        .stl_51 {
            letter-spacing: 0.005em;
        }

        .stl_ie .stl_51 {
            letter-spacing: 0.0674px;
        }
    </style>
</head>

<body>
    <div class="stl_ stl_02">
      
        <div class="stl_view">
            <div class="stl_05 stl_06">
                <header id="header">
                    <div class="stl_01"><span class="stl_07 stl_08 stl_09"><center>BILL CUM RECEIPT</center> &nbsp;</span></div>

                    <div class="stl_01" style="left:2.22em;top:3.871em;"><span
                            class="stl_10 stl_08 stl_11">--------------------------------------------------------------------------------------------------------------------------------------------------------
                            &nbsp;</span></div>

                    <div class="stl_01" style="left:3.33em;top:4.811em;"><span class="stl_10 stl_08 stl_12"
                            style="word-spacing:-0.0087em;">Regd No</span><span class="stl_10 stl_08 stl_13"
                            style="word-spacing:0.1703em;">&nbsp;</span><span class="stl_10 stl_08 stl_14"
                            style="word-spacing:-0.0222em;">: 237493 &nbsp;</span></div>
                    <div class="stl_01" style="left:3.33em;top:5.751em;"><span class="stl_10 stl_08 stl_15"
                            style="word-spacing:-0.0039em;">Name Of Patient : &nbsp;</span></div>
                    <div class="stl_01" style="left:21.83em;top:4.811em;"><span class="stl_10 stl_08 stl_16"
                            style="word-spacing:-0.0012em;">Bill No: '.$billdate.' /OPD &nbsp;</span></div>
                    <div class="stl_01" style="left:27.38em;top:5.751em;"><span class="stl_10 stl_08 stl_17">Age:23Y
                            &nbsp;</span></div>
                    <div class="stl_01" style="left:32.19em;top:4.811em;"><span class="stl_10 stl_08 stl_18"
                            style="word-spacing:0.6876em;">Date :</span><span class="stl_10 stl_08 stl_13"
                            style="word-spacing:-0.0093em;">&nbsp;</span><span class="stl_10 stl_08 stl_19"
                            style="word-spacing:-0.0216em;">22/03/24 07:25 AM &nbsp;</span></div>
                    <div class="stl_01" style="left:34.78em;top:5.751em;"><span class="stl_10 stl_08 stl_11"
                            style="word-spacing:0.7865em;">Gender :Male &nbsp;</span></div>
                    <div class="stl_01" style="left:10.02em;top:5.781em;"><span class="stl_07 stl_08 stl_20"
                            style="word-spacing:-0.009em;">MR. ABHI MONDAL &nbsp;</span></div>
                    <div class="stl_01" style="left:3.33em;top:6.691em;"><span class="stl_10 stl_08 stl_19"
                            style="word-spacing:0.0023em;">Address:SILIGURI SILIGURI SILIGURI &nbsp;</span></div>
                    <div class="stl_01" style="left:3.33em;top:7.631em;"><span class="stl_10 stl_08 stl_21"
                            style="word-spacing:-0.0265em;">Dr.:A.CHOWDHURY (KHORIBARI RURAL HOSPITAL) &nbsp;</span></div>
                   
                   
                   
                            <div class="stl_01" style="left:2.46em;top:8.6357em;"><span
                            class="stl_22 stl_23 stl_16">--------------------------------------------------------------------------------------------------------------------------------------------------------
                            &nbsp;</span></div>
                </header>
                <!-- <div class="page-break"></div> -->


                <div class="stl_01" style="left:3.69em;top:9.6258em;"><span class="stl_22 stl_23 stl_19"
                        style="word-spacing:4.3203em;">Sr.No. Description</span><span class="stl_22 stl_23 stl_13"
                        style="word-spacing:27.0597em;">&nbsp;</span><span class="stl_22 stl_23 stl_24"
                        style="word-spacing:1.8974em;">Qty Amount &nbsp;</span></div>
                <div class="stl_01" style="left:2.46em;top:10.6158em;"><span
                        class="stl_22 stl_23 stl_16">--------------------------------------------------------------------------------------------------------------------------------------------------------
                        &nbsp;</span></div>
                <div class="stl_01" style="left:4.7364em;top:11.6058em;"><span class="stl_22 stl_23 stl_13"
                        style="word-spacing:0.0082em;">1 .</span><span class="stl_22 stl_23 stl_13"
                        style="word-spacing:3.2273em;">&nbsp;</span><span class="stl_22 stl_23 stl_25"
                        style="word-spacing:-0.0079em;">MRI - ( L ) KNEE JOINT</span><span class="stl_22 stl_23 stl_13"
                        style="word-spacing:28.7636em;">&nbsp;</span><span class="stl_22 stl_23 stl_26">6500.00
                        &nbsp;</span>

                        
                </div>
            </div>


                <div class="stl_01" style="left:37.5364em;top:11.6058em;"><span class="stl_22 stl_23 stl_13">1</span>
                </div>
                <div class="stl_01" style="left:2.46em;top:18.5358em;"><span
                        class="stl_22 stl_23 stl_16">--------------------------------------------------------------------------------------------------------------------------------------------------------
                        &nbsp;</span></div>
                <div class="stl_01" style="left:3.69em;top:19.5258em;"><span class="stl_22 stl_23 stl_19"
                        style="word-spacing:0.0039em;">Net payable &nbsp;</span></div>
                <div class="stl_01" style="left:3.69em;top:20.5157em;"><span class="stl_22 stl_23 stl_27">Advance
                        &nbsp;</span></div>
                <div class="stl_01" style="left:9.84em;top:19.5258em;"><span class="stl_22 stl_23 stl_13">:</span></div>
                <div class="stl_01" style="left:9.84em;top:20.5157em;"><span class="stl_22 stl_23 stl_13">:</span></div>
                <div class="stl_01" style="left:12.71em;top:19.5258em;"><span class="stl_22 stl_23 stl_26">6600.00
                        &nbsp;</span></div>
                <div class="stl_01" style="left:12.71em;top:20.5157em;"><span class="stl_22 stl_23 stl_26">5000.00
                        &nbsp;</span></div>
                <div class="stl_01" style="left:30.34em;top:19.5258em;"><span class="stl_22 stl_23 stl_28"
                        style="word-spacing:0.0242em;">Total Amount</span><span class="stl_22 stl_23 stl_13"
                        style="word-spacing:0.5973em;">&nbsp;</span><span class="stl_22 stl_23 stl_28"
                        style="word-spacing:0.0242em;">: &nbsp;</span></div>
                <div class="stl_01" style="left:30.34em;top:20.5157em;"><span class="stl_22 stl_23 stl_29"
                        style="word-spacing:0.0055em;">Less Adjusted</span><span class="stl_22 stl_23 stl_13"
                        style="word-spacing:0.5937em;">&nbsp;</span><span class="stl_22 stl_23 stl_29"
                        style="word-spacing:0.0055em;">: &nbsp;</span></div>
                <div class="stl_01" style="left:36.49em;top:21.5057em;"><span class="stl_22 stl_23 stl_13">:</span>
                </div>
                <div class="stl_01" style="left:41.41em;top:19.5258em;"><span class="stl_22 stl_23 stl_26">6500.00
                        &nbsp;</span></div>
                <div class="stl_01" style="left:41.82em;top:20.5157em;"><span class="stl_22 stl_23 stl_30">500.00
                        &nbsp;</span></div>
                <div class="stl_01" style="left:41.82em;top:21.5057em;"><span class="stl_22 stl_23 stl_30">600.00
                        &nbsp;</span></div>
                <div class="stl_01" style="left:41.41em;top:22.4957em;"><span class="stl_22 stl_23 stl_26">6600.00
                        &nbsp;</span></div>
                <div class="stl_01" style="left:18.86em;top:21.5057em;"><span class="stl_22 stl_23 stl_21"
                        style="word-spacing:0.0075em;">TCS 1% 10 % &nbsp;</span></div>
                <div class="stl_01" style="left:3.69em;top:22.4957em;"><span class="stl_22 stl_23 stl_31"
                        style="word-spacing:0.5367em;">Balance/Due : &nbsp;</span></div>
                <div class="stl_01" style="left:3.69em;top:23.4858em;"><span class="stl_22 stl_23 stl_32">Mode:CASH
                        &nbsp;</span></div>
                <div class="stl_01" style="left:12.71em;top:22.4957em;"><span class="stl_22 stl_23 stl_26">1600.00
                        &nbsp;</span></div>
                <div class="stl_01" style="left:30.34em;top:22.4957em;"><span class="stl_22 stl_23 stl_33"
                        style="word-spacing:0.0217em;">Bill Amount &nbsp;</span></div>
                <div class="stl_01" style="left:36.49em;top:22.4957em;"><span class="stl_22 stl_23 stl_13">:</span>
                </div>
                <div class="stl_01" style="left:2.46em;top:24.4758em;"><span
                        class="stl_22 stl_23 stl_16">--------------------------------------------------------------------------------------------------------------------------------------------------------
                        &nbsp;</span></div>
                <div class="stl_01" style="left:3.69em;top:25.4658em;"><span class="stl_22 stl_23 stl_34"
                        style="word-spacing:-0.0091em;">Rupees:Six thousand Six hundred only &nbsp;</span></div>
                <div class="stl_01" style="left:2.46em;top:26.4558em;"><span
                        class="stl_22 stl_23 stl_16">--------------------------------------------------------------------------------------------------------------------------------------------------------
                        &nbsp;</span></div>
                <div class="stl_01" style="left:2.64em;top:27.4605em;"><span class="stl_35 stl_23 stl_34"
                        style="word-spacing:0.0034em;">All Disputes Subject to</span><span class="stl_35 stl_23 stl_13"
                        style="word-spacing:0.2985em;">&nbsp;</span><span class="stl_35 stl_23 stl_36"
                        style="word-spacing:-0.0033em;">Jurisdiction Only &nbsp;</span></div>
                <div class="stl_01" style="left:40.59em;top:27.4458em;"><span class="stl_22 stl_23 stl_37"
                        style="word-spacing:0.0096em;">E.&amp; O.E. &nbsp;</span></div>
                <div class="stl_01" style="left:36.9em;top:28.4181em;"><span class="stl_22 stl_23 stl_38"
                        style="word-spacing:0.0036em;">For </span><span class="stl_39 stl_40 stl_34"
                        style="word-spacing:-0.0057em;">Dkm infotech &nbsp;</span></div>
            </div>
        </div>
    </div>
</body>
</html>';
$mpdf->WriteHTML($header);
$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->Output();
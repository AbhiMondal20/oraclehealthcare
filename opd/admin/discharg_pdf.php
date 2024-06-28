<?php
    function generate($template_id,$api_key, $data) {
        $url = "https://rest.apitemplate.io/v2/create-pdf?template_id=" . $template_id;
        $headers = array("X-API-KEY: ".$api_key);
        $curl = curl_init();
        if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        if (!$result) {
            return null;
        }else{
            $json_result = json_decode($result, 1);
            if($json_result["status"]=="success"){
                return $json_result["download_url"];
            }else{
                return null;
            }
        }
    }

    $tempate_id = "79667b2b1876e347";
    $api_key = "9774MTgyMzA6MTUzMjQ6MzBvek1wb3RkRTkzbXF0Mg=";
    $json_payload='{ "invoice_number": "INV38379", "date": "2021-09-30", "currency": "USD", "total_amount": 82542.56 }';
    echo generate($tempate_id,$api_key,$json_payload);
?>

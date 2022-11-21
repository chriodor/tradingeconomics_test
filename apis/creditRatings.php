<?php

include_once getcwd() . "/../config/config.php";

$retArray = array();
$retArray["response"] = "ERROR";
$retArray["message"] = "Unknown error!";

$headers = array(
    "Accept: application/xml",
    "Authorization: Client $clientAuth"
);

if ($params_from_post["ratings_type"] != "") {
    $url = 'https://api.tradingeconomics.com/ratings';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    $dataArr = json_decode($output, 1);

    $retArray["data"] = array();
    $indexData = array();
    if (!empty($dataArr)) {
        foreach ($dataArr as $key => $value) {

            $ratingsType = trim($value[$params_from_post["ratings_type"]]);
            if ($ratingsType == "" || $ratingsType == "N/A") {
                $ratingsType = "Unknown";
            }

            $indexData[$ratingsType]++;
        }
    }
}

echo json_encode($indexData);

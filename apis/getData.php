<?php

include_once getcwd() . "/../config/config.php";

$retArray = array();
$retArray["response"] = "ERROR";
$retArray["message"] = "Unknown error!";
$retArray["data"] = array();

if ($params_from_post["type"] != "") {
    if ($params_from_post["country_first"] != "") {
        if ($params_from_post["country_sec"] != "") {

            $headers = array(
                "Accept: application/xml",
                "Authorization: Client $clientAuth"
            );

            $originalCountry_first = $params_from_post["country_first"];
            $originalCountry_sec = $params_from_post["country_sec"];

            $postfix = $prefix = $url = "";
            switch ($params_from_post["type"]) {
                case "GDP":
                    $url = "https://api.tradingeconomics.com/country/all/GDP";
                    $prefix = "WGDP";
                    break;
                case "COVID":
                    $url = "https://api.tradingeconomics.com/country/all/Coronavirus Cases";
                    $postfix = "COVIDCT";

                    $params_from_post["country_first"] = convertCountryName($params_from_post["country_first"]);
                    $params_from_post["country_sec"] = convertCountryName($params_from_post["country_sec"]);
                    break;

                case "EXP/IMP":
                    $url = "https://api.tradingeconomics.com/country/all/Exports";

                    $params_from_post["country_first"] = convertCountryName($params_from_post["country_first"], 1);
                    $params_from_post["country_sec"] = convertCountryName($params_from_post["country_sec"], 1);
                    break;
            }

            if ($params_from_post["country_first"] != "All") {
                $params_from_post["country_first"] = $prefix . $params_from_post["country_first"] . $postfix;
            }
            if ($params_from_post["country_sec"] != "All") {
                $params_from_post["country_sec"] = $prefix . $params_from_post["country_sec"] . $postfix;
            }

            if ($url != "") {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);

                $getData = json_decode($output, 1);

                if (!empty($getData)) {
                    foreach ($getData as $key => $value) {
                        if ($params_from_post["country_first"] == $value["HistoricalDataSymbol"] || $params_from_post["country_sec"] == $value["HistoricalDataSymbol"] || $params_from_post["country_first"] == "All" || $params_from_post["country_sec"] == "All") {
                            $retArray["data"][$value["Country"]][2] = $value["LatestValue"];

                            if ($params_from_post["type"] != "COVID" && $params_from_post["type"] != "EXP/IMP") {
                                $retArray["data"][$value["Country"]][1] = $value["PreviousValue"];
                            }
                        }
                    }
                }

                if ($params_from_post["type"] == "EXP/IMP") {
                    $urlSec = "https://api.tradingeconomics.com/country/all/Imports";

                    $chSec = curl_init($urlSec);
                    curl_setopt($chSec, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($chSec, CURLOPT_RETURNTRANSFER, true);
                    $outputSec = curl_exec($chSec);
                    curl_close($chSec);

                    $getDataSec = json_decode($outputSec, 1);

                    if (!empty($getDataSec)) {
                        foreach ($getDataSec as $key => $value) {

                            $params_from_post["country_first"] = convertCountryName($originalCountry_first, 2);
                            $params_from_post["country_sec"] = convertCountryName($originalCountry_sec, 2);

                            if ($params_from_post["country_first"] == $value["HistoricalDataSymbol"] || $params_from_post["country_sec"] == $value["HistoricalDataSymbol"] || $params_from_post["country_first"] == "All" || $params_from_post["country_sec"] == "All") {
                                $retArray["data"][$value["Country"]][1] = $value["LatestValue"];
                            }
                        }
                    }
                }

                if (!empty($retArray["data"])) {
                    $retArray["response"] = "OK";
                    $retArray["message"] = "";
                }
            } else {
                $retArray["message"] = "Unknown url!";
            }
        }
    }
}

/**
  $type = 0 simplifies to 2 characters
  $type = 1 $name to export characters
  $type = 2 $name to import characters
 */
function convertCountryName($name, $type = 0) {

    switch ($name) {
        case "MEXI":
            if ($type == 2) {
                $name = "MXTBBIMP";
            } elseif ($type == 1) {
                $name = "MXTBBEXP";
            } else {
                $name = "MX";
            }
            break;
        case "NEWZ":
            if ($type == 2) {
                $name = "NZMTIMP";
            } elseif ($type == 1) {
                $name = "NZMTEXP";
            } else {
                $name = "NZ";
            }
            break;
        case "SWED":
            if ($type == 2) {
                $name = "SWTBIM";
            } elseif ($type == 1) {
                $name = "SWTBEX";
            } else {
                $name = "SE";
            }
            break;
        case "THAI":
            if ($type == 2) {
                $name = "THNFIMP";
            } elseif ($type == 1) {
                $name = "THNFEXP";
            } else {
                $name = "TH";
            }
            break;
    }
    return $name;
}

echo json_encode($retArray);

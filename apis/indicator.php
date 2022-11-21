<?php

include_once "/var/www/subdomains/tradingEconomicsTest/config/config.php";

$headers = array(
    "Accept: application/xml",
    "Authorization: Client ef12081fb207444:pajz8rkmahfgwb7"
);
//$url = "https://api.tradingeconomics.com/indicators";
//$url = "https://api.tradingeconomics.com/country/all/GDP";
//$url = "https://api.tradingeconomics.com/country/all/Coronavirus Cases";
$url = "https://api.tradingeconomics.com/country/all/Imports";
//$url = "https://api.tradingeconomics.com/historical/country/mexico,sweden/indicator/gdp,population?c=guest:guest&f=json";
//$url = "https://api.tradingeconomics.com/country/all/Car Production";
//$url = "https://api.tradingeconomics.com/country/sweden";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

print_pr(json_decode($output, 1));

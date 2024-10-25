<?php

orderQuery();

function orderQuery(){
$endPoint = "https://api.bling.com.br/Api/v3/pedidos/vendas/21405453785";
$token = "2d3c65c4a969088c6b3c92d85daf7638dbbdf684";

$cURL = curl_init($endPoint);
$headers = array(
    'Authorization: Bearer '.$token,
    'accept: application/json'
);
curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
echo $response = curl_exec($cURL);
$data = json_decode($response, true);       
}
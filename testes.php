<?php

$idPedidoVenda = 21610047869;
$idSituacaoVenda = 6;

$jsonFile = file_get_contents('config/token_request_response.json');
$jsonData = json_decode($jsonFile, true);
$token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
echo $endPoint = "https://api.bling.com.br/Api/v3/pedidos/vendas/$idPedidoVenda/situacoes/$idSituacaoVenda";
                                         "/Api/v3/pedidos/vendas/21610047869/situacoes/9";

$cURL = curl_init($endPoint);
$headers = array(
    'Authorization: Bearer '.$token,
    'Accept: application/json'
);

curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($cURL);
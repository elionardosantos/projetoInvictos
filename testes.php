<?php
$produtoId = 17411741410;

echo verificaTipoItem($produtoId);

function verificaTipoItem($produtoId){

    $produtoId = isset($produtoId)?$produtoId:"";
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $endPoint = "https://api.bling.com.br/Api/v3/produtos?idsProdutos[]=$produtoId";
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"No";

    $cURL = curl_init($endPoint);
    $headers = array(
        'Authorization: Bearer '.$token
    );
    curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($cURL);
    $jsonData = json_decode($response, true);

    if (curl_errno($cURL)) {
        echo 'Erro ao executar cURL: ' . curl_error($cURL);
        curl_close($cURL);
        exit;
    }
    echo curl_error($cURL);
    // $tipo = $jsonData['data']['0']['tipo'];
    // return $tipo;
}
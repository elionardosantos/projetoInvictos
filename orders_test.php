<?php
function ordersQuery(){
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $endPoint = "https://api.bling.com.br/Api/v3/pedidos/vendas";
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"No";
    
    $cURL = curl_init($endPoint);
    $headers = array(
        'Authorization: Bearer '.$token
    );
    curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($cURL);
    
    $data = json_decode($response, true);
    
    if($data['error']['type'] === "invalid_token"){
        tokenRefresh();
    }

}
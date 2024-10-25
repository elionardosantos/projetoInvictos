<?php
ordersQuery();
function ordersQuery(){
    global $urlData;
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $endPoint = "https://api.bling.com.br/Api/v3/pedidos/vendas?$urlData";
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"No";
    
    $cURL = curl_init($endPoint);
    $headers = array(
        'Authorization: Bearer '.$token
    );
    curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($cURL, );
    $data = json_decode($response, true);
    
    //verify and refresh token
    if(isset($data['error']['type']) && $data['error']['type'] === "invalid_token"){
        require('controller/token_refresh.php');
        echo "<p>Token atualizado</p>";
        ordersQuery();
    } else if($data['data'] == null) {
        echo "<hr>Nenhum pedido encontrado baseado nos filtros atuais";
    } else {
        echo $response;
    }
}
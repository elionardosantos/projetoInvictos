<?php


alteraStatus($pedidoId,447794);

function alteraStatus($pedidoId,$novoStatusId){

    $url = "https://api.bling.com.br/Api/v3/pedidos/vendas/$pedidoId/situacoes/$novoStatusId";
    
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";

    $headers = [
        "Accept: application/json",
        "Authorization: Bearer $token"
    ];

    // Inicializa o cURL
    $ch = curl_init();

    // Configurações da requisição PATCH
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executa a requisição
    $response = curl_exec($ch);

    // Verifica erros
    if (curl_errno($ch)) {
        echo "Erro: " . curl_error($ch);
    } else {
        // Exibe a resposta
        echo "Resposta: " . $response;
    }

    // Fecha a conexão cURL
    curl_close($ch);

}
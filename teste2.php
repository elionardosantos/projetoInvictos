<?php

$idPedidoVenda = '21714171462';
$idSituacaoVenda = '447794';


$url = "https://api.bling.com.br/Api/v3/pedidos/vendas/$idPedidoVenda/situacoes/$idSituacaoVenda";

$headers = [
    "Accept: application/json",
    "Authorization: Bearer 49acdb6baf2d03b2993a0d0583d23294c1816767"
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
?>

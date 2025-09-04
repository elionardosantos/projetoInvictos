<?php

function consultaTeste(){
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";

    $curl = curl_init();

    // Módulo de venda: 98310
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.bling.com.br/Api/v3/situacoes/modulos/98310",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.$token,
        ),
    ));
    
    $jsonData = curl_exec($curl);

    $response = json_decode($jsonData, true);
    return $response;
    
    curl_close($curl);

    //verify and refresh token
    $tentativa = 1;
    if(isset($response['error']['type']) && $response['error']['type'] == "invalid_token"){
        echo "Teste";
        require('controller/token_refresh.php');
        echo "<script>console.log('Token atualizado')</script></p>";

        if($tentativa > 1){
            exit;
        } else {
            consultaTeste();
        }
        exit;
    } elseif(isset($response['data']['descricao'])) {
        global $descricao;
        $descricao = $response['data']['descricao'];
        return $response;
    }

    
    
}

$resultado = consultaTeste();

print_r($resultado);
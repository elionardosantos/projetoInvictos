<?php

// RETORNA O ID DOS PRODUTOS
echo consultaProdutoId([44, 45]);

function consultaProdutoId($listaProdutos){
    global $m2;
    $link = "";
    foreach($listaProdutos as $produto){
        $link .= "&codigos%5B%5D=$produto";
    }
    $url = "https://api.bling.com.br/Api/v3/produtos?$link";
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
    $header = array(
        "authorization: bearer " . $token
    );
    $cURL = curl_init($url);
    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_HTTPHEADER, $header);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($cURL);
    $responseData = json_decode($response, true);
    
    echo "<script>console.log('Consulta produtos')</script>";
    echo "<script>console.log($response)</script>";
    
}



//  pf24	Perfil Fechado Meia Cana #24				
//  GUI70	Guia 70 x 30				
//  AC300	Motor AC 300				
//  EIX11	Eixo Tubo 114,3				
//  SOLT	Soleira em T Reforçada				
//  BOR	Borracha para soleira	

<?php

$idFormaPagamento = 4872848;

consultaFormasPagamento($idFormaPagamento);

function consultaFormasPagamento($idFormaPagamento){
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.bling.com.br/Api/v3/formas-pagamentos/$idFormaPagamento",
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

    // print_r($response);
    
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
            consultaFormasPagamento();
        }
        exit;
    } elseif(isset($response['data']['descricao'])) {
        global $descricao;
        $descricao = $response['data']['descricao'];
    }
    
    $descricao = $response['data']['descricao'];
}


    

isset($descricao) ? $string = $descricao : null;

if(isset($descricao)){
    $numeroString = preg_replace('/\D/', '', $descricao);
} else {
    $numeroString = 1;
}

if($numeroString > 0 && $numeroString <= 24){
    $parcelaStr = $numeroString;
} else {
    $parcelaStr = 1;
}

$valorTotal = 3387;
$nParcelas = $parcelaStr;

$valorParcelas = ($valorTotal / $nParcelas);

if(isset($nParcelas) && $nParcelas > 0){
    $parcela = 1;
    while($parcela <= $nParcelas){

        $data = date('Y-m-d', strtotime("+$parcela month"));
        $parcelas[$parcela]['data'] = $data;
        
        if($parcela < $nParcelas){
            $parcelas[$parcela]['valor'] = ceil($valorParcelas);
        } elseif ($parcela == $nParcelas){
            $parcelaFinal = ($valorTotal - (ceil($valorParcelas) * ($nParcelas - 1)));
            $parcelas[$parcela]['valor'] = $parcelaFinal;

        }

        $parcela++;
    }
}

print_r($parcelas);
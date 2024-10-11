<?php
//Link de convite:
//https://www.bling.com.br/Api/v3/oauth/authorize?response_type=code&client_id=99d360667f87d6d6f91998f2aa89b20660830d87&state=d9780f6c01b4b61f5c304bc03c171ebe

// Com o authorization_code, o client app deve realizar uma requisição POST para o endpoint /token,
// Nisso o code será validado e os tokens de acesso serão retornados.
// Lembrando que o prazo para realizar esta requisição é de 1 minuto, este é o tempo de expiração do code.

$jsonFile = file_get_contents('json/credentials.json');
$jsonData = json_decode($jsonFile, true);


$client_id = isset($jsonData['client_id'])?$jsonData['client_id']:""; 
$client_secret = isset($jsonData['client_secret'])?$jsonData['client_secret']:"";
$authorization_url = 'https://api.bling.com.br/Api/v3/oauth/authorize';
$token_url = 'https://api.bling.com.br/v3/oauth/token';
$code = isset($_GET['code'])?$_GET['code']:"";
$state = isset($_GET['state'])?$_GET['state']:"";

$credentials64 = base64_encode("$client_id:$client_secret");


// Iniciando o cURL
$cURL = curl_init($token_url);

// Headers
$headers = array(
    "Authorization: Basic $credentials64"
);

// Dados enviados via POST
$data = array(
    'grant_type' => 'authorization_code',
    'code' => $code
);

// Configurando as opções do cURL
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURL, CURLOPT_POST, true);
curl_setopt($cURL, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

// Executando a requisição e capturando a resposta
$response = curl_exec($cURL);

// Verifica se houve erro
if(curl_errno($cURL)) {
    echo "erro no cURL: " . curl_error($cURL);
} else {
    
    // Verifica o resultado
    $responseDecoded = json_decode($response, true);
    
    if(isset($responseDecoded['access_token'])) {
        $access_token = $responseDecoded['access_token'];
        // Guarda a resposta no json
        $jsonFile = 'json/response.json';
        file_put_contents($jsonFile, $response);
        //echo "<p> $response </p>";
        echo "<center><p><h2>Acesso autorizado.</h2></p></center>";
    } else {
        echo "<p><center>$response</center></p>";
        echo "<p><center><h2>Acesso não autorizado</h2></center></p>";
        die();
    }

}

// Fechando a sessão
curl_close($cURL);

?>
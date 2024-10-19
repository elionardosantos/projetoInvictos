<?php
// POST request to the /token endpoint with authorization_code,
// If authorization_code were valid, the token code are going to be returned

$jsonFile = file_get_contents('config/credentials.json');
$jsonData = json_decode($jsonFile, true);


$client_id = isset($jsonData['client_id'])?$jsonData['client_id']:""; 
$client_secret = isset($jsonData['client_secret'])?$jsonData['client_secret']:"";
$authorization_url = 'https://api.bling.com.br/Api/v3/oauth/authorize';
$token_url = 'https://api.bling.com.br/v3/oauth/token';
$code = isset($_GET['code'])?$_GET['code']:"";
$state = isset($_GET['state'])?$_GET['state']:"";

$credentials64 = base64_encode("$client_id:$client_secret");


// Starting cURL
$cURL = curl_init($token_url);

// Headers
$headers = array(
    "Authorization: Basic $credentials64"
);

// Sending data by POST
$data = array(
    'grant_type' => 'authorization_code',
    'code' => $code
);

// Setting cURL options
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURL, CURLOPT_POST, true);
curl_setopt($cURL, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

// Executing the request
$response = curl_exec($cURL);

// Verify if there were errors
if(curl_errno($cURL)) {
    echo "erro no cURL: " . curl_error($cURL);
} else {
    
    // Verifying the result

    $responseDecoded = json_decode($response, true);
    
    if(isset($responseDecoded['access_token'])) {
        $access_token = $responseDecoded['access_token'];
        // Save the token on json
        $jsonFile = 'config/token_request_response.json';
        file_put_contents($jsonFile, $response);
        //echo "<p> $response </p>";
        // echo "<center>Acesso autorizado</center>";
    } else {
        echo "<p>Erro na conexão com o Bling</p>";
        echo "<p>$response</p>";
        die();
    }

}

// Fechando a sessão
curl_close($cURL);

?>
<?php

// Dados do contato
$contatoId = isset($_POST['contatoId'])?$_POST['contatoId']:"";
$cliente = isset($_POST['cliente'])?$_POST['cliente']:"";
$documento = isset($_POST['documento'])?$_POST['documento']:"";
$tipoPessoa = isset($_POST['tipoPessoa'])?$_POST['tipoPessoa']:"";
$endereco = isset($_POST['endereco'])?$_POST['endereco']:"";
$numero = isset($_POST['numero'])?$_POST['numero']:"";
$bairro = isset($_POST['bairro'])?$_POST['bairro']:"";
$municipio = isset($_POST['municipio'])?$_POST['municipio']:"";
$estado = isset($_POST['estado'])?$_POST['estado']:"";
$tabelaPreco = isset($_POST['tabelaPreco'])?$_POST['tabelaPreco']:"";
$condicaoPagamento = isset($_POST['condicaoPagamento'])?$_POST['condicaoPagamento']:"";

// Dados de contato
$tel = isset($_POST['tel'])?$_POST['tel']:"";
$cel = isset($_POST['cel'])?$_POST['cel']:"";
$email = isset($_POST['email'])?$_POST['email']:"";

// Dados da instalação
$quantidade = isset($_POST['quantidade'])?floatval(str_replace(",",".",str_replace(".","",$_POST['quantidade']))):"";
$largura = isset($_POST['largura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['largura']))):"";
$altura = isset($_POST['altura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['altura']))):"";
$rolo = isset($_POST['rolo'])?floatval(str_replace(",",".",str_replace(".","",$_POST['rolo']))):"";

// Local do serviço
$enderecoServico = isset($_POST['enderecoServico'])?$_POST['enderecoServico']:"";
$numeroServico = isset($_POST['numeroServico'])?$_POST['numeroServico']:"";
$bairroServico = isset($_POST['bairroServico'])?$_POST['bairroServico']:"";
$municipioServico = isset($_POST['municipioServico'])?$_POST['municipioServico']:"";
$estadoServico = isset($_POST['estadoServico'])?$_POST['estadoServico']:"";

// Dados adicionais
$observacoes = isset($_POST['observacoes'])?$_POST['observacoes']:"";
$observacoesInternas = isset($_POST['observacoesInternas'])?$_POST['observacoesInternas']:"";

// Calculando metro quadrado
$m2 = (($altura + $rolo) * $largura) * $quantidade;

// Calculando peso de acordo com o campo personalizado "consumo" dos produtos
$pesoPortaUnitario = ($m2 * 8) * 1.2;

// ###################### FUNCTIONS START ########################

// Verifica se o ID de contato existe no Bling
function consultaContatoId($contatoId){
    $url = "https://api.bling.com.br/Api/v3/contatos/$contatoId";
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
    $data = json_decode($response, true);
    
    echo "<script>console.log('Consulta contato ID')</script>";
    echo "<script>console.log($response)</script>";
    
    if(isset($data['data']['id']) && $data['data']['id'] == $contatoId){
        return true;
    }else{
        return false;
    }
}
function consultaContatoDocumento($documento){
    $url = "https://api.bling.com.br/Api/v3/contatos?numeroDocumento=$documento";
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
    $data = json_decode($response, true);
    
    echo "<script>console.log('Consulta documento:')</script>";
    echo "<script>console.log($response)</script>";
    
    if(isset($data['data']) && count($data['data']) == 1){
        return $data['data'][0]['id'];
    }else{
        return false;
    }
}

// Cria um novo contato
function criarContato(){
    global $cliente;
    global $documento;
    global $tel;
    global $cel;
    global $tipoPessoa;
    global $email;
    global $endereco;
    global $bairro;
    global $municipio;
    global $estado;
    global $numero;

    // REALIZAR AJUSTES
    // $url = "https://api.bling.com.br/Api/v3/contatos/$contatoId";
    // $jsonFile = file_get_contents('config/token_request_response.json');
    // $jsonData = json_decode($jsonFile, true);
    // $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
    // $header = array(
    //     "authorization: bearer " . $token
    // );
    // $cURL = curl_init($url);
    // curl_setopt($cURL, CURLOPT_URL, $url);
    // curl_setopt($cURL, CURLOPT_HTTPHEADER, $header);
    // curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

    // $response = curl_exec($cURL);

    $data = [
        "nome"=>$cliente,
        "numeroDocumento"=>$documento,
        "telefone"=>$tel,
        "celular"=>$cel,
        "tipo"=>$tipoPessoa,
        "email"=>$email,
        "endereco"=>[
            "geral"=>[
                "endereco"=>$endereco,
                // "cep"=>$cep,
                "bairro"=>$bairro,
                "municipio"=>$municipio,
                "uf"=>$estado,
                "numero"=>$numero,
                // "complemento"=>$complemento
            ],
        ],
    ];
};

// CRIA UM NOVO PEDIDO
function novoPedido(){
    global $contatoId;

    $url = "https://api.bling.com.br/Api/v3/pedidos/vendas";
    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";

    $header = [
        "Content-Type: application/json",
        "Accept: application/json",
        "authorization: bearer " . $token
    ];

    $postData = [
        "contato"=>[
            "id"=>$contatoId
        ],
        "itens"=>[
            [
                "produto"=>[
                    "id"=>16083585673,
                ],
                "quantidade"=>1,
            ],
        ],
        "data"=>date('Y-m-d'),
    ];

    $jsonPostData = json_encode($postData);

    $cURL = curl_init($url);
    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_HTTPHEADER, $header);
    curl_setopt($cURL, CURLOPT_POSTFIELDS, $jsonPostData);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($cURL);
    echo "<script>console.log('Resultado da criação do pedido')</script>";
    echo "<script>console.log($response)</script>";

    $responseData = json_decode($response, true);

    if(isset($responseData['error']['type']) && $responseData['error']['type'] === "VALIDATION_ERROR"){
        // echo $responseData['error']['description'];
        foreach($responseData['error']['fields'] as $field){
            echo $field['msg']."<br>";
        }

    } else if (isset($responseData['data']['id']) && $responseData['data']['id'] !== ""){
        return $pedidoId = isset($responseData['data']['id'])?$responseData['data']['id']:"";
        return true;
    } else {
        return false;
    }
}
// RETORNA O ID DOS PRODUTOS

function consultaProdutoId($listaProdutos){
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
    foreach($responseData['data'] as $produto){
        return "\"" . $produto['codigo'] . "\"" . "=>" . "\"" . $produto['id'] . "\",\n";
    }
}

// ################# FUNCTIONS END #########################


?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Orçamento</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container mt-3">
        <h2>Orçamento</h2>
    </div>
    <div class="container mt-3">
        <?php
            echo "<p>Altura: $altura / Largura: $largura / Quant: $quantidade / m²: $m2</p>";
            
            if(consultaContatoId($contatoId)){ // Verifica se o contato existe pelo ID
                if(novoPedido()){
                    echo "Pedido criado com sucesso";
                } else {
                    echo "Erro ao criar o pedido";
                }

            } else if($contatoId = consultaContatoDocumento($documento)) { // Verifica se o contato existe pelo Documento
                if(novoPedido()){
                    echo "Pedido criado com sucesso";
                    echo "ID do pedido: ". $pedidoId;
                } else {
                    echo "Erro ao criar o pedido";
                }
            } else {
                echo "Contato não existe. Criar um novo.";
                
            }
        ?>

    </div>

</body>
</html>

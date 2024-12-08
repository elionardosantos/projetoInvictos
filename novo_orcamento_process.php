<?php
require('controller/login_checker.php');
require('config/connection.php');
date_default_timezone_set('America/Sao_Paulo');
ob_start();

$modoTeste = 0; // Habilita o modo de testes

$contatoId = isset($_SESSION['contatoId'])?$_SESSION['contatoId']:"";
$cliente = isset($_SESSION['cliente'])?$_SESSION['cliente']:"";
$documentoForm = isset($_SESSION['documentoForm'])?$_SESSION['documentoForm']:"";
$documento = isset($_SESSION['documento'])?$_SESSION['documento']:"";
$tipoPessoa = isset($_SESSION['tipoPessoa'])?$_SESSION['tipoPessoa']:"";
$endereco = isset($_SESSION['endereco'])?$_SESSION['endereco']:"";
$numero = isset($_SESSION['numero'])?$_SESSION['numero']:"";
$bairro = isset($_SESSION['bairro'])?$_SESSION['bairro']:"";
$municipio = isset($_SESSION['municipio'])?$_SESSION['municipio']:"";
$estado = isset($_SESSION['estado'])?$_SESSION['estado']:"";
$tabelaPreco = isset($_SESSION['tabelaPreco'])?$_SESSION['tabelaPreco']:"";
$condicaoPagamento = isset($_SESSION['condicaoPagamento'])?$_SESSION['condicaoPagamento']:"";
$cep = isset($_SESSION['cep'])?$_SESSION['cep']:"";
$desconto = isset($_SESSION['desconto'])?$_SESSION['desconto']:"";
$tipoDesconto = isset($_SESSION['tipoDesconto'])?$_SESSION['tipoDesconto']:"";

$tel = isset($_SESSION['tel'])?$_SESSION['tel']:"";
$cel = isset($_SESSION['cel'])?$_SESSION['cel']:"";
$email = isset($_SESSION['email'])?$_SESSION['email']:"";

$observacoes = isset($_SESSION['observacoes'])?$_SESSION['observacoes']:"";
$observacoesInternasForm = isset($_SESSION['observacoesInternas'])?$_SESSION['observacoesInternas']:"";

$nomeServico = isset($_SESSION['nomeServico'])?$_SESSION['nomeServico']:"";
$enderecoServico = isset($_SESSION['enderecoServico'])?$_SESSION['enderecoServico']:"";
$numeroServico = isset($_SESSION['numeroServico'])?$_SESSION['numeroServico']:"";
$bairroServico = isset($_SESSION['bairroServico'])?$_SESSION['bairroServico']:"";
$municipioServico = isset($_SESSION['municipioServico'])?$_SESSION['municipioServico']:"";
$estadoServico = isset($_SESSION['estadoServico'])?$_SESSION['estadoServico']:"";
$cepServico = isset($_SESSION['cepServico'])?$_SESSION['cepServico']:"";

$quantidade = isset($_SESSION['quantidade'])?$_SESSION['quantidade']:"";
$larguraTotal = isset($_SESSION['larguraTotal'])?$_SESSION['larguraTotal']:"";
$alturaTotal = isset($_SESSION['alturaTotal'])?$_SESSION['alturaTotal']:"";
$rolo = isset($_SESSION['rolo'])?$_SESSION['rolo']:"";

$arrayComProdutos = isset($_SESSION['array_com_produtos'])?$_SESSION['array_com_produtos']:"";

// Calculando metro quadrado
$m2 = (($alturaTotal + $rolo) * $larguraTotal) * $quantidade;
// $observacoesInternas .= "\n"."Largura: ".$larguraTotal."m / Altura: ".$alturaTotal."m"."\n"."Usuario: ".$_SESSION['loggedUserName'];
$observacoesInternasForm == "" ? null : $observacoesArray['obs'] = $observacoesInternasForm;

$observacoesArray['largura'] = $larguraTotal;
$observacoesArray['altura'] = $alturaTotal;
$observacoesArray['quantidade'] = $quantidade;
$observacoesArray['id_usuario'] = $_SESSION['loggedUserId'];

$observacoesInternas = json_encode($observacoesArray);


// Criando array de produtos selecionados na criação do orçamento
$produtosSelecionados = isset($_POST['produtosSelecionados'])?$_POST['produtosSelecionados']:null;
// print_r($produtosSelecionados);

// Retorna ID de cada produto
$consultaProdutos = consultaProdutoId($produtosSelecionados);
// print_r($consultaProdutos);

// Consulta o preço de cada item dentro da variavel $consultaProdutos
function precoItem($codigo){
    global $consultaProdutos;
    if(isset($consultaProdutos)){
        foreach($consultaProdutos as $produto){
            if(isset($produto['codigo']) && $produto['codigo'] == $codigo){
                if(isset($_POST['tabelaPreco']) && $_POST['tabelaPreco'] == "consumidor-final"){
                    return $produto['preco'];
                }else if(isset($_POST['tabelaPreco']) && $_POST['tabelaPreco'] == "serralheiro"){
                    return $produto['preco']*0.85;
                } else {
                    return $produto['preco'];
                }
            }
        };
    }
};

// retorna o ID de cada item dentro da variavel $consultaProdutos
function idItem($codigo){
    global $consultaProdutos;
    if(isset($consultaProdutos)){
        foreach($consultaProdutos as $produto){
            if(isset($produto['codigo']) && $produto['codigo'] == $codigo){
                return $produto['id'];
            }
        };
    }
};

function listaItensPedido($produtosSelecionados){
    global $arrayComProdutos;
    global $pdo;
    $virgula = "";
    $pesoItens = "";
    $placeholders = "";
    $index = 0;
    foreach($produtosSelecionados as $item){
        $pesoItens .= $virgula.$item;
        $placeholders .= $virgula.":".$index;
        $virgula = ",";
        $index ++;
    }
    $sql = "SELECT `id`,`codigo`,`peso` FROM `produtos` WHERE `codigo` IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $index = 0;
    foreach($produtosSelecionados as $item){
        $stmt->bindValue(":$index", $item, PDO::PARAM_INT);
        $index ++;
    }
    $stmt->execute();
    
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($resultado as $item){
        $listaItens[$item['codigo']]['produto']['id'] = idItem($item['codigo']);
        $listaItens[$item['codigo']]['quantidade'] = $arrayComProdutos[$item['codigo']]['quantidade_item'];
        $listaItens[$item['codigo']]['valor'] = precoItem($item['codigo']);
        $listaItens[$item['codigo']]['peso'] = $item['peso'];
    }
    
    return $listaItens;
}    
// $listaItens = [
//     44=>[// PERFIL
//         "produto"=>[
//             "id"=>idItem(44),
//         ],    
//         "quantidade"=>$m2,
//         "valor"=>precoItem(44),
//         "peso"=>8.57,
//     ]    
// ];    

$itensPedido = listaItensPedido($produtosSelecionados);


// ###################### FUNCTIONS START ########################

// Verifica se o ID de contato existe no Bling
function consultaContatoId($contatoId){
    if(isset($contatoId) && $contatoId !== ""){
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
        
        echo "<script>console.log('Consulta contato por ID')</script>";
        echo "<script>console.log($response)</script>";
        
        if(isset($data['data']['id']) && $data['data']['id'] == $contatoId){
            return true;
        }else{
            return false;
        }

    }
}
function consultaContatoDocumento($documento){
    if(isset($documento) && $documento !== ""){
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
        
        echo "<script>console.log('Consulta contato por documento:')</script>";
        echo "<script>console.log($response)</script>";
        
        if(isset($data['data']) && count($data['data']) == 1){
            return $data['data'][0]['id'];
        }else{
            return false;
        }
    }
}

// Cria um novo contato
function novoContato(){
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
    global $cep;

    if(isset($cliente) && $cliente !== ""){
        $url = "https://api.bling.com.br/Api/v3/contatos";
        $jsonFile = file_get_contents('config/token_request_response.json');
        $jsonData = json_decode($jsonFile, true);
        $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
        $header = array(
            "authorization: bearer " . $token,
            "accept: application/json",
            "Content-Type: application/json"
        );
        $data = [
            "nome"=>$cliente,
            "numeroDocumento"=>$documento,
            "telefone"=>$tel,
            "celular"=>$cel,
            "tipo"=>$tipoPessoa,
            "email"=>$email,
            "situacao"=>"A",
            "endereco"=>[
                "geral"=>[
                    "endereco"=>$endereco,
                    "cep"=>$cep,
                    "bairro"=>$bairro,
                    "municipio"=>$municipio,
                    "uf"=>$estado,
                    "numero"=>$numero,
                    // "complemento"=>$complemento,
                ],
            ],
        ];
    
        $cURL = curl_init($url);
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, $header);
        curl_setopt($cURL, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($cURL);
        $responseData = json_decode($response, true);
    
        echo "<script>console.log('Resultado da criação do contato')</script>";
        echo "<script>console.log($response)</script>";
        
        if(isset($responseData['error']['type']) && $responseData['error']['type'] === "VALIDATION_ERROR"){
            echo $responseData['error']['message']."<br>";
            foreach($responseData['error']['fields'] as $field){
                echo $field['msg']."<br>";
            }
        }else if(isset($responseData['data']['id'])){
            return $responseData['data']['id'];
        } else {
            return false;
        }

    }
};


// CRIA UM NOVO PEDIDO
function novoPedido(){
    global $contatoId;
    global $itensPedido;
    global $observacoes;
    global $observacoesInternas;
    global $nomeServico;
    global $enderecoServico;
    global $numeroServico;
    global $bairroServico;
    global $municipioServico;
    global $estadoServico;
    global $cepServico;
    global $desconto;
    global $tipoDesconto;

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
        "itens"=>$itensPedido,
        "data"=>date('Y-m-d'),
        "observacoes"=>$observacoes,
        "observacoesInternas"=>$observacoesInternas,
        "transporte"=>[
            "etiqueta"=>[
                "nome"=>$nomeServico,
                "endereco"=>$enderecoServico,
                "numero"=>$numeroServico,
                "municipio"=>$municipioServico,
                "uf"=>$estadoServico,
                "cep"=>$cepServico,
                "bairro"=>$bairroServico,
                "complemento"=>""
            ],
        ],
        "desconto"=>[
            "valor"=>$desconto,
            "unidade"=>$tipoDesconto,
        ]
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
        echo $responseData['error']['message']."<br>";
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
    if(count($listaProdutos) > 0){
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
        
        if(isset($responseData['error']['type']) && $responseData['error']['type'] === "VALIDATION_ERROR"){
            echo "VALIDATION_ERROR";
        } else if (isset($responseData['data']) && $responseData['data'] !== ""){
            return $responseData['data'];
        } else {
            return "erro";
            return false;
        }
    }
}
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
        require('partials/navbar.php');

    ?>
    <!-- <div class="container mt-3">
        <h2>Orçamento</h2>
    </div> -->
    <div class="container mt-3">
        <?php
            if($modoTeste == 0){// Chave geral que habilita/desabilita criação de pedidos para testes. 0 para testes
                if(consultaContatoId($contatoId)){ // Verifica se o contato existe pelo ID
                    if($pedidoId = novoPedido()){
                        sleep(1);
                        alteraStatus($pedidoId,447794);
                        echo "Pedido criado com sucesso¹<br>";
                        echo "ID do pedido: ". $pedidoId;
                        sleep(1);
                        header("location: pedido_visualizacao.php?pedidoId=".$pedidoId);
                        ob_end_flush(); // Liberando as impressões na tela após o header para não impedir o redirecionamento
                        exit;
                    } else {
                        // echo "Erro ao criar o pedido";
                    }

                } elseif ($contatoId = consultaContatoDocumento($documento)) { // Verifica se o contato existe pelo Documento
                    if($pedidoId = novoPedido()){
                        sleep(1);
                        alteraStatus($pedidoId,447794);
                        echo "Pedido criado com sucesso²<br>";
                        echo "ID do pedido: ". $pedidoId;
                        sleep(1);
                        header("location: pedido_visualizacao.php?pedidoId=".$pedidoId);
                        ob_end_flush(); // Liberando as impressões na tela após o header para não impedir o redirecionamento
                        exit;
                    } else {
                        // echo "Erro ao criar o pedido";
                    }
                } elseif ($contatoId = novoContato()){ // Se o contato não existir, um novo contato é criado
                    if($pedidoId = novoPedido()){
                        sleep(1);
                        alteraStatus($pedidoId,447794);
                        echo "Pedido criado com sucesso³<br>";
                        echo "ID do pedido: ". $pedidoId;
                        sleep(1);
                        header("location: pedido_visualizacao.php?pedidoId=".$pedidoId);
                        ob_end_flush(); // Liberando as impressões na tela após o header para não impedir o redirecionamento
                        exit;
                    } else {
                        // echo "Erro ao criar o pedido";
                    }
                    
                } else {
                    echo "Houve um erro ao criar um novo contato. ";
                    echo "O orçamento não foi criado.";
                }
                
            } else {
            ?>
                ############# EM MODO DE TESTE ###############
                
        
                <h3><br>Array obs Interna</h3>
                <pre>
                <?php
                    print_r($observacoesArray);
                ?>    
                </pre>


                <h3><br>Array itensPedido</h3>
                <pre>
                <?php
                    print_r($itensPedido);
                ?>
                </pre>


                <h3><br>Consulta produtos ID</h3>
                <pre>
                <?php
                    print_r($consultaProdutos);
                ?>    
                </pre>


                <h3><br>arrayComProdutos</h3>
                <pre>
                <?php
                    print_r($arrayComProdutos);
                ?>    
                </pre>
            <?php
            }
        ?>

        


    </div>

</body>
</html>

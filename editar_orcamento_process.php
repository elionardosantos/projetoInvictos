<?php
require('controller/login_checker.php');
require('config/connection.php');
date_default_timezone_set('America/Sao_Paulo');
ob_start();

$pedidoId = $_SESSION['pedidoId'];
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

$numeroPedido = isset($_SESSION['numeroPedido'])?$_SESSION['numeroPedido']:"";

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
    if(isset($consultaProdutos) && $consultaProdutos !== ""){
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

$itensPedido = listaItensPedido($produtosSelecionados);


// ###################### FUNCTIONS START ########################

// CRIA UM NOVO PEDIDO
function editaPedido(){
    global $numeroPedido;
    global $pedidoId;
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
    global $postData;

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
        "numero"=>$numeroPedido,
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

    $curl = curl_init();

    curl_setopt_array($curl, 
        array(
            CURLOPT_URL => "https://api.bling.com.br/Api/v3/pedidos/vendas/$pedidoId",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>$jsonPostData,
            CURLOPT_HTTPHEADER =>$header,
        ),
    );
    
    $response = curl_exec($curl);
    $responseData = json_decode($response, true);
    
    curl_close($curl);
    // echo "<script>console.log('editaPedido')</script>";
    // echo "<script>console.log($response)</script>";

    if(isset($responseData['error']['type']) && $responseData['error']['type'] === "VALIDATION_ERROR"){
        echo $responseData['error']['message']."<br>";
        foreach($responseData['error']['fields'] as $field){
            echo $field['msg']."<br>";
        }

    } else if (isset($responseData['data']['id']) && $responseData['data']['id'] !== ""){
        return $pedidoId = isset($responseData['data']['id'])?$responseData['data']['id']:"";
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
        
        // echo "<script>console.log('Consulta produtos')</script>";
        // echo "<script>console.log($response)</script>";
        
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
function editaContato(){
    global $contatoId;
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

    $jsonFile = file_get_contents('config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
    $header = array(
        "authorization: bearer " . $token,
        "accept: application/json",
        "Content-Type: application/json"
    );
    $codigoContato = $_SESSION['codigoContato'];
    $data = [
        "codigo"=>$codigoContato,
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
                "numero"=>$numero
            ],
        ],
    ];


    $curl = curl_init();

    curl_setopt_array($curl,
        array(
            CURLOPT_URL => "https://api.bling.com.br/Api/v3/contatos/$contatoId",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER =>$header,
            CURLOPT_POSTFIELDS =>json_encode($data),
        )
    );

    $response = curl_exec($curl);
    curl_close($curl);
    // echo "<script>console.log('editaContato')</script>";
    // echo "<script>console.log($response)</script>";

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
            if(1){// Modo de teste: 1 - produção / 0 - ambiente de teste

                editaContato();
                sleep(1);
                editaPedido();
                sleep(1);
                header("location: pedido_visualizacao.php?pedidoId=".$pedidoId);
                
            } else {
        ?>
                ############# EM MODO DE TESTE ###############

                <pre><?php print_r($_SESSION); ?></pre>
                
                <h3><br>Array obs Interna</h3>
                <pre><?php print_r($observacoesArray); ?></pre>

                <h3><br>Array itensPedido</h3>
                <pre><?php print_r($itensPedido); ?></pre>

                <h3><br>Consulta produtos ID</h3>
                <pre><?php print_r($consultaProdutos); ?></pre>

                <h3><br>arrayComProdutos</h3>
                <pre><?php print_r($arrayComProdutos); ?></pre>
                
                
            <?php
            }
        ?>

        


    </div>

</body>
</html>

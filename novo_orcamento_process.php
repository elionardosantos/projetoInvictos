<?php
require('controller/login_checker.php');
date_default_timezone_set('America/Sao_Paulo');
ob_start();

// Dados do contato
$contatoId = isset($_POST['contatoId'])?$_POST['contatoId']:"";
$cliente = isset($_POST['cliente'])?$_POST['cliente']:"";
$documentoForm = isset($_POST['documento'])?$_POST['documento']:"";
$documento = preg_replace("/[^0-9]/", "", $documentoForm); //deixando somente números
$tipoPessoa = isset($_POST['tipoPessoa'])?$_POST['tipoPessoa']:"";
$endereco = isset($_POST['endereco'])?$_POST['endereco']:"";
$numero = isset($_POST['numero'])?$_POST['numero']:"";
$bairro = isset($_POST['bairro'])?$_POST['bairro']:"";
$municipio = isset($_POST['municipio'])?$_POST['municipio']:"";
$estado = isset($_POST['estado'])?$_POST['estado']:"";
$tabelaPreco = isset($_POST['tabelaPreco'])?$_POST['tabelaPreco']:"";
$condicaoPagamento = isset($_POST['condicaoPagamento'])?$_POST['condicaoPagamento']:"";
$cep = isset($_POST['cep'])?$_POST['cep']:"";
$desconto = isset($_POST['desconto'])?$_POST['desconto']:"";
$tipoDesconto = isset($_POST['tipoDesconto'])?$_POST['tipoDesconto']:"";

// Dados de contato
$tel = isset($_POST['tel'])?$_POST['tel']:"";
$cel = isset($_POST['cel'])?$_POST['cel']:"";
$email = isset($_POST['email'])?$_POST['email']:"";

// Dados adicionais
$observacoes = isset($_POST['observacoes'])?$_POST['observacoes']:"";
$observacoesInternas = isset($_POST['observacoesInternas'])?$_POST['observacoesInternas']:"";

// Local do serviço
$nomeServico = isset($_POST['nomeServico'])?$_POST['nomeServico']:"";
$enderecoServico = isset($_POST['enderecoServico'])?$_POST['enderecoServico']:"";
$numeroServico = isset($_POST['numeroServico'])?$_POST['numeroServico']:"";
$bairroServico = isset($_POST['bairroServico'])?$_POST['bairroServico']:"";
$municipioServico = isset($_POST['municipioServico'])?$_POST['municipioServico']:"";
$estadoServico = isset($_POST['estadoServico'])?$_POST['estadoServico']:"";
$cepServico = isset($_POST['cepServico'])?$_POST['cepServico']:"";

// Dados da instalação
$quantidade = isset($_POST['quantidade'])?floatval(str_replace(",",".",str_replace(".","",$_POST['quantidade']))):"";
$largura = isset($_POST['largura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['largura']))):"";
$altura = isset($_POST['altura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['altura']))):"";
$rolo = isset($_POST['rolo'])?floatval(str_replace(",",".",str_replace(".","",$_POST['rolo']))):"";

// Calculando metro quadrado
$m2 = (($altura + $rolo) * $largura) * $quantidade;
$observacoesInternas .= "\n Largura: ".$largura."m / Altura: ".$altura."m / m²: ".$m2;


// Itens do orçamento
// Maior que 3.8 guia 50 : guia 70
$guia = $largura<3.8?30:32;

// Criando array de referencias para a função consultaProdutoID()
$produtosSelecionados = [];
isset($_POST['item1'])?$produtosSelecionados[] = 44:"";
isset($_POST['item2'])?$produtosSelecionados[] = 36:"";
isset($_POST['item3'])?$produtosSelecionados[] = $guia:"";
isset($_POST['item4'])?$produtosSelecionados[] = 35:"";
isset($_POST['item5'])?$produtosSelecionados[] = 50:"";

// Retorna ID de cada produto
$consultaProdutos = consultaProdutoId($produtosSelecionados);

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

// Consulta o ID de cada item dentro da variavel $consultaProdutos
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
$listaItens = [
    44=>[// PERFIL
        "produto"=>[
            "id"=>idItem(44),
        ],
        "quantidade"=>$m2,
        "valor"=>precoItem(44),
        "peso"=>8.57,
    ],
    36=>[// EIXO 114,3MM
        "produto"=>[
            "id"=>idItem(36),
        ],
        "quantidade"=>$largura,
        "valor"=>precoItem(36),
        "peso"=>3,
    ],
    30=>[// PERFIL 50X30
        "produto"=>[
            "id"=>idItem(30),
        ],
        "quantidade"=>($altura+$rolo)*2,
        "valor"=>precoItem(30),
        "peso"=>8,
    ],
    32=>[// PERFIL 70X30
        "produto"=>[
            "id"=>idItem(32),
        ],
        "quantidade"=>($altura+$rolo)*2,
        "valor"=>precoItem(32),
        "peso"=>8,
    ],
    35=>[// PERFIL INVICTOS SOLEIRA DUPLA EM T
        "produto"=>[
            "id"=>idItem(35),
        ],
        "quantidade"=>$largura,
        "valor"=>precoItem(35),
        "peso"=>1,
    ],
    50=>[// BORRACHA PARA SOLEIRA INVICTOS 55 X 8 MM
        "produto"=>[
            "id"=>idItem(50),
        ],
        "quantidade"=>$largura,
        "valor"=>precoItem(50),
        "peso"=>0.1,
    ],
];

echo  "Peso da porta: ". $pesoTotal = ($m2 * $listaItens[$guia]['peso']) * 1.2;


if ($pesoTotal > 0 && $pesoTotal <= 170) {
    $resultado = "AC200";
} elseif ($pesoTotal > 170 && $pesoTotal <= 260) {
    $resultado = "AC300";
} elseif ($pesoTotal > 260 && $pesoTotal <= 300) {
    $resultado = "AC400";
} elseif ($pesoTotal > 300 && $pesoTotal <= 375) {
    $resultado = "AC500";
} elseif ($pesoTotal > 375 && $pesoTotal <= 450) {
    $resultado = "AC600";
} else {
    $resultado = "Condição não atendida";
}

echo " - motor a utilizar: ".$resultado;

isset($_POST['item1']) && $_POST['item1'] !== ""?$itensPedido[] = $listaItens[44]:"";
isset($_POST['item2']) && $_POST['item2'] !== ""?$itensPedido[] = $listaItens[36]:"";
isset($_POST['item3']) && $_POST['item3'] !== ""?$itensPedido[] = $listaItens[$guia]:"";
isset($_POST['item4']) && $_POST['item4'] !== ""?$itensPedido[] = $listaItens[35]:"";
isset($_POST['item5']) && $_POST['item5'] !== ""?$itensPedido[] = $listaItens[50]:"";


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
                // "complemento"=>"",
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
    // echo "O PEDIDO NÃO FOI CRIADO. INTEGRAÇÃO DESABILITADA PARA TESTES.";

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
            
            if(consultaContatoId($contatoId)){ // Verifica se o contato existe pelo ID
                if($pedidoId = novoPedido()){
                    echo "Pedido criado com sucesso¹<br>";
                    echo "ID do pedido: ". $pedidoId;
                    // header("location: pedido_visualizacao.php?pedidoId=".$pedidoId);
                    ob_end_flush(); // Liberando as impressões na tela após o header para não impedir o redirecionamento
                    exit;
                } else {
                    // echo "Erro ao criar o pedido";
                }

            } else if($contatoId = consultaContatoDocumento($documento)) { // Verifica se o contato existe pelo Documento
                if($pedidoId = novoPedido()){
                    echo "Pedido criado com sucesso²<br>";
                    echo "ID do pedido: ". $pedidoId;
                    // header("location: pedido_visualizacao.php?pedidoId=".$pedidoId);
                    ob_end_flush(); // Liberando as impressões na tela após o header para não impedir o redirecionamento
                    exit;
                } else {
                    // echo "Erro ao criar o pedido";
                }
            } else if($contatoId = novoContato()){ // Se o contato não existir, um novo contato é criado
                if($pedidoId = novoPedido()){
                    echo "Pedido criado com sucesso³<br>";
                    echo "ID do pedido: ". $pedidoId;
                    // header("location: pedido_visualizacao.php?pedidoId=".$pedidoId);
                    ob_end_flush(); // Liberando as impressões na tela após o header para não impedir o redirecionamento
                    exit;
                } else {
                    // echo "Erro ao criar o pedido";
                }
                
            } else {
                // echo "Houve um erro ao criar um novo contato";
                echo "O orçamento não foi criado.";
            }
        ?>

        <!-- ############# AREA DE TESTES ############### -->

        <!-- <h3><br>Array itensPedido</h3>
        <pre>
        <?php
            print_r($itensPedido);
        ?>
        </pre> -->

<!-- 
        <h1><br>Consulta produtos ID</h1>
        <pre>
        <?php
            print_r($consultaProdutos);
        ?>    
        </pre> -->


    </div>

</body>
</html>

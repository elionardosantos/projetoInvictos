<?php
require('../../controller/login_checker.php');
require('../../config/connection.php');
date_default_timezone_set('America/Sao_Paulo');
ob_start();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('../../partials/head.php'); ?>
    <title>Orçamento</title>
</head>
<body>
<?php
    require('../../partials/navbar.php');

$codigoContato = isset($_SESSION['dadosCliente']['codigoContato'])?$_SESSION['dadosCliente']['codigoContato']:"";
$contatoId = isset($_SESSION['dadosCliente']['contatoId'])?$_SESSION['dadosCliente']['contatoId']:"";
$cliente = isset($_SESSION['dadosCliente']['cliente'])?$_SESSION['dadosCliente']['cliente']:"";
$documentoForm = isset($_SESSION['dadosCliente']['documentoForm'])?$_SESSION['dadosCliente']['documentoForm']:"";
$documento = isset($_SESSION['dadosCliente']['documento'])?$_SESSION['dadosCliente']['documento']:"";
$inscricaoEstadual = isset($_SESSION['dadosCliente']['inscricaoEstadual'])?$_SESSION['dadosCliente']['inscricaoEstadual']:"";
$tipoPessoa = isset($_SESSION['dadosCliente']['tipoPessoa'])?$_SESSION['dadosCliente']['tipoPessoa']:"";
$endereco = isset($_SESSION['dadosCliente']['endereco'])?$_SESSION['dadosCliente']['endereco']:"";
$numero = isset($_SESSION['dadosCliente']['numero'])?$_SESSION['dadosCliente']['numero']:"";
$bairro = isset($_SESSION['dadosCliente']['bairro'])?$_SESSION['dadosCliente']['bairro']:"";
$municipio = isset($_SESSION['dadosCliente']['municipio'])?$_SESSION['dadosCliente']['municipio']:"";
$estado = isset($_SESSION['dadosCliente']['estado'])?$_SESSION['dadosCliente']['estado']:"";
$tabelaPreco = isset($_SESSION['dadosCliente']['tabelaPreco'])?$_SESSION['dadosCliente']['tabelaPreco']:"";
$condicaoPagamento = isset($_SESSION['dadosCliente']['condicaoPagamento'])?$_SESSION['dadosCliente']['condicaoPagamento']:"";
$cep = isset($_SESSION['dadosCliente']['cep'])?$_SESSION['dadosCliente']['cep']:"";
$tipoAcrescimo = isset($_SESSION['dadosCliente']['tipoAcrescimo'])?$_SESSION['dadosCliente']['tipoAcrescimo']:"";
$valorAcrescimo = isset($_SESSION['dadosCliente']['valorAcrescimo']) && $_SESSION['dadosCliente']['valorAcrescimo'] !== ""?$_SESSION['dadosCliente']['valorAcrescimo']:0;
$tipoDesconto = isset($_SESSION['dadosCliente']['tipoDesconto'])?$_SESSION['dadosCliente']['tipoDesconto']:"";
$valorDesconto = isset($_SESSION['dadosCliente']['valorDesconto']) && $_SESSION['dadosCliente']['valorDesconto'] !== ""?$_SESSION['dadosCliente']['valorDesconto']:0;
$indicadorIe = isset($_SESSION['dadosCliente']['indicadorIe']) ? $_SESSION['dadosCliente']['indicadorIe']:"";

$tel = isset($_SESSION['dadosCliente']['tel'])?$_SESSION['dadosCliente']['tel']:"";
$cel = isset($_SESSION['dadosCliente']['cel'])?$_SESSION['dadosCliente']['cel']:"";
$email = isset($_SESSION['dadosCliente']['email'])?$_SESSION['dadosCliente']['email']:"";

$observacoes = isset($_SESSION['dadosCliente']['observacoes'])?$_SESSION['dadosCliente']['observacoes']:"";
$observacoesInternasForm = isset($_SESSION['dadosCliente']['observacoesInternas'])?$_SESSION['dadosCliente']['observacoesInternas']:"";

$nomeServico = isset($_SESSION['dadosCliente']['nomeServico'])?$_SESSION['dadosCliente']['nomeServico']:"";
$enderecoServico = isset($_SESSION['dadosCliente']['enderecoServico'])?$_SESSION['dadosCliente']['enderecoServico']:"";
$numeroServico = isset($_SESSION['dadosCliente']['numeroServico'])?$_SESSION['dadosCliente']['numeroServico']:"";
$bairroServico = isset($_SESSION['dadosCliente']['bairroServico'])?$_SESSION['dadosCliente']['bairroServico']:"";
$municipioServico = isset($_SESSION['dadosCliente']['municipioServico'])?$_SESSION['dadosCliente']['municipioServico']:"";
$estadoServico = isset($_SESSION['dadosCliente']['estadoServico'])?$_SESSION['dadosCliente']['estadoServico']:"";
$cepServico = isset($_SESSION['dadosCliente']['cepServico'])?$_SESSION['dadosCliente']['cepServico']:"";

$quantidade = isset($_SESSION['dadosCliente']['quantidade'])?$_SESSION['dadosCliente']['quantidade']:"";
$larguraTotal = isset($_SESSION['dadosCliente']['larguraTotal'])?$_SESSION['dadosCliente']['larguraTotal']:"";
$alturaTotal = isset($_SESSION['dadosCliente']['alturaTotal'])?$_SESSION['dadosCliente']['alturaTotal']:"";
$pesoTotalPorta = isset($_SESSION['dadosCliente']['pesoTotalPorta'])?$_SESSION['dadosCliente']['pesoTotalPorta']:"";
$rolo = isset($_SESSION['dadosCliente']['rolo'])?$_SESSION['dadosCliente']['rolo']:"";

$arrayComProdutos1 = isset($_SESSION['array_com_produtos'])?$_SESSION['array_com_produtos']:null;
$arrayComProdutos2 = isset($_SESSION['array_com_produtos_por_peso'])?$_SESSION['array_com_produtos_por_peso']:null;

if(isset($arrayComProdutos2) && $arrayComProdutos2 !== "" && count($arrayComProdutos2) > 0){
    $arrayComProdutos = array_merge($arrayComProdutos1, $arrayComProdutos2);
} else {
    $arrayComProdutos = $arrayComProdutos1;
}

// Calculando metro quadrado
if(isset($m2)){
    $m2 = (($alturaTotal + $rolo) * $larguraTotal) * $quantidade;
}

// $observacoesInternas .= "\n"."Largura: ".$larguraTotal."m / Altura: ".$alturaTotal."m"."\n"."Usuario: ".$_SESSION['loggedUserName'];
$observacoesInternasForm == "" ? null : $observacoesArray['obs'] = $observacoesInternasForm;

$observacoesArray['quantidade'] = $quantidade;
$observacoesArray['largura'] = $larguraTotal;
$observacoesArray['altura'] = $alturaTotal;
$observacoesArray['peso'] = $pesoTotalPorta;
$observacoesArray['id_usuario'] = $_SESSION['login']['loggedUserId'];

$observacoesInternas = json_encode($observacoesArray);

$produtosSelecionados2 = [];
foreach($_POST as $produto => $value){
    // echo " - $value. <br>";
    $produtosSelecionados2[] = $value;
}

// Criando array de produtos selecionados para a função de criação do orçamento
$produtosSelecionados1 = isset($_SESSION['produtosSelecionados'])?$_SESSION['produtosSelecionados']:null;

$produtosSelecionados = array_merge($produtosSelecionados1, $produtosSelecionados2);

if(isset($produtosSelecionados) && count($produtosSelecionados) > 0){

} else {
    echo "<div class=\"container\">Nenhuma ação foi executada<div>";
    exit;
}


$itensParaConsulta = $produtosSelecionados;

// Retorna ID de cada produto
$consultaProdutos = consultaProdutoId($itensParaConsulta);

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
    if(isset($produtosSelecionados)){
        global $arrayComProdutos;
        global $pdo;
        $virgula = "";
        $codigoItens = "";
        $placeholders = "";
        $index = 0;
        foreach($produtosSelecionados as $item){
            $codigoItens .= $virgula.$item;
            $placeholders .= $virgula.":".$index;
            $virgula = ",";
            $index ++;
        }
        $sql = "SELECT `id`,`codigo`,`peso`,`categoria` FROM `produtos` WHERE `codigo` IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $index = 0;
        foreach($produtosSelecionados as $item){
            $stmt->bindValue(":$index", $item, PDO::PARAM_INT);
            $index ++;
        }
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($resultado as $item){
            foreach($arrayComProdutos as $prods){
                if($item['codigo'] == $prods['codigo']){
                    $prodQuant = $prods['quantidade_item'];
                    $prodPeso = $prods['peso_item'];
                    break;
                }
            }

            
            $listaItens[$item['codigo']]['codigo'] = $item['codigo'];
            $listaItens[$item['codigo']]['quantidade'] = $prodQuant;
            $listaItens[$item['codigo']]['peso'] = $prodPeso;
            $listaItens[$item['codigo']]['produto']['id'] = idItem($item['codigo']);
            $listaItens[$item['codigo']]['valor'] = precoItem($item['codigo']);
            $listaItens[$item['codigo']]['categId'] = $item['categoria'];
            $listaItens[$item['codigo']]['indice'] = "";

        }
        
        return $listaItens;

    } else {
        echo "A lista de itens para o pedido está vazia";
    }
}    

$itensPedido = listaItensPedido($produtosSelecionados);

function categsListing() {
    require('../../config/connection.php');

    $sql = "SELECT `id`,`name`,`indice`,`ativo` FROM `categorias_produtos` WHERE `deleted` = :deleted AND `ativo` = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':deleted', 0);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
};
$dadosCategorias = categsListing();
        
foreach($itensPedido as $itemPedido=>$atributo){
 
    if(isset($atributo['categId'])){
        // echo $itemPedido." - ";
        foreach($dadosCategorias as $categoria){
            if($atributo['categId'] == $categoria['id']){
                $itensPedido[$itemPedido]['indice'] = $categoria['indice'];
                // echo "Cat: ".$atributo['categId']. "/ Ind: ".$categoria['indice']."<br>";
                // echo $itemAtual;       
                break;     
            } else {
                $itensPedido[$itemPedido]['indice'] = 9999;
            }
        }
    } else {
        $itensPedido[$itemPedido]['indice'] = 9999;
    }
}

usort($itensPedido, function($a, $b) {
    return $a['indice'] <=> $b['indice']; // Ordenação crescente pelo ID
});


$valorTotalItensPedido = 0; 
foreach($itensPedido as $item=>$valor){
    // echo " + ".$valor['valor'] * $valor['quantidade'];
    $valorTotalItensPedido += ($valor['valor'] * $valor['quantidade']);
}

if($tipoAcrescimo == "REAL"){
    $acrescimo = $valorAcrescimo;
    // $valorTotalPedido = round($valorTotalItensPedido + $acrescimo, 2);
}elseif($tipoAcrescimo == "PERCENTUAL"){
    $acrescimo = ($valorTotalItensPedido * $valorAcrescimo) / 100;
    // $valorTotalPedido = round($valorTotalItensPedido + $acrescimo, 2);
}else{
    $acrescimo = 0;
}

if($tipoDesconto == "REAL"){
    $desconto = $valorDesconto;
    // $valorTotalPedido = round($valorTotalItensPedido - $desconto + $acrescimo, 2);
}elseif($tipoDesconto == "PERCENTUAL"){
    $desconto = $valorTotalItensPedido * ($valorDesconto / 100);
    // $valorTotalPedido = round((($valorTotalItensPedido - $desconto) + $acrescimo), 2);
}else{
    $desconto = 0;
}

$valorTotalPedido = $valorTotalItensPedido + $acrescimo - $desconto;



// echo " = ".$valorTotalItensPedido;


// ###################### FUNCTIONS START ########################

// Verifica se o ID de contato existe no Bling
function consultaContatoId($contatoId){
    if(isset($contatoId) && $contatoId !== ""){
        $url = "https://api.bling.com.br/Api/v3/contatos/$contatoId";
        $jsonFile = file_get_contents('../../config/token_request_response.json');
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
        $jsonFile = file_get_contents('../../config/token_request_response.json');
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
    global $valorDesconto;
    global $tipoDesconto;
    global $valorTotalPedido;
    global $condicaoPagamento;
    global $acrescimo;

    
    
    $url = "https://api.bling.com.br/Api/v3/pedidos/vendas";

    $jsonFile = file_get_contents('../../config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";

    $header = [
        "Content-Type: application/json",
        "Accept: application/json",
        "authorization: bearer " . $token
    ];

    // GERANDO AS PARCELAS DO PEDIDO
    $valorTotal = $valorTotalPedido;
    $nParcelas = $_SESSION['dadosCliente']['nParcelas'];


    if(isset($nParcelas) && $nParcelas > 0){
        $valorParcelas = ($valorTotal / $nParcelas);
        $parcela = 1;
        while($parcela <= $nParcelas){

            $data = date('Y-m-d', strtotime("+$parcela month"));
            $parcelas[$parcela]['dataVencimento'] = $data;
            $parcelas[$parcela]['formaPagamento']['id'] = $condicaoPagamento;
            
            if($parcela < $nParcelas){
                $parcelas[$parcela]['valor'] = ceil($valorParcelas);
            } elseif ($parcela == $nParcelas){
                $parcelaFinal = ($valorTotal - (ceil($valorParcelas) * ($nParcelas - 1)));
                $parcelas[$parcela]['valor'] = $parcelaFinal;

            }

            $parcela++;
        }
    }elseif(isset($nParcelas) && $nParcelas == 0){
        $data = date('Y-m-d');
        $parcelas[0]['dataVencimento'] = $data;
        $parcelas[0]['valor'] = $valorTotalPedido;
        $parcelas[0]['formaPagamento']['id'] = $condicaoPagamento;
    }


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
        "outrasDespesas"=>$acrescimo,
        "parcelas"=>$parcelas,
        "desconto"=>[
            "valor"=>$valorDesconto,
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

function editaPedido(){
    global $codigoContato;
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
    global $valorDesconto;
    global $tipoDesconto;
    global $valorTotalPedido;
    global $condicaoPagamento;
    global $acrescimo;
    
    $idPedidoAtual = $_SESSION['pedidoId'];

    $jsonFile = file_get_contents('../../config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";

    $header = [
        "Content-Type: application/json",
        "Accept: application/json",
        "authorization: bearer " . $token
    ];

    // GERANDO AS PARCELAS DO PEDIDO
    $valorTotal = $valorTotalPedido;
    $nParcelas = $_SESSION['dadosCliente']['nParcelas'];


    if(isset($nParcelas) && $nParcelas > 0){
        $valorParcelas = ($valorTotal / $nParcelas);
        $parcela = 1;
        while($parcela <= $nParcelas){

            $data = date('Y-m-d', strtotime("+$parcela month"));
            $parcelas[$parcela]['dataVencimento'] = $data;
            $parcelas[$parcela]['formaPagamento']['id'] = $condicaoPagamento;
            
            if($parcela < $nParcelas){
                $parcelas[$parcela]['valor'] = ceil($valorParcelas);
            } elseif ($parcela == $nParcelas){
                $parcelaFinal = ($valorTotal - (ceil($valorParcelas) * ($nParcelas - 1)));
                $parcelas[$parcela]['valor'] = $parcelaFinal;

            }

            $parcela++;
        }
    }elseif(isset($nParcelas) && $nParcelas == 0){
        $data = date('Y-m-d');
        $parcelas[0]['dataVencimento'] = $data;
        $parcelas[0]['valor'] = $valorTotalPedido;
        $parcelas[0]['formaPagamento']['id'] = $condicaoPagamento;
    }


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
        "outrasDespesas"=>$acrescimo,
        "parcelas"=>$parcelas,
        "desconto"=>[
            "valor"=>$valorDesconto,
            "unidade"=>$tipoDesconto,
        ]
    ];


    $jsonPostData = json_encode($postData);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.bling.com.br/Api/v3/pedidos/vendas/'.$idPedidoAtual,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $jsonPostData,
        CURLOPT_HTTPHEADER => $header,
    ));


    $response = curl_exec($curl);
    curl_close($curl);

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
    // echo "listaProdutos: "; print_r($listaProdutos);
    $link = "";
    if(isset($listaProdutos) && count($listaProdutos) > 0){
        foreach($listaProdutos as $produto){
            $link .= "&codigos%5B%5D=$produto";
        }
        $url = "https://api.bling.com.br/Api/v3/produtos?$link";
        $jsonFile = file_get_contents('../../config/token_request_response.json');
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
    } else {
        echo "Consulta de produtos por ID não realizada";
    }
}
function alteraStatus($pedidoId,$novoStatusId){

    $url = "https://api.bling.com.br/Api/v3/pedidos/vendas/$pedidoId/situacoes/$novoStatusId";
    
    $jsonFile = file_get_contents('../../config/token_request_response.json');
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
    global $inscricaoEstadual;
    global $indicadorIe;

    $jsonFile = file_get_contents('../../config/token_request_response.json');
    $jsonData = json_decode($jsonFile, true);
    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
    $header = array(
        "authorization: bearer " . $token,
        "accept: application/json",
        "Content-Type: application/json"
    );
    $codigoContato = isset($_SESSION['dadosCliente']['codigoContato'])?$_SESSION['dadosCliente']['codigoContato']:"";
    $data = [
        "codigo"=>$codigoContato,
        "nome"=>$cliente,
        "numeroDocumento"=>$documento,
        "telefone"=>$tel,
        "celular"=>$cel,
        "tipo"=>$tipoPessoa,
        "email"=>$email,
        "situacao"=>"A",
        "ie"=>$inscricaoEstadual,
        "indicadorIe"=>$indicadorIe,
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
function limpaSession(){
    $_SESSION['dadosCliente'] = "";
    $_SESSION['array_com_produtos'] = "";
    $_SESSION['produtosSelecionados'] = "";
    $_SESSION['array_com_produtos_por_peso'] = "";
    $_SESSION['dadosCliente'] = "";
}


// ################# FUNCTIONS END #########################


?>






    <!-- <div class="container mt-3">
        <h2>Orçamento</h2>
    </div> -->
    <div class="container mt-3">
        <?php
            
            if(1){// Chave para o modo de testes. 0 para testes 1 para produção

                editaContato();
                if($pedidoId = editaPedido()){
                    sleep(1);
                    limpaSession();
                    header("location: visualizacao.php?pedidoId=".$pedidoId);
                }else{
                    echo "<div class=\"alert alert-danger\">Houve um erro durante o processamento. Favor verificar se o pedido foi editado.</div>";
                };
                
                
                
            } else {
            ?>
                ############# EM MODO DE TESTE ###############
                
        
                <h3><br>produtosSelecionados</h3>
                <pre>
                <?php
                    print_r($produtosSelecionados);
                ?>    
                </pre>

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


                <h3><br>$_POST</h3>
                <pre>
                <?php
                    print_r($_POST);
                ?>    
                </pre>
            <?php
            }
        ?>

        


    </div>

</body>
</html>

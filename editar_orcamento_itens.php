<?php
require('controller/login_checker.php');
date_default_timezone_set('America/Sao_Paulo');

// Dados do contato
$contatoId = isset($_POST['contatoId'])?$_POST['contatoId']:(isset($_SESSION['dadosCliente']['contatoId'])?$_SESSION['dadosCliente']['contatoId']:null);
$cliente = isset($_POST['cliente'])?$_POST['cliente']:(isset($_SESSION['dadosCliente']['cliente'])?$_SESSION['dadosCliente']['cliente']:null);
$documentoForm = isset($_POST['documento'])?$_POST['documento']:(isset($_SESSION['dadosCliente']['documentoForm'])?$_SESSION['dadosCliente']['documentoForm']:null);
$documento = preg_replace("/[^0-9]/", "", $documentoForm); //deixo somente números)
$inscricaoEstadual = isset($_POST['inscricaoEstadual'])?$_POST['inscricaoEstadual']:(isset($_SESSION['dadosCliente']['inscricaoEstadual'])?$_SESSION['dadosCliente']['inscricaoEstadual']:null);
$tipoPessoa = isset($_POST['tipoPessoa'])?$_POST['tipoPessoa']:(isset($_SESSION['dadosCliente']['tipoPessoa'])?$_SESSION['dadosCliente']['tipoPessoa']:null);
$endereco = isset($_POST['endereco'])?$_POST['endereco']:(isset($_SESSION['dadosCliente']['endereco'])?$_SESSION['dadosCliente']['endereco']:null);
$numero = isset($_POST['numero'])?$_POST['numero']:(isset($_SESSION['dadosCliente']['numero'])?$_SESSION['dadosCliente']['numero']:null);
$bairro = isset($_POST['bairro'])?$_POST['bairro']:(isset($_SESSION['dadosCliente']['bairro'])?$_SESSION['dadosCliente']['bairro']:null);
$municipio = isset($_POST['municipio'])?$_POST['municipio']:(isset($_SESSION['dadosCliente']['municipio'])?$_SESSION['dadosCliente']['municipio']:null);
$estado = isset($_POST['estado'])?$_POST['estado']:(isset($_SESSION['dadosCliente']['estado'])?$_SESSION['dadosCliente']['estado']:null);
$tabelaPreco = isset($_POST['tabelaPreco'])?$_POST['tabelaPreco']:(isset($_SESSION['dadosCliente']['tabelaPreco'])?$_SESSION['dadosCliente']['tabelaPreco']:null);
$condicaoPagamento = isset($_POST['condicaoPagamento'])?$_POST['condicaoPagamento']:(isset($_SESSION['dadosCliente']['condicaoPagamento'])?$_SESSION['dadosCliente']['condicaoPagamento']:null);
$cep = isset($_POST['cep'])?$_POST['cep']:(isset($_SESSION['dadosCliente']['cep'])?$_SESSION['dadosCliente']['cep']:null);
$tipoAcrescimo = isset($_POST['tipoAcrescimo'])?$_POST['tipoAcrescimo']:(isset($_SESSION['dadosCliente']['tipoAcrescimo'])?$_SESSION['dadosCliente']['tipoAcrescimo']:null);
$valorAcrescimo = isset($_POST['valorAcrescimo'])?$_POST['valorAcrescimo']:(isset($_SESSION['dadosCliente']['valorAcrescimo'])?$_SESSION['dadosCliente']['valorAcrescimo']:null);
$tipoDesconto = isset($_POST['tipoDesconto'])?$_POST['tipoDesconto']:(isset($_SESSION['dadosCliente']['tipoDesconto'])?$_SESSION['dadosCliente']['tipoDesconto']:null);
$valorDesconto = isset($_POST['valorDesconto'])?$_POST['valorDesconto']:(isset($_SESSION['dadosCliente']['valorDesconto'])?$_SESSION['dadosCliente']['valorDesconto']:null);

// Auto preencher o campo contribuinte no Bling
$indicadorIe = isset($inscricaoEstadual) && $inscricaoEstadual !== "" ? 1 : 0;

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
$quantidade = isset($_POST['quantidade'])?floatval(str_replace(",",".",$_POST['quantidade'])):$_SESSION['dadosCliente']['quantidade'];
$larguraTotal = isset($_POST['largura'])?floatval(str_replace(",",".",$_POST['largura'])):$_SESSION['dadosCliente']['larguraTotal'];
$alturaTotal = isset($_POST['altura'])?floatval(str_replace(",",".",$_POST['altura'])):$_SESSION['dadosCliente']['alturaTotal'];
$rolo = isset($_POST['rolo'])?floatval(str_replace(",",".",$_POST['rolo'])):$_SESSION['dadosCliente']['rolo'];

if($alturaTotal !== "" && $larguraTotal !== ""){
    $m2 = ($alturaTotal + $rolo) * $larguraTotal;
    $_SESSION['dadosCliente']['m2'] = $m2;
} else {
    isset($_SESSION['dadosCliente']['m2'])?$m2 = $_SESSION['dadosCliente']['m2']:"";
}

isset($contatoId)?$_SESSION['dadosCliente']['contatoId'] = $contatoId:null;
isset($cliente)?$_SESSION['dadosCliente']['cliente'] = $cliente:null;
isset($documentoForm)?$_SESSION['dadosCliente']['documentoForm'] = $documentoForm:null;
isset($documento)?$_SESSION['dadosCliente']['documento'] = $documento:null;
isset($inscricaoEstadual)?$_SESSION['dadosCliente']['inscricaoEstadual'] = $inscricaoEstadual:null;
isset($tipoPessoa)?$_SESSION['dadosCliente']['tipoPessoa'] = $tipoPessoa:null;
isset($endereco)?$_SESSION['dadosCliente']['endereco'] = $endereco:null;
isset($numero)?$_SESSION['dadosCliente']['numero'] = $numero:null;
isset($bairro)?$_SESSION['dadosCliente']['bairro'] = $bairro:null;
isset($municipio)?$_SESSION['dadosCliente']['municipio'] = $municipio:null;
isset($estado)?$_SESSION['dadosCliente']['estado'] = $estado:null;
isset($tabelaPreco)?$_SESSION['dadosCliente']['tabelaPreco'] = $tabelaPreco:null;
isset($condicaoPagamento)?$_SESSION['dadosCliente']['condicaoPagamento'] = $condicaoPagamento:null;
isset($cep)?$_SESSION['dadosCliente']['cep'] = $cep:null;
isset($tipoAcrescimo)?$_SESSION['dadosCliente']['tipoAcrescimo'] = $tipoAcrescimo:null;
isset($valorAcrescimo)?$_SESSION['dadosCliente']['valorAcrescimo'] = $valorAcrescimo:null;
isset($tipoDesconto)?$_SESSION['dadosCliente']['tipoDesconto'] = $tipoDesconto:null;
isset($valorDesconto)?$_SESSION['dadosCliente']['valorDesconto'] = $valorDesconto:null;
isset($indicadorIe)?$_SESSION['dadosCliente']['indicadorIe'] = $indicadorIe:null;

$_SESSION['dadosCliente']['tel'] = $tel;
$_SESSION['dadosCliente']['cel'] = $cel;
$_SESSION['dadosCliente']['email'] = $email;

$_SESSION['dadosCliente']['observacoes'] = $observacoes;
$_SESSION['dadosCliente']['observacoesInternas'] = $observacoesInternas;

$_SESSION['dadosCliente']['nomeServico'] = $nomeServico;
$_SESSION['dadosCliente']['enderecoServico'] = $enderecoServico;
$_SESSION['dadosCliente']['numeroServico'] = $numeroServico;
$_SESSION['dadosCliente']['bairroServico'] = $bairroServico;
$_SESSION['dadosCliente']['municipioServico'] = $municipioServico;
$_SESSION['dadosCliente']['estadoServico'] = $estadoServico;
$_SESSION['dadosCliente']['cepServico'] = $cepServico;

$_SESSION['dadosCliente']['quantidade'] = $quantidade;
$_SESSION['dadosCliente']['larguraTotal'] = $larguraTotal;
$_SESSION['dadosCliente']['alturaTotal'] = $alturaTotal;
$_SESSION['dadosCliente']['rolo'] = $rolo;

// CONSULTANDO A QUANTIDADE DE PARCELAS DA FORMA DE PAGAMENTO NO BLING E GUARDANDO EM SESSION['dadosCliente']['nParcelas']
$idFormaPagamento = $_SESSION['dadosCliente']['condicaoPagamento'];

consultaFormasPagamento();

function consultaFormasPagamento(){
    global $idFormaPagamento;

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
    if(isset($response['error']['type']) && $response['error']['type'] == "invalid_token"){
        require('controller/token_refresh.php');
        echo "<script>console.log('Token atualizado')</script></p>\n";

        isset($tentativa)?null:$tentativa = 1;

        if($tentativa >= 1 && $tentativa <= 2){
            consultaFormasPagamento();
        }

        $tentativa++;

    } elseif (isset($response['data']['descricao'])) {
        global $descricao;
        $descricao = $response['data']['descricao'];
    }
}


    

isset($descricao) ? $string = $descricao : null;

if(isset($descricao)){
    $numeroString = preg_replace('/\D/', '', $descricao);
} else {
    $numeroString = 0;
}

if($numeroString >= 0 && $numeroString <= 24){
    $nParcelas = $numeroString;
} else {
    $nParcelas = 0;
}

$_SESSION['dadosCliente']['nParcelas'] = $nParcelas;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Itens Basicos</title>
</head>
<body>
<?php
require('partials/navbar.php');



// Buscando produtos de acordo com os parametros de largura e altura
if($alturaTotal !== "" && $larguraTotal !== ""){
    if($alturaTotal !== 0 && $larguraTotal !== 0){
        require('config/connection.php');
        $sql = "SELECT `id`,`codigo`,`titulo`,`peso`,`tipo_consumo`,`multiplicador`,`selecionado`,`categoria`,`tipo_produto`,`basico` FROM produtos
                WHERE deleted = 0
                AND ativo = 1
                AND tipo_produto IS NOT NULL 
                AND altura_minima_porta <= $alturaTotal
                AND altura_maxima_porta >= $alturaTotal
                AND largura_minima_porta <= $larguraTotal
                AND largura_maxima_porta >= $larguraTotal
                ;";
                // AND peso_minimo <= $peso
                // AND peso_maximo > $peso
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "<h3>Consulta 1</h3>";
        // echo "<pre>".print_r($resultado)."</pre>";
    }else if($alturaTotal == 0 && $larguraTotal == 0){
        echo "------------------ Manutenção";
    } else {
        echo "Dimensões inválidas";
    }
    
} else {
    $resultado = $_SESSION['array_com_produtos'];
}

// Exibir nome do cliente na tela de seleção de itens
if(isset($cliente)){
?>
    <div class="container mt-4">
        <div class="row align-items-center">
            <div class="col-8">
                <div class="row">
                    <div class="col">Cliente: <strong><?= $cliente ?></strong></div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<div class="container mt-4">
    <?php
        echo "Medida: ";
        echo $alturaTotal !== ""? $larguraTotal :"";
        echo "x";
        echo $alturaTotal !== ""? $alturaTotal:"";
        echo "m";
    ?>
</div>

<div class="container my-3">
    <h4>ITENS BÁSICOS</h4>
</div>

<div class="container mt-4">
    <?php
        if(isset($_SESSION['array_com_produtos']) && count($_SESSION['array_com_produtos']) > 0){
            $arrayComProdutos = $_SESSION['array_com_produtos'];
        } else {
            if(isset($resultado) && count($resultado) > 0){
                
                $pesoTotalPorta = 0;
    
                // Adicionando itens à array de produtos para enviar à página de processamento do orçamento (envio para o Bling)
                foreach($resultado as $row){
                    $id = isset($row['id'])?$row['id']:"";
                    $codigo = isset($row['codigo'])?$row['codigo']:"erro";
                    $titulo = isset($row['titulo'])?$row['titulo']:"";
                    $peso = isset($row['peso'])?floatVal(str_replace(",",".",$row['peso'])):null;
                    $tipoConsumo = isset($row['tipo_consumo'])?$row['tipo_consumo']:null;
                    $multiplicador = isset($row['multiplicador'])?$row['multiplicador']:null;
                    $selecionado = isset($row['selecionado'])?$row['selecionado']:null;
                    $categId = isset($row['categoria'])?$row['categoria']:null;
                    $tipoProduto = isset($row['tipo_produto'])?$row['tipo_produto']:null;
                    $basico = isset($row['basico'])?$row['basico']:null;
    
                    $pesoItem = null;
                    switch ($tipoConsumo) {
                        case 'm2':
                            $quantidadeItem = ($m2 * $multiplicador) * $quantidade;
                            break;
    
                        case 'largura':
                            $quantidadeItem = ($larguraTotal * $multiplicador) * $quantidade;
                            break;
                            
                        case 'altura':
                            $quantidadeItem = ($alturaTotal * $multiplicador) * $quantidade;
                            break;
    
                        case 'unidade':
                            $quantidadeItem = (1 * $multiplicador) * $quantidade;
                            break;
                    }
    
                    $pesoItem = ($peso * $quantidadeItem) / $quantidade;
                    $pesoTotalPorta += $pesoItem;
    
                    $produtoParaArray['id'] = $id;
                    $produtoParaArray['selecionado'] = $selecionado;
                    $produtoParaArray['codigo'] = $codigo;
                    $produtoParaArray['titulo'] = $titulo;
                    $produtoParaArray['quantidade_item'] = $quantidadeItem;
                    $produtoParaArray['peso_item'] = $pesoItem;
                    $produtoParaArray['tipo_consumo'] = $tipoConsumo;
                    $produtoParaArray['multiplicador'] = $multiplicador;
                    $produtoParaArray['categId'] = $categId;
                    $produtoParaArray['tipo_produto'] = $tipoProduto;
                    $produtoParaArray['basico'] = $basico;
                    
                    $arrayComProdutos[$codigo] = $produtoParaArray;
                }
                $pesoTotalPorta = $pesoTotalPorta / $quantidade;
                $_SESSION['dadosCliente']['pesoTotalPorta'] = $pesoTotalPorta;
                // echo " / Peso total porta: $pesoTotalPorta KG<br><br>";
                
            } else {
                // nada aqui...
            }

        }

    ?>    
</div>

<div class="container">
    <?php
    $categorias = [];
    if(isset($arrayComProdutos) && count($arrayComProdutos) > 0){
        foreach($arrayComProdutos as $produto){
            $codigo = isset($produto['codigo']) ? $produto['codigo'] : "";
            $categoria = isset($produto['categId']) ? $produto['categId'] : "";
            $tipoProd = isset($produto['tipo_produto']) ? $produto['tipo_produto'] : "";
            
            if(isset($categoria) && $categoria !== ''){
                $categorias[] = $categoria;
            }
            
            $categorias = array_unique($categorias);
        }

    } else {
        echo "Nenhum produto encontrado";
    }

    function consultaCategorias(){ // Consultando categorias no BD para reorganizar as categorias
        require('config/connection.php');
        $sql = "SELECT `id`,`name`,`indice` FROM categorias_produtos
            WHERE deleted = 0
            AND ativo = 1;
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    }

    $categsBD = consultaCategorias();

    $categsArrayProdutos = [];
    $i = 0;

    foreach($categorias as $categ){
        foreach($categsBD as $categBD){
            if($categ == $categBD['id']){
                $categsArrayProdutos[$i]['id'] = $categ;
                $categsArrayProdutos[$i]['indice'] = $categBD['indice'];
                $categsArrayProdutos[$i]['name'] = $categBD['name'];
            }
        }
        $i++;
    }

    usort($categsArrayProdutos, function($a, $b) {
        return $a['indice'] <=> $b['indice']; // Ordenação crescente pelo Código
    });
    ?>
    <form method="POST" action="editar_orcamento_opcionais.php">
        <?php
            foreach($categsArrayProdutos as $ctg){
                ?>
                <div class="mt-3">
                    <b> - <?= $ctg['name'] ?>: </b>
                </div>
                <div class="">
                    <select class="form-select" name="<?= $ctg['name']?>">
                        <option value=""></option>

                        <?php //Buscar somente itens da $ctg['id']
                            foreach($arrayComProdutos as $prod){
                                if(isset($prod['categId']) && $prod['categId'] == $ctg['id']){
                                    $id = $prod['categId'];
                                    $codigo = $prod['codigo'];
                                    $titulo = $prod['titulo'];
                                    $peso = $prod['peso_item'];
                                    $quant = $prod['quantidade_item'];
                                    $selecionado = isset($prod['selecionado']) && $prod['selecionado'] == 1 ? "selected" : "";

                                    echo "<option $selecionado value=\"$codigo\">$codigo - $titulo - $peso"."kg - Qt: $quant</option>\n";
                                }
                            }
                        ?>
                    </select>                    
                </div>
             <?php
            }
            if(isset($arrayComProdutos)){
                $_SESSION['array_com_produtos'] = $arrayComProdutos;
            }
            ?>
            <div class="my-5">
            <input type="submit" class="btn btn-primary" value="Continuar">
            </div>
    </form>
    <div class="mt-5"></div>
</div>
</body>
</html>
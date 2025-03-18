<?php
require('controller/login_checker.php');
require('config/connection.php');   
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
$desconto = isset($_POST['desconto'])?$_POST['desconto']:(isset($_SESSION['dadosCliente']['desconto'])?$_SESSION['dadosCliente']['desconto']:null);
$tipoDesconto = isset($_POST['tipoDesconto'])?$_POST['tipoDesconto']:(isset($_SESSION['dadosCliente']['tipoDesconto'])?$_SESSION['dadosCliente']['tipoDesconto']:null);

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
isset($desconto)?$_SESSION['dadosCliente']['desconto'] = $desconto:null;
isset($tipoDesconto)?$_SESSION['dadosCliente']['tipoDesconto'] = $tipoDesconto:null;

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

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Selecionar itens</title>
</head>
<body>
<?php
require('partials/navbar.php');



// Buscando produtos de acordo com os parametros de largura e altura
if($alturaTotal !== "" && $larguraTotal !== ""){
    if($alturaTotal !== 0 && $larguraTotal !== 0){
        $sql = "SELECT * FROM produtos
                WHERE deleted = 0
                AND altura_minima_porta <= $alturaTotal
                AND altura_maxima_porta > $alturaTotal
                AND largura_minima_porta <= $larguraTotal
                AND largura_maxima_porta > $larguraTotal
                AND ativo = 1;
                ";
                // AND peso_minimo <= $peso
                // AND peso_maximo > $peso
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // echo "<h3>Consulta 1</h3>";
        // echo "<pre>".print_r($resultado)."</pre>";
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
        echo $alturaTotal !== ""?"Largura: " . $larguraTotal:"";
        echo $alturaTotal !== ""?" / Altura: " . $alturaTotal:"";
    ?>
</div>
<div class="container mt-4">
    <?php
        if(isset($_SESSION['array_com_produtos']) && count($_SESSION['array_com_produtos']) > 0){
            $arrayComProdutos = $_SESSION['array_com_produtos'];
        } else {
            if(isset($resultado) && count($resultado) > 0){
                
                echo "Quantidade: $quantidade / m²: $m2";
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
    
                    $pesoItem = $peso * $quantidadeItem;
                    $pesoTotalPorta += $pesoItem;
    
                    $produtoParaArray['id'] = $id;
                    $produtoParaArray['selecionado'] = $selecionado;
                    $produtoParaArray['codigo'] = $codigo;
                    $produtoParaArray['titulo'] = $titulo;
                    $produtoParaArray['quantidade_item'] = $quantidadeItem;
                    $produtoParaArray['peso_item'] = $pesoItem;
                    $produtoParaArray['tipo_consumo'] = $tipoConsumo;
                    $produtoParaArray['multiplicador'] = $multiplicador;
    
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
        <div class="my-3">
            <a class="btn btn-primary" href="novo_orcamento_edita_itens.php">Editar itens</a>
        </div>
    
</div>
<div class="container">
    <!-- <form method="post" action="novo_orcamento_motores.php"> -->
    <form method="post" action="novo_orcamento_automatizadores.php">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Adicionar</th>
                    <th>Código</th>
                    <th>Titulo</th>
                    <th>Quantidade</th>
                    <th>Peso</th>
                    <th>Consumo</th>
                    <!-- <th>Ação</th> -->
                </tr>
            </thead>
                <tbody>
                    <?php
                        // Duas querys para separar os selecionados dos não selecionados
                        if(isset($arrayComProdutos)){
                            foreach($arrayComProdutos as $produto){
                                if($produto['selecionado'] == 1){
                                    ?>
                                    <tr>
                                        <td>
                                            <input 
                                            class="form-check-input" 
                                            type="checkbox"
                                            name="produtosSelecionados[]"
                                            value="<?= $produto['codigo'] ?>" 
                                            <?= $produto['selecionado'] == 1 ? "checked" : null ?>
                                            id="<?= "codigo".$produto['codigo'] ?>"
                                            >
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['codigo'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['titulo'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['quantidade_item'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['peso_item'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['tipo_consumo'] ?>
                                            </label>
                                        </td>
                                        <!-- <td>
                                            <a href="<?= "novo_orcamento_edita_itens.php?codigo=".$produto['codigo'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                        </td> -->
                                    </tr>
                                    <?php
                                }
                            }

                        }
                        
                        foreach($arrayComProdutos as $produto){
                            if($produto['selecionado'] == 0){
                                ?>
                                    <tr>
                                        <td>
                                            <input 
                                            class="form-check-input" 
                                            type="checkbox"
                                            name="produtosSelecionados[]"
                                            value="<?= $produto['codigo'] ?>" 
                                            <?= $produto['selecionado'] == 1 ? "checked" : null ?>
                                            id="<?= "codigo".$produto['codigo'] ?>"
                                            >
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['codigo'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['titulo'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['quantidade_item'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['peso_item'] ?>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['tipo_consumo'] ?>
                                            </label>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }
                        
                    ?>
                </tbody>
        </table>
        <?php
        if(isset($arrayComProdutos)){
            $_SESSION['array_com_produtos'] = $arrayComProdutos;

        }
            // echo "<pre>";
            // print_r($arrayComProdutos);
        ?>
        <div class="my-5">
            <input type="submit" class="btn btn-primary" value="Continuar">
        </div>
    </form>
</div>
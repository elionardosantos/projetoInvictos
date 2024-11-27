<?php
require('controller/login_checker.php');
require('config/connection.php');   
date_default_timezone_set('America/Sao_Paulo');

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
$larguraTotal = isset($_POST['largura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['largura']))):"";
$alturaTotal = isset($_POST['altura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['altura']))):"";
$rolo = isset($_POST['rolo'])?floatval(str_replace(",",".",str_replace(".","",$_POST['rolo']))):"";

$m2 = ($alturaTotal + $rolo) * $larguraTotal;

$_SESSION['contatoId'] = $contatoId;
$_SESSION['cliente'] = $cliente;
$_SESSION['documentoForm'] = $documentoForm;
$_SESSION['documento'] = $documento;
$_SESSION['tipoPessoa'] = $tipoPessoa;
$_SESSION['endereco'] = $endereco;
$_SESSION['numero'] = $numero;
$_SESSION['bairro'] = $bairro;
$_SESSION['municipio'] = $municipio;
$_SESSION['estado'] = $estado;
$_SESSION['tabelaPreco'] = $tabelaPreco;
$_SESSION['condicaoPagamento'] = $condicaoPagamento;
$_SESSION['cep'] = $cep;
$_SESSION['desconto'] = $desconto;
$_SESSION['tipoDesconto'] = $tipoDesconto;

$_POST['tel'] = $tel;
$_POST['cel'] = $cel;
$_POST['email'] = $email;

$_POST['observacoes'] = $observacoes;
$_POST['observacoesInternas'] = $observacoesInternas;

$_POST['nomeServico'] = $nomeServico;
$_POST['enderecoServico'] = $enderecoServico;
$_POST['numeroServico'] = $numeroServico;
$_POST['bairroServico'] = $bairroServico;
$_POST['municipioServico'] = $municipioServico;
$_POST['estadoServico'] = $estadoServico;
$_POST['cepServico'] = $cepServico;

$_POST['quantidade'] = $quantidade;
$_POST['larguraTotal'] = $larguraTotal;
$_POST['alturaTotal'] = $alturaTotal;
$_POST['rolo'] = $rolo;

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

if($alturaTotal !== "" && $larguraTotal !== ""){
    if($alturaTotal !== 0 && $larguraTotal !== 0){
        $sql = "SELECT * FROM produtos
                WHERE altura_minima_porta <= $alturaTotal
                AND altura_maxima_porta > $alturaTotal
                AND largura_minima_porta <= $larguraTotal
                AND largura_maxima_porta > $larguraTotal
                ";
                // AND peso_minimo <= $peso
                // AND peso_maximo > $peso
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Dimensões inválidas";
    }
} else {
    echo "Preencha as dimensões";
}

?>

<div class="container mt-4">
    <?php
        echo $alturaTotal !== ""?"Largura: " . $larguraTotal:"";
        echo $alturaTotal !== ""?" / Altura: " . $alturaTotal:"";
    ?>
</div>
<div class="container mt-4">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th>Adicionar</th>
                <th>Código</th>
                <th>Titulo</th>
                <th>Quantidade</th>
                <th>Peso</th>
                <th>Consumo</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(isset($resultado) && count($resultado) > 0){
                    
                    echo "metro²: $m2";
                    $pesoTotalPorta = 0;

                    foreach($resultado as $row){
                        $id = isset($row['id'])?$row['id']:"";
                        $codigo = isset($row['codigo'])?$row['codigo']:"";
                        $titulo = isset($row['titulo'])?$row['titulo']:"";
                        $peso = isset($row['peso'])?floatVal(str_replace(",",".",$row['peso'])):null;
                        $tipoConsumo = isset($row['tipo_consumo'])?$row['tipo_consumo']:null;
                        $multiplicador = isset($row['multiplicador'])?$row['multiplicador']:null;
                        $selecionado = isset($row['selecionado'])?$row['selecionado']:null;

                        $pesoItem = null;
                        switch ($tipoConsumo) {
                            case 'm2':
                                $quantidadeItem = $m2 * $multiplicador;
                                break;

                            case 'largura':
                                $quantidadeItem = $larguraTotal * $multiplicador;
                                break;
                                
                            case 'altura':
                                $quantidadeItem = $alturaTotal * $multiplicador;
                                break;

                            case 'unidade':
                                $quantidadeItem = $unidade * $multiplicador;
                                break;
                        }

                        $pesoItem = $peso * $quantidadeItem;
                        $produtoParaArray['id'] = $id;
                        $produtoParaArray['codigo'] = $codigo;
                        $produtoParaArray['titulo'] = $titulo;
                        $produtoParaArray['peso'] = $peso;
                        $produtoParaArray['tipo_consumo'] = $tipoConsumo;
                        $produtoParaArray['multiplicador'] = $multiplicador;
                        $produtoParaArray['selecionado'] = $selecionado;

                        $arrayComProdutos[] = $produtoParaArray;
                    ?>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" <?= $selecionado == 1 ? "checked" : ""; ?>>
                                </div>
                            </td>
                            <td><?= $codigo ?></td>
                            <td><?= $titulo ?></td>
                            <td><?= $quantidadeItem ?></td>
                            <td><?= $pesoItem ?></td>
                            <td><?= $tipoConsumo ?></td>
                        </tr>
                    <?php
                        $pesoTotalPorta += $pesoItem;

                        $produtoParaArray['id'] = $id;
                        $produtoParaArray['codigo'] = $codigo;
                        $produtoParaArray['titulo'] = $titulo;
                        $produtoParaArray['peso'] = $peso;
                        $produtoParaArray['tipo_consumo'] = $tipoConsumo;
                        $produtoParaArray['multiplicador'] = $multiplicador;
                        $produtoParaArray['selecionado'] = $selecionado;

                        $arrayComProdutos[] = $produtoParaArray;
                    }
                    echo " / Peso total porta: $pesoTotalPorta KG<br><br>";
                    
                } else {
                    // nada aqui...
                }
                $sql = "SELECT * FROM produtos
                    WHERE peso_minimo_porta <= $pesoTotalPorta
                    AND peso_maximo_porta >= $pesoTotalPorta
                    ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if(count($resultado) > 0){
                    foreach($resultado as $row){
                    ?>   
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" <?= $row['selecionado'] == 1 ? "checked" : ""; ?>>
                            </div>
                        </td>
                        <td><?= $row['codigo'] ?></td>
                        <td><?= $row['titulo'] ?></td>
                        <td><?= $row['multiplicador'] ?></td>
                        <td><?= $row['peso'] ?></td>
                        <td><?= $row['tipo_consumo'] ?></td>
                    </tr>
                    <?php
                        $produtoParaArray['id'] = $id;
                        $produtoParaArray['codigo'] = $codigo;
                        $produtoParaArray['titulo'] = $titulo;
                        $produtoParaArray['peso'] = $peso;
                        $produtoParaArray['tipo_consumo'] = $tipoConsumo;
                        $produtoParaArray['multiplicador'] = $multiplicador;
                        $produtoParaArray['selecionado'] = $selecionado;

                        $arrayComProdutos[] = $produtoParaArray;
                    }
                } else {
                    // nada aqui...
                }
            ?>
        </tbody>
    </table>
    <!-- <?php print_r($arrayComProdutos); ?> -->
    
</div>
<!-- Criar uma tabela utilizando a variavel $arrayComProdutos -->
<div class="container">
    <form action="" method="post"></form>
</div>
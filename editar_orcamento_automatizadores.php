<?php
date_default_timezone_set('America/Sao_Paulo');
require('controller/login_checker.php');
require('config/connection.php');   
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Itens por Peso</title>
</head>
<body>
<?php
    require('partials/navbar.php');

    $arrayProds1 = $_SESSION['produtosSelecionados'];

    if(isset($_POST['produtosSelecionados']) && count($_POST['produtosSelecionados']) > 0){
        foreach($_POST as $produto => $value){
            // echo " - $value. <br>";
            $arrayProds2 = $value;
        }

    }
    if(isset($arrayProds2)){
        $_SESSION['produtosSelecionados'] = array_merge($arrayProds1, $arrayProds2);

    } else {
        $_SESSION['produtosSelecionados'] = $arrayProds1;
    }

    // Exibir nome do cliente na tela de seleção de itens
    if(isset($_SESSION['dadosCliente']['cliente']) && $_SESSION['dadosCliente']['cliente'] !== ""){
?>
        <div class="container mt-4">
            <div class="row align-items-center">
                <div class="col-8">
                    <div class="row">
                        <div class="col">Cliente: <strong><?= $_SESSION['dadosCliente']['cliente'] ?></strong></div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    $pesoTotalPorta = 0;    
    if(isset($_SESSION['produtosSelecionados'])){
        foreach ($_SESSION['produtosSelecionados'] as $key => $value) {
            if(isset($value) && $value !== ""){
                $pesoItem = $_SESSION['array_com_produtos'][$value]['peso_item'];
                $pesoTotalPorta += $pesoItem;
            }
        }
    }
?>

<div class="container mt-4">
    Peso: <?= $pesoTotalPorta ?>Kg
</div>
<div class="container my-3">
    <h4>ITENS POR PESO</h4>
</div>









<?php // INICIO DA LOGICA DE ITENS
$quantidade = isset($_SESSION['dadosCliente']['quantidade'])?$_SESSION['dadosCliente']['quantidade']:1;

// Buscando produtos de acordo com os parametros de largura e altura
if(isset($pesoTotalPorta) && $pesoTotalPorta !== ""){
    if($pesoTotalPorta > 0){
        require('config/connection.php');
        $sql = "SELECT `id`,`codigo`,`titulo`,`peso`,`tipo_consumo`,`multiplicador`,`selecionado`,`categoria`,`tipo_produto` FROM produtos
                WHERE deleted = 0
                AND ativo = 1
                AND tipo_produto IS NOT NULL 
                AND tipo_produto = 2
                ;";
                // AND peso_minimo_porta <= $pesoTotalPorta
                // AND peso_maximo_porta >= $pesoTotalPorta
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {
        echo "<div class=\"container\">Nenhum item encontrado para o peso atual<div>";
    }
    
} else {
    echo "<div class=\"container\">Nenhum item encontrado para o peso atual<div>";
}
?>

<div class="container mt-4">
    <?php
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
    <form method="POST" action="editar_orcamento_process.php">
        <?php
            foreach($categsArrayProdutos as $ctg){
                ?>
                <div class="mt-3">
                    <b> - <?= $ctg['name'] ?>: </b>
                </div>
                <div class="mt-2">
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
                                    
                                    // $selecionado = isset($prod['selecionado']) && $prod['selecionado'] == 1 ? "selected" : "";
                                    foreach($_SESSION['itensPedido'] as $blingItem){
                                        if($blingItem['codigo'] == $codigo){
                                            $selecionado = "selected";
                                            $indicator = "*";
                                            break;
                                        } else {
                                            $selecionado = "";
                                            $indicator = "";
                                        }
                                    }

                                    echo "<option $selecionado value=\"$codigo\">$codigo - $titulo - Qt: $quant $indicator</option>\n";
                                }
                            }
                        ?>
                    </select>                    
                </div>
             <?php
            }
            if(isset($arrayComProdutos)){
                $_SESSION['array_com_produtos_por_peso'] = $arrayComProdutos;
            }
            ?>
            <div class="my-5">
            <input type="submit" class="btn btn-primary" value="Continuar">
            </div>
    </form>
    <div class="mt-5"></div>
</div>














<?php

    // echo "<div class=\"container\">";
    // echo "<pre>";
    // echo print_r($resultado);
    // echo "<pre>";
    // echo "</div>";

    // echo "POST: ";
    // print_r($_POST);

    // echo "SESSION[produtosSelecionados]: ";
    // print_r($_SESSION['produtosSelecionados']);

    // echo "arrayProds1: ";
    // print_r($arrayProds1);
    // echo "arrayProds2: ";
    // print_r($arrayProds2);

?>
</body>
</html>
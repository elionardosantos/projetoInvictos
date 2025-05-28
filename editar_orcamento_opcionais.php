<?php
require('controller/login_checker.php');
require('config/connection.php');   
date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Itens Opcionais</title>
</head>
<body>
<?php
require('partials/navbar.php');



$_SESSION['produtosSelecionados'] = [];


foreach($_POST as $produto => $value){
    // echo " - $value. <br>";
    $_SESSION['produtosSelecionados'][] = $value;
}


$larguraTotal = isset($_SESSION['dadosCliente']['larguraTotal']) ? $_SESSION['dadosCliente']['larguraTotal'] : "";
$alturaTotal = isset($_SESSION['dadosCliente']['alturaTotal']) ? $_SESSION['dadosCliente']['alturaTotal'] : "";

// Exibir nome do cliente na tela de seleção de itens
$cliente = $_SESSION['dadosCliente']['cliente'];
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
    <h4>ITENS OPCIONAIS</h4>
</div>

<div class="container">
    <!-- <form method="post" action="novo_orcamento_motores.php"> -->
    <form method="post" action="editar_orcamento_automatizadores.php">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Seleção</th>
                    <th>Titulo - Peso - Quantidade</th>
                </tr>
            </thead>
                <tbody>
                    <?php
                        // Duas querys para separar os selecionados dos não selecionados
                        if(isset($_SESSION['array_com_produtos'])){
                            foreach($_SESSION['array_com_produtos'] as $produto){
                                if($produto['tipo_produto'] == 1){ // && $produto['selecionado'] == 1
                                    $checked = isset($produto['selecionado']) && $produto['selecionado'] == 1 ? "checked" : "";

                                    ?>
                                    <tr>
                                        <td>
                                            <input 
                                            class="form-check-input" 
                                            type="checkbox"
                                            name="produtosSelecionados[]"
                                            value="<?= $produto['codigo'] ?>" 
                                            <?= $checked ?>
                                            id="<?= "codigo".$produto['codigo'] ?>"
                                            >
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="<?= "codigo".$produto['codigo'] ?>">
                                                <?= $produto['codigo'] . " - " . $produto['titulo'] . " - " . $produto['peso_item'] . "kg - Qt: " . $produto['quantidade_item']?>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }

                        }
                        
                    ?>
                </tbody>
        </table>
        <div class="my-5">
            <input type="submit" class="btn btn-primary" value="Continuar">
        </div>
    </form>
</div>
<?php
    // echo "<pre>";
    // echo "POST DATA: ";
    // print_r($_POST);

    // echo "SESSION DATA: ";
    // print_r($_SESSION['array_com_produtos']);
    // echo "</pre>";
?>
</body>
</html>
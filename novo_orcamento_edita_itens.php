<?php
require('controller/login_checker.php');
require('config/connection.php');   
date_default_timezone_set('America/Sao_Paulo');

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

?>


<div class="container mt-5">
    <form method="post" action="novo_orcamento_edita_itens_process.php">
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
                        $arrayComProdutos = $_SESSION['array_com_produtos'];
                        if(isset($arrayComProdutos)){
                            foreach($arrayComProdutos as $produto){
                                if(1){ //ESTE IF NÃO TEM NENHUMA FUNÇÃO PRÁTICA
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

                        }
                        /*
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
                        */
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
        <div class="mt-5">
            <input type="submit" class="btn btn-primary" value="Continuar">
        </div>
    </form>
</div>

<!-- <pre>
<?php print_r($_SESSION); ?>
</pre> -->
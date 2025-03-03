<?php
date_default_timezone_set('America/Sao_Paulo');
require('controller/login_checker.php');
require('config/connection.php');   
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
</head>
<body>
<?php
    require('partials/navbar.php');

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
    if(isset($_SESSION['array_com_produtos'])){
        foreach ($_SESSION['array_com_produtos'] as $key => $item) {
            $pesoTotalPorta += $item['peso_item'];
        }
    }
?>

<div class="container mt-4">
    Peso total: <?= $pesoTotalPorta ?>Kg
</div>
<div class="container mt-4">
    <a href="novo_orcamento_itens.php" class="btn btn-primary">Voltar para itens</a></p>

</div>
<?php
    $sql = "SELECT codigo, titulo FROM automatizadores
            WHERE deleted = 0
            AND ativo = 1
            ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo "<h3>Consulta 1</h3>";
    // echo "<pre>".print_r($resultado)."</pre>";

    ?>
    <div class="container mt-4">
        <form method="POST" action="print_post.php">

            <?php
            if(isset($resultado) && count($resultado) > 0){
                foreach($resultado as $item){
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="<?= $item['codigo'] ?>" id="<?= $item['codigo'] ?>">
                            <label class="form-check-label" for="<?= $item['codigo'] ?>">
                                <?= $item['titulo'] ?>
                            </label>
                        </div>
                    <?php    
                }
            }
            ?>
            <div class="mt-4">
                <input class="btn btn-primary" type="submit" value="Continuar">

            </div>

        </form>
    </div>


<!-- ---------------------------- Conteúdo do $_SESSION ----------------------------
<pre>
<?php print_r($_SESSION); ?>
</pre> -->


</body>
</html>
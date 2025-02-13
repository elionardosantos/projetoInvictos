<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Título</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('controller/only_level_2.php');
        require('partials/navbar.php');

        date_default_timezone_set('America/Sao_Paulo');
        $timeNow = date('Y-m-d H:i:s');
        $produtoId = $_GET['id'];
        $loggedUserId = $_SESSION['loggedUserId'];

        require('config/connection.php');

        $sql = "UPDATE `motores` SET `deleted`= :deleted, `deleted_by`=:deleted_by, `deleted_at`=:deleted_at WHERE `id`= :produtoId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':deleted', 1);
        $stmt->bindValue(':deleted_by', $loggedUserId);
        $stmt->bindValue(':deleted_at', $timeNow);
        $stmt->bindValue(':produtoId', $produtoId);
        $stmt->execute();
        $result = $stmt->rowCount();

        if($result){
            $screenMessage = "<div class=\"alert alert-success\">Produto apagado com sucesso.</div>";
        } else {
            $screenMessage = "<div class=\"alert alert-danger\">Um erro ocorreu. Favor verificar se o produto foi apagado.</div>";
        }

    ?>

    <div class="container">
        <p>
            <?= $screenMessage; ?>
        </p>
    </div>
    <div class="container">
        <a href="motores.php" class="btn btn-primary">Voltar</a>
    </div>
</body>
</html>







<?php 
    
?>
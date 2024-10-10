<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Título</title>
</head>
<body>
    <?php
        require('controller/loginChecker.php');
        require('partials/navbar.php');

        $formUserId = $_GET['id'];

        require('config/connection.php');

        $sql = "UPDATE `users` SET `active`= :active WHERE `id`= :formUserId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':formUserId', $formUserId);
        $stmt->bindValue(':active', 0);
        $stmt->execute();
        $result = $stmt->rowCount();

        if($result){
            $screenMessage = "<div class=\"alert alert-success\">Usuário apagado com sucesso.</div>";
        } else {
            $screenMessage = "<div class=\"alert alert-danger\">Um erro ocorreu. Favor verificar se o usuário foi apagado.</div>";
        }

    ?>

    <div class="container">
        <p>
            <?= $screenMessage; ?>
        </p>
    </div>
</body>
</html>







<?php 
    
?>
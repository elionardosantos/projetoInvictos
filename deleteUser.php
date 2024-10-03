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

        $sql = "DELETE FROM `users` WHERE `id` = \"$formUserId\"";

        if($conn->query($sql)){
            $screenMessage = "<div class=\"alert alert-danger\">Usuário apagado</div>";
        } else {
            $screenMessage = "<div class=\"alert alert-danger\">Erro: Usuário não apagado</div>";
        }

        $conn->close();
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
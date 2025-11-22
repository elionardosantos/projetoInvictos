<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Título</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../../../controller/login_checker.php');
        require(__DIR__ . '/../../../partials/navbar.php');
        require(__DIR__ . '/../../../controller/only_level_2.php');

        $loggedUser = $_SESSION['login']['loggedUserId'];
        date_default_timezone_set('America/Sao_Paulo');
        $currentDateTime = date('Y-m-d H:i:s');

        $formUserId = $_GET['id'];

        if($loggedUser == $formUserId){
            $screenMessage = "<div class=\"alert alert-danger\">Você não pode apagar seu próprio usuário.</div>";
        } else {
            require(__DIR__ . '/../../../config/connection.php');
            
            $sql = "UPDATE `users` SET `deleted`= :deleted, `level` = :level, `deleted_by` = :deleted_by, `deleted_at` = :deleted_at WHERE `id`= :formUserId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':formUserId', $formUserId);
            $stmt->bindValue(':deleted', 1);
            $stmt->bindValue(':level',0);
            $stmt->bindValue(':deleted_by', $loggedUser);
            $stmt->bindValue(':deleted_at', $currentDateTime);
    
    
            $stmt->execute();
            $result = $stmt->rowCount();
    
            if($result){
                $screenMessage = "<div class=\"alert alert-success\">Usuário apagado com sucesso.</div>";
            } else {
                $screenMessage = "<div class=\"alert alert-danger\">Um erro ocorreu. Favor verificar se o usuário foi apagado.</div>";
            }
        }

    ?>

    <div class="container">
        <p>
            <?= $screenMessage; ?>
        </p>
        <a href="listar.php">
            <button class="btn btn-primary">Voltar</button>
        </a>
    </div>
</body>
</html>







<?php 
    
?>
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

        
        date_default_timezone_set('America/Sao_Paulo');
        $dateTime = date('Y-m-d H:i:s');
        $categId = $_GET['id'];

        require(__DIR__ . '/../../../config/connection.php');

        $sql = "UPDATE `categorias_produtos` SET `deleted`= :deleted, `deleted_by` = :deleted_by, `deleted_at` = :deleted_at WHERE `id`= :categId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':categId', $categId);
        $stmt->bindValue(':deleted', 1);
        $stmt->bindValue(':deleted_by', $_SESSION['login']['loggedUserId']);
        $stmt->bindValue(':deleted_at', $dateTime);
        $stmt->execute();
        $result = $stmt->rowCount();

        if($result){
            $screenMessage = "<div class=\"alert alert-success\">Categoria apagada com sucesso.</div>";
        } else {
            $screenMessage = "<div class=\"alert alert-danger\">Um erro ocorreu. Favor verificar se a categoria foi apagado.</div>";
        }

    ?>

    <div class="container">
        <p>
            <?= $screenMessage; ?>
        </p>
    </div>
    <div class="mt-3 container">
        <a href="listar.php">
            <button type="submit" class="btn btn-primary">Voltar</button>
        </a>
    </div>
</body>
</html>







<?php 
    
?>
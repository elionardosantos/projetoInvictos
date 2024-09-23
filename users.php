<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/loginChecker.php');
        require('partials/navbar.php');



    ?>
    <div class="container">
        <h2>
            <a class="btn btn-primary" href="userRegistration.php">Novo</a>
        </h2>
    </div>
</body>
</html>
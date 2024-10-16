<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2>Início</h2>
        <p>
        <?php
            date_default_timezone_set('America/Sao_Paulo');
            echo $dataHoraAtual = date('d/m/Y');
        ?>
        </p>

    </div>
</body>
</html>
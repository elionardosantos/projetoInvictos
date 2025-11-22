<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        // require('partials/navbar.php');
        header('location: /pages/home.php');
    ?>
</body>
</html>
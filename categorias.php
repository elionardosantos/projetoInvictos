<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Categorias</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('controller/only_level_2.php');
        require('partials/navbar.php');
    ?>
    <div class="container my-3">
        <h2>Categorias</h2>
    </div>
    <div class="container my-3">
        <a href="nova_categoria.php" class="btn btn-primary" role="button">Cadastrar nova categoria</a>
    </div>





    
</body>
</html>
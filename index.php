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
    </div>
    <div class="container my-3">
        <a href="novo_orcamento.php" class="btn btn-primary p-3 mt-2 me-1" role="button">Novo Orçamento</a>
        <a href="pedidos.php" class="btn btn-primary p-3 mt-2 me-1" role="button">Pedidos/Orçamentos</a>
        <a href="consulta_cnpj_visualizacao.php" class="btn btn-primary p-3 mt-2 me-1" role="button">Consultar CNPJ</a>
    </div>
    <div class="container mt-4">
        
    </div>

</body>
</html>
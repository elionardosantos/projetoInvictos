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
    <div class="container mt-4">
        <a href="novo_produto.php" class="btn btn-primary" role="button">Novo Produto</a>
    </div>
    <div class="container mt-4">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Titulo</th>
                    <th>Peso</th>
                    <th>Consumo</th>
                    <th>Multiplicação</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>345</td>
                    <td>Produto de exemplo</td>
                    <td>8,5</td>
                    <td>Altura</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>348</td>
                    <td>Produto de exemplo</td>
                    <td>6,5</td>
                    <td>Metro quadrado</td>
                    <td>1</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
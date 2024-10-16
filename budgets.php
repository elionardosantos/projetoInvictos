<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Orçamentos</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2 class="">Orçamentos</h2>
    </div>
    <div class="container my-3">
        <a href="new_budget.php" class="btn btn-primary" role="button">Novo</a>
        <a href="cnpj_query.php" class="btn btn-primary" role="button">Consulta CNPJ</a>    
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="col-2">Data</th>
                    <th scope="col" class="col-2">Orçamento</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col" class="col-1">Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <td>11/10/2024</td>
                    <td><a href="">240032</a></td>
                    <td>João Pereira</td>
                    <td>R$ 2.000,00</td>
                    <td><button class="btn btn-primary btn-sm">Ver/Editar</button></td>
                </tr>
                <tr>
                    <td>11/10/2024</td>
                    <td><a href="">240031</a></td>
                    <td>Maria Pereira</td>
                    <td>R$ 4.000,00</td>
                    <td><button class="btn btn-primary btn-sm">Ver/Editar</button></td>
                </tr>
                <tr>
                    <td>11/10/2024</td>
                    <td><a href="">240030</a></td>
                    <td>João Lucas</td>
                    <td>R$ 1.000,00</td>
                    <td><button class="btn btn-primary btn-sm">Ver/Editar</button></td>
                </tr>
                <tr>
                    <td>10/10/2024</td>
                    <td><a href="">240029</a></td>
                    <td>Nome de Exemplo</td>
                    <td>R$ 8000,00</td>
                    <td><button class="btn btn-primary btn-sm">Ver/Editar</button></td>
                </tr>
                <tr>
                    <td>10/10/2024</td>
                    <td><a href="">240028</a></td>
                    <td>Joana Silva</td>
                    <td>R$ 2.200,00</td>
                    <td><button class="btn btn-primary btn-sm">Ver/Editar</button></td>
                </tr>
                <tr>
                    <td>09/10/2024</td>
                    <td><a href="">240027</a></td>
                    <td>João Pereira</td>
                    <td>R$ 1.900,00</td>
                    <td><button class="btn btn-primary btn-sm">Ver/Editar</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
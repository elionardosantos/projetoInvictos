<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Cadastrar usuário</title>
</head>
<body>
    <?php
        require('controller/loginChecker.php');
        require('partials/navbar.php');

    ?>
    <div class="container">
        <h2>Cadastrar usuário</h2>
        <br>
        <form action="" method="post">
            <div class="row mb-3">
                <label for="" class="col-sm-1 col-form-label">Nome</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="" class="col-sm-1 col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" id="" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-1 col-form-label">Senha</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="inputPassword3" required>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

        <?php
            
        ?>
    </div>
</body>
</html>
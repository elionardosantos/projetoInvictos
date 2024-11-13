<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Cadastrar usuário</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');
    ?>
    
    <div class="container">
        <p><h2>Cadastrar usuário</h2></p>
        <?= isset($screenMessage)?$screenMessage:"" ?>
        <form action="cadastrar_usuario_process.php" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text col-md-2 col-3">Nome</span>
                <input type="text" class="form-control" placeholder="Digite o nome" name="formName">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-md-2 col-3">Email</span>
                <input type="email" class="form-control" placeholder="Digite o email" name="formEmail">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-md-2 col-3">Senha</span>
                <input type="password" class="form-control" placeholder="Digite a senha" name="formPassword">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Nível de Usuário</span>
                <div class="">
                    <select class="form-select form-control" name="formLevel">
                        <option value="0">0 - Inativo</option>
                        <option value="1" selected>1 - Usuário</option>
                        <option value="2">2 - Administrador</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Cadastrar usuário</button>
                <a class="btn btn-primary" href="listar_usuarios.php">Voltar</a>
            </div>
        </form>

    </div>
</body>
</html>
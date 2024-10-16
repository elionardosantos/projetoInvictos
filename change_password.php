<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Alterar senha</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2>Alterar senha</h2>
    </div>
    <div class="container my-3">
        
        <form action="change_password_process.php" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-3 col-lg-2 col-3 is-invalid">Senha atual</span>
                <input autofocus type="password" class="form-control <?= $currentPasswordFormStyle ?>" placeholder="Digite a senha atual" name="formCurrentPassword" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-3 col-lg-2 col-3">Nova senha</span>
                <input type="password" class="form-control <?= $newPasswordFormStyle ?>" placeholder="Digite a nova senha" name="formNewPassword" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-3 col-lg-2 col-3">Nova senha</span>
                <input type="password" class="form-control <?= $newPasswordFormStyle ?>" placeholder="Confirme a nova senha" name="formNewPassword2" required>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Alterar</button>
        </form>

    </div>
</body>
</html>
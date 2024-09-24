<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Login</title>
</head>
<body>
    <?php
        session_start();

        if(isset($_SESSION['email']) && $_SESSION['email'] !== ""){
            header('location: index.php');
            echo "Logado pela SESSION";

        } else if((isset($_POST['email']) && $_POST['email'] !== "")){
            $_SESSION['email'] = $_POST['email'];
            echo "Logado pelo POST";
            header('location: index.php');
                
        } else {
            echo "Ninguém logado";
        }
    ?>
    <div class="bg-secondary">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="col-md-4 border p-4 rounded bg-dark text-white">
                <h3 class="text-center mb-4">Login</h3>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input required type="email" class="form-control" name="email" id="email" placeholder="Digite seu e-mail">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input required type="password" class="form-control" name="password" id="password" placeholder="Digite sua senha">
                    </div>
                    <span class="text-danger"><?= isset($message)?"$message":"" ?></span><br><br>
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
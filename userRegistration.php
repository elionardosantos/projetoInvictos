<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Cadastrar usuário</title>
</head>
<body>
    <?php
        // require('controller/loginChecker.php');
        require('partials/navbar.php');

    ?>
    <div class="container">
        <h2>Cadastrar usuário</h2>
        <br>
        <form action="" method="post">
            <div class="row mb-3">
                <label for="name" class="col-sm-1 col-form-label">Nome</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-1 col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="pass" class="col-sm-1 col-form-label">Senha</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <br>
            <br>
        </form>

        <?php
            $name = isset($_POST['name'])?$_POST['name']:"";
            $email = isset($_POST['email'])?$_POST['email']:"";
            $pass = isset($_POST['pass'])?$_POST['pass']:"";
            
            if($name !== "" && $email !== "" && $pass !== ""){
                echo "<p>Nome: $name</p><p>Email: $email</p><p>Senha: $pass</p>";
                usersList();                
            } else {
                echo "Falta preencher algum dado";
            }

            function usersList() {
                // Aqui começa a brincadeira...
            }
        ?>
    </div>
</body>
</html>
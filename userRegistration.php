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
        require('controller/onlyLevel2.php');
    ?>
    <div class="container">
        <p><h2>Cadastrar usuário</h2></p>
        <br>
        <form action="" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-1 col-3">Nome</span>
                <input type="text" class="form-control" placeholder="Digite o nome" name="formName">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-1 col-3">Email</span>
                <input type="email" class="form-control" placeholder="Digite o email" name="formEmail">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-1 col-3">Senha</span>
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
            <p>
                <button type="submit" class="btn btn-primary">Cadastrar usuário</button>
            </p>
        </form>

        <?php
            $formName = isset($_POST['formName'])?$_POST['formName']:"";
            $formEmail = isset($_POST['formEmail'])?$_POST['formEmail']:"";
            $formPassword = isset($_POST['formPassword'])?$_POST['formPassword']:"";
            $formLevel = isset($_POST['formLevel'])?$_POST['formLevel']:"";
            $formPasswordHash = hash('sha256',$formPassword);

            // password_verify(senha_login, senha_hash)
            
            if($formName !== "" && $formEmail !== "" && $formPassword !== ""){
                require('config/connection.php');

                $sql = "SELECT * FROM `users` WHERE email = \"$formEmail\"";
                $result = mysqli_query($conn, $sql);
                
                if($result -> num_rows > 0) {
                    echo '<div class="alert alert-danger">O email ' . $formEmail . ' já está sendo utilizado. Por favor, escolha outro email</div>';
                } else {
                    userInsert();
                }
                
                $conn -> close();
            }        
            
            function userInsert() {
                global $formName;
                global $formEmail;
                global $formPasswordHash;
                global $formLevel;

                require('config/connection.php');
                $sql = "INSERT INTO `users`(`email`, `name`, `password`, `level`) VALUES ('$formEmail','$formName','$formPasswordHash','$formLevel')";

                //Executando o insert
                if($conn->query($sql) == true){
                    echo '<div class="alert alert-success">Usuário cadastrado com sucesso</div>';
                };
                
                $conn->close();
            }
        ?>
    </div>
</body>
</html>
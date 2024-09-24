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
                <label for="formName" class="col-sm-1 col-form-label">Nome</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="formName" name="formName">
                </div>
            </div>
            <div class="row mb-3">
                <label for="formEemail" class="col-sm-1 col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" id="formEmail" name="formEmail" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="formPass" class="col-sm-1 col-form-label">Senha</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="formPass" name="formPass" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <br><br>
        </form>

        <?php
            $formName = isset($_POST['formName'])?$_POST['formName']:"";
            $formEmail = isset($_POST['formEmail'])?$_POST['formEmail']:"";
            $formPassNoHash = isset($_POST['formPass'])?$_POST['formPass']:"";
            $formPass = password_hash($formPassNoHash, PASSWORD_DEFAULT);

            // password_verify(senha_login, senha_hash)
            
            if($formName !== "" && $formEmail !== "" && $formPass !== ""){
                require('config/connection.php');

                $sql = "SELECT * FROM `users` WHERE email = \"$formEmail\"";
                $result = mysqli_query($conn, $sql);
                
                if($result -> num_rows > 0) {
                    echo '<div class="alert alert-danger">O email ' . $formEmail . ' já está sendo utilizado. Por favor, escolha outro email</div>';
                } else {
                    userInsert();
                    echo '<div class="alert alert-success">Usuário cadastrado com sucesso</div>';
                    
                }
                
                $conn -> close();
            }        
            
            function userInsert() {
                global $formName;
                global $formEmail;
                global $formPass;
                $formStatus = 1;

                require('config/connection.php');
                $sql = "INSERT INTO `users`(`email`, `name`, `password`, `status`) VALUES ('$formEmail','$formName','$formPass','$formStatus')";

                //Executando o insert
                $conn->query($sql);
                
                $conn -> close();
            }
        ?>
    </div>
</body>
</html>
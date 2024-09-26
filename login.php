<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Login</title>
</head>
<body>
    <?php
        session_start();

        if(isset($_SESSION['loginStatus']) && $_SESSION['loginStatus'] == 'logged'){
            header('location: index.php');
            // echo "Logado pela SESSION | <a href=\"controller/logout.php\">Sair</a>";

        } else if((isset($_POST['email']) && $_POST['email'] !== "")){            
            $formEmail = $_POST['email'];
            $formPassword = isset($_POST['password'])?$_POST['password']:"";
            $dbReturn = dbCredentialsQuery($formEmail, $formPassword);

            if($dbReturn == 'email not found'){
                $screenMessage = "Email ou senha incorretos";
            } else if($dbReturn['dbPassword'] === 'unset'){
                $newPasswordId = $dbReturn['dbId'];
                $newPasswordHash = password_hash($formPassword, PASSWORD_DEFAULT);

                require('config/connection.php');
                $sql = "UPDATE `users` SET `password`='$newPasswordHash' WHERE `id` = $newPasswordId";
                $conn->query($sql);
                
                $screenMessage = "<p><br><span class=\"alert alert-success text-success\">Sua senha foi redefinida. Efetue o login</span><br><br></p>";

                $conn->close();
            } else {
                $dbId = isset($dbReturn['dbId'])?$dbReturn['dbId']:'';
                $dbName = isset($dbReturn['dbName'])?$dbReturn['dbName']:'';
                $dbEmail = isset($dbReturn['dbEmail'])?$dbReturn['dbEmail']:'';
                $dbPassword = isset($dbReturn['dbPassword'])?$dbReturn['dbPassword']:'';
                $dbLevel = isset($dbReturn['dbLevel'])?$dbReturn['dbLevel']:'';
    
                // echo "$dbId, $dbName, $dbEmail, $dbPassword, $dbLevel - ";

                if(password_verify($formPassword, $dbPassword)){
                    $_SESSION['loginStatus'] = 'logged';
                    $_SESSION['loggedUserId'] = $dbId;
                    $_SESSION['loggedUserName'] = $dbName;
                    $_SESSION['loggedUserEmail'] = $dbEmail;
                    $_SESSION['loggedUserLevel'] = $dbLevel;

                    header('location: index.php');
                } else {
                    $screenMessage = "<span class=\"text-danger\">Email ou senha incorretos</span>";
                    $_SESSION['loginStatus'] = 'unlogged';
                }
            }

            // echo "Logado pelo POST | <a href=\"controller/logout.php\">Sair</a>";
                
        } else {
            // echo "Ninguém logado";
        }

        function dbCredentialsQuery($formEmail, $formPassword){

            require('config/connection.php');
            
            $sql = "SELECT * FROM `users` WHERE `email` = \"$formEmail\"";
            $result = mysqli_query($conn, $sql);
            
            if($result-> num_rows > 0) {
                foreach ($result as $row) {
                                       
                    $dbId = $row['id'];
                    $dbName = $row['name'];
                    $dbEmail = $row['email'];
                    $dbPassword = $row['password'];
                    $dbLevel = $row['level'];

                    return array(
                        'dbId' => $dbId,
                        'dbName' => $dbName,
                        'dbEmail' => $dbEmail,
                        'dbPassword' => $dbPassword,
                        'dbLevel' => $dbLevel
                    );
                }
            } else {
                return "email not found";
            }
        }

        function passwordsCheck($formPassword, $dbPassword){
            
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
                    <p>
                        <?= isset($screenMessage)?"$screenMessage":"" ?>
                    </p>
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
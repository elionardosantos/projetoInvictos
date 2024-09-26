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

            $loggedUserId = $_SESSION['loggedUserId'];
            $loggedUserName = $_SESSION['loggedUserName'];
            $loggedUserEmail = $_SESSION['loggedUserEmail'];
            $loggedUserLevel = $_SESSION['loggedUserLevel'];

            // echo "Logado como $dbName pela SESSION | <a href=\"controller/logout.php\">Sair</a>";
            header('location: index.php');

        } else if((isset($_POST['email']) && $_POST['email'] !== "")){            
            $formEmail = $_POST['email'];
            $formPassword = isset($_POST['password'])?$_POST['password']:"";
            $dbReturn = dbCredentialsQuery($formEmail, $formPassword);

            if($dbReturn == 'email not found'){
                $screenMessage = "Email ou senha incorretos";
            } else {
                $dbId = $dbReturn['dbId'];
                $dbName = $dbReturn['dbName'];
                $dbEmail = $dbReturn['dbEmail'];
                $dbPassword = $dbReturn['dbPassword'];
                $dbStatus = $dbReturn['dbStatus'];
    
                // echo "$dbId, $dbName, $dbEmail, $dbPassword, $dbStatus - ";

                if(password_verify($formPassword, $dbPassword)){
                    $_SESSION['loginStatus'] = 'logged';
                    $_SESSION['loggedUserId'] = $dbId;
                    $_SESSION['loggedUserName'] = $dbName;
                    $_SESSION['loggedUserEmail'] = $dbEmail;
                    $_SESSION['loggedUserLevel'] = $dbLevel;

                    header('location: index.php');
                } else {
                    $screenMessage = "Email ou senha incorretos";
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
                    $dbStatus = $row['status'];

                    return array(
                        'dbId' => $dbId,
                        'dbName' => $dbName,
                        'dbEmail' => $dbEmail,
                        'dbPassword' => $dbPassword,
                        'dbStatus' => $dbStatus
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
                    <span class="text-danger"><?= isset($screenMessage)?"$screenMessage":"" ?></span><br><br>
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
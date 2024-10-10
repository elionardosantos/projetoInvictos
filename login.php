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
            $formPasswordHash = hash('sha256',$formPassword);
            $dbReturn = dbCredentialsQuery($formEmail);

            if($dbReturn == 'email not found'){
                $screenMessage = "<div class=\"alert alert-danger\">Email ou senha incorretos</div>";
                $errorFormStyle = "is-invalid";
            } else {
                $dbId = isset($dbReturn['dbId'])?$dbReturn['dbId']:'';
                $dbName = isset($dbReturn['dbName'])?$dbReturn['dbName']:'';
                $dbEmail = isset($dbReturn['dbEmail'])?$dbReturn['dbEmail']:'';
                $dbPassword = isset($dbReturn['dbPassword'])?$dbReturn['dbPassword']:'';
                $dbLevel = isset($dbReturn['dbLevel'])?$dbReturn['dbLevel']:'';
    
                // echo "$dbId, $dbName, $dbEmail, $dbPassword, $dbLevel - ";

                if($formPasswordHash === $dbPassword){
                    $_SESSION['loginStatus'] = 'logged';
                    $_SESSION['loggedUserId'] = $dbId;
                    $_SESSION['loggedUserName'] = $dbName;
                    $_SESSION['loggedUserEmail'] = $dbEmail;
                    $_SESSION['loggedUserLevel'] = $dbLevel;

                    header('location: index.php');
                } else {
                    $screenMessage = "<div class=\"alert alert-danger\">Email ou senha incorretos</div>";
                    $errorFormStyle = "is-invalid";
                    $_SESSION['loginStatus'] = 'unlogged';
                }
            }

            // echo "Logado pelo POST | <a href=\"controller/logout.php\">Sair</a>";
                
        } else {
            // echo "Ninguém logado";
        }

        function dbCredentialsQuery($formEmail){

            require('config/connection.php');
            
            $sql = "SELECT * FROM `users` WHERE `email` = :email AND `active` = 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email',$formEmail);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if($result) {
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

    ?>
    <div class="bg-secondary">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="col-md-4 border p-4 rounded bg-dark text-white">
                <h3 class="text-center mb-4">Login</h3>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input autofocus required type="email" class="form-control <?= $errorFormStyle ?>" name="email" id="email" placeholder="Digite seu e-mail">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input required type="password" class="form-control <?= $errorFormStyle ?>" name="password" id="password" placeholder="Digite sua senha">
                    </div>
                    <p>
                        <?= isset($screenMessage)?"$screenMessage":"" ?>
                        <!-- <span class="text-danger">Texto de teste</span> -->
                    </p>
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
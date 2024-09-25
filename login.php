<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Login</title>
</head>
<body>
    <?php
        session_start();

        // if(isset($_SESSION['email']) && $_SESSION['email'] !== ""){
        //     global $dbName;
        //     $formEmail = $_SESSION['email'];
        //     $formPassword = isset($_SESSION['password'])?$_SESSION['password']:"";
        //     echo "Logado como $dbName pela SESSION | <a href=\"controller/logout.php\">Sair</a>";
        //     dbCredentialsRequest();
        //     // header('location: index.php');
            
        // } else 
        if((isset($_POST['email']) && $_POST['email'] !== "")){            
            $formEmail = $_POST['email'];
            $formPassword = isset($_POST['password'])?$_POST['password']:"";
            
            $dbReturn = dbCredentialsQuery($formEmail, $formPassword);
            $dbPassword = $dbReturn['dbPassword'];

            $dbName = $dbReturn['dbName'];
            $dbEmail = $dbReturn['dbEmail'];
            $dbPassword = $dbReturn['dbPassword'];
            $dbStatus = $dbReturn['dbStatus'];

            echo "$dbName, $dbEmail, $dbPassword, $dbStatus";


            // echo password_verify($formPassword, $dbPassword);

            // $user = $dbReturn['dbName'];
            
            echo "Logado pelo POST | <a href=\"controller/logout.php\">Sair</a>";
            // header('location: index.php');
                
        } else {
            echo "Ninguém logado";
        }

        function dbCredentialsQuery($formEmail, $formPassword){

            require('config/connection.php');
            
            $sql = "SELECT * FROM `users` WHERE `email` = \"$formEmail\"";
            $result = mysqli_query($conn, $sql);
            
            if($result-> num_rows > 0) {
                foreach ($result as $row) {
                                       
                    $dbName = $row['name'];
                    $dbEmail = $row['email'];
                    $dbPassword = $row['password'];
                    $dbStatus = $row['status'];

                    return array(
                        'dbName' => $dbName,
                        'dbEmail' => $dbEmail,
                        'dbPassword' => $dbPassword,
                        'dbStatus' => $dbStatus
                    );
                }
            } else {
                return array(
                    'dbName' => "",
                    'dbEmail' => "",
                    'dbPassword' => "",
                    'dbStatus' => ""
                );
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
                    <span class="text-danger"><?= isset($message)?"$message":"" ?></span><br><br>
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
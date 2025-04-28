<?php

$client_id = isset($_GET['client_id'])?$_GET['client_id']:"";
$client_secret = isset($_GET['client_secret'])?$_GET['client_secret']:"";

$new_data = array(
    'client_id'=>$client_id,
    'client_secret'=>$client_secret
);

$new_json_data = json_encode($new_data);
$jsonFile = 'config/credentials.json';
$result = file_put_contents($jsonFile,$new_json_data);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2>Início</h2>
        <p>
        <?php
            if($result !== false){
                echo "<div class='alert alert-success'>Credenciais atualizadas</div>";
            } else {
                echo "<div class='alert alert-danger'>Credenciais não atualizadas. Favor consulte um administrador do sistema.</div>";
            }
        ?>
        
        <a href="index.php" class="btn btn-primary mt-2" role="button">Início</a>

        <div class="mt-5">
            <a class="btn btn-success" href="https://www.bling.com.br/Api/v3/oauth/authorize?response_type=code&client_id=f243f57a4d02fb4926f8c661da4a7d4da88c56c5&state=1234">Conectar ao Bling</a>
        </div>
        </p>

    </div>
</body>
</html>
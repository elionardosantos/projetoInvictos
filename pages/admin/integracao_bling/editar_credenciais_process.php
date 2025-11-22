<?php

$client_id = isset($_POST['client_id'])?$_POST['client_id']:"";
$client_secret = isset($_POST['client_secret'])?$_POST['client_secret']:"";
$reconnect_url = isset($_POST['reconnect_url'])?$_POST['reconnect_url']:"";

$new_data = array(
    'client_id'=>$client_id,
    'client_secret'=>$client_secret,
    'reconnect_url'=>$reconnect_url
);

$new_json_data = json_encode($new_data);
$jsonFile = __DIR__ . '/../../../config/credentials.json';
$result = file_put_contents($jsonFile,$new_json_data);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Credenciais Bling</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../../../controller/login_checker.php');
        require(__DIR__ . '/../../../partials/navbar.php');
        require(__DIR__ . '/../../../controller/only_level_2.php');

    ?>
    <div class="container my-3">
        <h2>Credenciais Bling</h2>
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
            <a class="btn btn-success" href="<?= $reconnect_url ?>">Conectar ao Bling</a>
        </div>
        </p>

    </div>
</body>
</html>
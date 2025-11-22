<?php

$host = isset($_POST['db_host']) ? $_POST['db_host'] : "";
$dbname = isset($_POST['db_name']) ? $_POST['db_name'] : "";
$username = isset($_POST['db_username']) ? $_POST['db_username'] : "";
$password = isset($_POST['db_password']) ? $_POST['db_password'] : "";

$new_data = array(
    'host'=>$host,
    'dbname'=>$dbname,
    'username'=>$username,
    'password'=>$password
);

$new_json_data = json_encode($new_data);
$jsonFile = __DIR__ . '/../../../config/db_connection.json';
$result = file_put_contents($jsonFile,$new_json_data);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Configurar conexão com o banco de dados</title>
</head>
<body>
    <div class="container my-3">
        <h2>Configurar conexão com o banco de dados</h2>
        <p>
        <?php
            if($result !== false){
                echo "<div class='alert alert-success'>Credenciais atualizadas</div>";
            } else {
                echo "<div class='alert alert-danger'>Houve um erro ao atualizar as credenciais. Favor consulte um administrador do sistema.</div>";
            }
        ?>
        
        <a href="/index.php" class="btn btn-primary mt-2" role="button">Início</a>

        </p>

    </div>
</body>
</html>
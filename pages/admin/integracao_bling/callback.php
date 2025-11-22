<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../../../controller/login_checker.php');
        require(__DIR__ . '/../../../partials/navbar.php');
        require(__DIR__ . '/../../../controller/only_level_2.php');
    ?>
    <div class="container my-3">
        <h2>Integração com o Bling</h2>
        
        <?php
        require(__DIR__ . '/../../../controller/token_request.php');
        $data = json_decode($response, true);

        if(isset($data['access_token'])){
            echo "<div class='alert alert-success mt-3'>Conexão realizada com sucesso!</div>";
            // echo $response;
            // header('location: index.php');
        } else {
            echo "<div class='alert alert-danger'>Houve um erro na conexão.</div>";
        }
        ?>

        
        <a href="/index.php" class="btn btn-primary mt-2" role="button">Início</a>

    </div>
</body>
</html>


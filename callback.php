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
        require('controller/only_level_2.php');
    ?>
    <div class="container my-3">
        <h2>Integração com o Bling</h2>
        
        <?php
        require('controller/token_request.php');
        $data = json_decode($response, true);

        if(isset($data['access_token'])){
            echo "<div class='alert alert-success mt-3'>Conexão realizada com sucesso!</div>";
            // echo $response;
            // header('location: index.php');
        } else {
            echo "<div class='alert alert-danger'>Houve um erro na conexão.</div>";
        }
        ?>

    </div>
</body>
</html>


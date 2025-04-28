<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Credenciais do Bling</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');
        
        $jsonFile = file_get_contents('config/credentials.json');
        $jsonData = json_decode($jsonFile, true);

        $client_id = isset($jsonData['client_id'])?$jsonData['client_id']:"";
        $client_secret = isset($jsonData['client_secret'])?$jsonData['client_secret']:"";

        // echo $client_id . " " . $client_secret;

        $linkDeConviteBling = "";
    ?>
    <div class="container my-3">
        <h2>Credenciais do Bling</h2>
    </div>
    <div class="container">
        <form action="editar_credenciais_process.php" method="GET">
            <div class="form-group mt-4">
                <label for="client_id">Client ID</label>
                <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Digite o Client ID" required value="<?= $client_id ?>">
            </div>
            <div class="form-group mt-4">
                <label for="secret_id">Secret ID</label>
                <input type="text" class="form-control" id="client_secret" name="client_secret" placeholder="Digite o Client Secret" required value="<?= $client_secret ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4">Enviar</button>
        </form>

    </div>
</body>
</html>
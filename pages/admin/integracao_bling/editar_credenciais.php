<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Credenciais do Bling</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../../../controller/login_checker.php');
        require(__DIR__ . '/../../../partials/navbar.php');
        require(__DIR__ . '/../../../controller/only_level_2.php');
        
        $jsonFile = file_get_contents(__DIR__ . '/../../../config/credentials.json');
        $jsonData = json_decode($jsonFile, true);

        $client_id = isset($jsonData['client_id'])?$jsonData['client_id']:"";
        $client_secret = isset($jsonData['client_secret'])?$jsonData['client_secret']:"";
        $reconnect_url = isset($jsonData['reconnect_url'])?$jsonData['reconnect_url']:"";

        // echo $client_id . " " . $client_secret;

        $linkDeConviteBling = "";
    ?>
    <div class="container my-5">
        <h2>Credenciais do Bling</h2>
    </div>
    <div class="container my-5">
        Passo 1 - 
        <a target="_blank" href="https://www.bling.com.br/cadastro.aplicativos.php">Clique aqui</a> e selecione o app do Bling correspondente a este sistema. Se não houver, crie um.
    </div>
    <div class="container my-5">
        Passo 2 - 
        Copie o link abaixo e cole em link de redirecionamento no app do bling
        <br>
        <?php $link = $_SERVER['HTTP_HOST'] . "/pages/admin/integracao_bling/callback.php" ?>    
        <input class="form-control" type="text" name="" id="" value="<?= "http://" . $link ?>">
    </div>
    <div class="container my-5">
        Passo 3 - 
        Na aba "Informações do app", copie os dados e cole no formulário abaixo.
    </div>
    <div class="container mt-5">
        <form action="editar_credenciais_process.php" method="POST">
            <div class="form-group mt-4">
                <label for="client_id">Client ID</label>
                <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Digite o Client ID" required value="<?= $client_id ?>">
            </div>
            <div class="form-group mt-4">
                <label for="secret_id">Secret ID</label>
                <input type="password" class="form-control" id="client_secret" name="client_secret" placeholder="Digite o Client Secret" required value="<?= $client_secret ?>">
            </div>
            <div class="form-group mt-4">
                <label for="client_id">Link de convite Bling.</label>
                <input type="text" class="form-control" id="reconnect_url" name="reconnect_url" placeholder="URL de reconexão com o Bling" required value="<?= $reconnect_url ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4 mb-5">Enviar</button>
        </form>

    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Conexão com o BD</title>
</head>
<body>
    <?php
        
        $jsonFile = file_get_contents(__DIR__ . '/../../../config/db_connection.json');
        $jsonData = json_decode($jsonFile, true);

        $host = isset($jsonData['host'])?$jsonData['host']:"";
        $dbname = isset($jsonData['dbname'])?$jsonData['dbname']:"";
        $username = isset($jsonData['username'])?$jsonData['username']:"";
        $password = isset($jsonData['password'])?$jsonData['password']:"";

        // echo $client_id . " " . $client_secret;

        $linkDeConviteBling = "";
    ?>
    <div class="container my-3">
        <h2>Configurar conexão com o banco de dados</h2>
    </div>
    <div class="container">
        <form action="configuracao_inicial_process.php" method="POST">
            <div class="form-group mt-4">
                <label for="client_id">Host</label>
                <input type="text" class="form-control" id="db_host" name="db_host" placeholder="Digite o host do banco de dados" required value="<?= $host ?>">
            </div>
            <div class="form-group mt-4">
                <label for="secret_id">Nome do banco de dados</label>
                <input type="text" class="form-control" id="db_name" name="db_name" placeholder="Digite o nome do banco de dados" required value="<?= $dbname ?>">
            </div>
            <div class="form-group mt-4">
                <label for="secret_id">Nome de usuário</label>
                <input type="text" class="form-control" id="db_username" name="db_username" placeholder="Digite o nome de usuário" required value="<?= $username ?>">
            </div>
            <div class="form-group mt-4">
                <label for="secret_id">Senha de usuário</label>
                <input type="password" class="form-control" id="db_password" name="db_password" placeholder="Digite a senha do banco de dados" required value="<?= $password ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4">Salvar</button>
        </form>

    </div>
</body>
</html>
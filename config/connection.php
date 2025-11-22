<?php
//######## MySql database ########

$jsonFile = json_decode(file_get_contents(__DIR__ . '/db_connection.json'));

if(
    isset($jsonFile->host) && $jsonFile->host !== "" &&
    isset($jsonFile->dbname) && $jsonFile->dbname !== "" &&
    isset($jsonFile->username) && $jsonFile->username !== "" &&
    isset($jsonFile->password) && $jsonFile->password !== ""
){
    $host = $jsonFile->host;
    $dbname = $jsonFile->dbname;
    $username = $jsonFile->username;
    $password = $jsonFile->password;
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Successfully connected!";
    } catch (PDOException $e) {
        ?>
            <div class="container mt-4">
                <?= "Falha na conexão: " . $e->getMessage(); ?>

            </div>
            <div class="container mt-2">
                <a href="/pages/admin/database/configuracao_inicial.php" class="btn btn-primary mt-2" role="button">Configurar conexão com banco de dados</a>
            </div>
        <?php
        die;
    }

} else {
    header("location: /pages/admin/database/configuracao_inicial.php");
}


?>
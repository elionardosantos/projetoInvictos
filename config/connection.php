<?php
//######## MySql database ########
$host = 'localhost';
$dbname = 'invictos';
$username = 'root';
$password = '';

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     // echo "Successfully connected!";
// } catch (PDOException $e) {
//     echo "Falha na conexão: " . $e->getMessage();
// }


######## SQLite database ########
try {
    $pdo = new PDO("sqlite:database.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}

?>
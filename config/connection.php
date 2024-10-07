<?php

// $host = '50.6.138.176';
// $port = 3306;
// $dbname = 'thinfo36_Tests';
// $user = 'thinfo36_elionardosantos';
// $password = 'Novasenha@2024';

// // Criar conexão
// $conn = new mysqli($host, $user, $password, $dbname, $port);

// // Verificar a conexão
// if ($conn->connect_error) {
//     die('Falha na conexão com o banco de dados: ' . $conn->connect_error);
// } else {
//     //echo 'Conexão bem-sucedida!';
// }


$host = 'localhost';
$port = 3306;
$dbname = 'invictos';
$user = 'root';
$password = '';

// Criar conexão
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Verificar a conexão
if ($conn->connect_error) {
    die('Falha na conexão com o banco de dados: ' . $conn->connect_error);
} else {
    //echo 'Conexão bem-sucedida!';
}
?>
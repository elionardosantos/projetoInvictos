<?php

$host = '';
$port = 3306;
$dbname = '';
$user = '';
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
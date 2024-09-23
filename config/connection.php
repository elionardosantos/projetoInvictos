<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'invictos';

// Criar conexão
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die('Falha na conexão: ' . $conn->connect_error);
} else {
    echo 'Conexão bem-sucedida!';
}

?>

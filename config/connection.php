<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'invictos';

// Criar conexão
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die('Falha na conexão com o banco de dados: ' . $conn->connect_error);
} else {
    //echo 'Conexão bem-sucedida!';
}

// Sempre fechar a conexão
//$conn->close();
?>

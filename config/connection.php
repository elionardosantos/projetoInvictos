<?php

// Connect to the SQLite database
try {
    $pdo = new PDO("sqlite:database.db");
    // Configurar o PDO para lançar exceções em caso de erro
    // 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "<div>Successfully connected to the database</div>";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}

// Criar uma tabela chamada 'users'
$sql = "CREATE TABLE IF NOT EXISTS users (
    `id` INT PRIMARY KEY AUTOINCREMENT,
    `name` VARCHAR NOT NULL,
    `email` TEXT NOT NULL UNIQUE,
    `level` INT NOT NULL,
    `active` INT NOT NULL,
    `password` VARCHAR NOT NULL
)";

$pdo->exec($sql);

?>
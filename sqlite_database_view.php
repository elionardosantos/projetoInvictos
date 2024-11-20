<?php
######## SQLite database ########
try {
    $pdo = new PDO("sqlite:database.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}

$sql = "create table itens";

$stmt = $pdo->query($sql);
// $stmt->execute();

// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


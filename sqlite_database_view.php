<?php
######## SQLite database ########
try {
    $pdo = new PDO("sqlite:database.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}

$sql = "";

$stmt = $pdo->query($sql);

print_r($stmt);

// $stmt->execute();

// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


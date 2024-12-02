<?php
require('config/connection.php');

$produtosSelecionados = [36,32,35];

$virgula = "";
$itens = "";
$placeholders = "";
$index = 0;
foreach($produtosSelecionados as $item){
    $itens .= $virgula.$item;
    $placeholders .= $virgula.":".$index;
    $virgula = ",";
    $index ++;
}

$sql = "SELECT `id`,`codigo`,`peso` FROM `produtos` WHERE `codigo` IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$index = 0;
foreach($produtosSelecionados as $item){
    $stmt->bindValue(":$index", $item, PDO::PARAM_INT);
    $index ++;
}
$stmt->execute();

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($resultado as $item){
    $listaItens[$item['codigo']]['peso'] = $item['peso'];
}

print_r($listaItens);


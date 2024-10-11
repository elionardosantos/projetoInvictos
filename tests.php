<?php
require('config/connection.php');

$sql = "ALTER TABLE `users` DROP CONSTRAINT 'UNIQUE'";
$pdo->query($sql);


$sql2 = "SELECT * FROM `users`";
$stmt = $pdo->query($sql2);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($result);
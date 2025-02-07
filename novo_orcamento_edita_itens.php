<?php
require('controller/login_checker.php');
require('config/connection.php');   
date_default_timezone_set('America/Sao_Paulo');

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Selecionar itens</title>
</head>
<body>

<?php
require('partials/navbar.php');




echo "<pre>";
print_r($_SESSION);
echo "</pre>";
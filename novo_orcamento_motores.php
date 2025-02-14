<?php
date_default_timezone_set('America/Sao_Paulo');
require('controller/login_checker.php');
require('config/connection.php');   
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
</head>
<body>
<?php
    require('partials/navbar.php');
    
    if(isset($_SESSION['array_com_produtos'])){

    }
?>

<p><a href="novo_orcamento_itens.php">Voltar para itens</a></p>
---------------------------- Conteúdo do $_SESSION ----------------------------
<pre>
<?php print_r($_SESSION); ?>
</pre>


</body>
</html>
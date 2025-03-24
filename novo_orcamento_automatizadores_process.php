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

    $_SESSION['automatizadorSelecionado'][] = $_POST['automatizadorSelecionado'];

    header("location: novo_orcamento_process.php");

    // echo "<p><a href=\"novo_orcamento_process.php\">Continuar</a></p>";
    // echo "<pre>";
    // echo "POST:";
    // print_r($_POST);
    // echo "SESSION:";
    // print_r($_SESSION);
?>




</body>
</html>
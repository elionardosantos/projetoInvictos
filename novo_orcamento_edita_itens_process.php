<?php
require('controller/login_checker.php');
require('config/connection.php');   
date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Editar itens</title>
</head>
<body>
<?php



?>

<pre>
    <?php
        print_r($_POST);
        print_r($_SESSION['array_com_produtos']);

        echo "<p>------------- Array alterada ----------------</p>";

        print_r($_SESSION['array_com_produtos_atualizada']);
    ?>
</pre>

</body>
</html>
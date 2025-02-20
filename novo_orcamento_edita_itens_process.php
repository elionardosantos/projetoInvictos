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
    $_SESSION['array_com_produtos_atualizados'] = $_SESSION['array_com_produtos'];

    //Cancelando a seleção de todos os itens da array
    foreach($_SESSION['array_com_produtos_atualizados'] as $produto){
        $codigo = $produto['codigo'];
        $_SESSION['array_com_produtos_atualizados'][$codigo]['selecionado'] = 0;
    }


    //Selecionando somente os itens que vieram do formulário via POST
    foreach($_POST['produtosSelecionados'] as $produto){
        $_SESSION['array_com_produtos_atualizados'][$produto]['selecionado'] = 1;
    }

    $_SESSION['array_com_produtos'] = $_SESSION['array_com_produtos_atualizados'];

    header('location: novo_orcamento_itens.php');

?>

<!-- <pre>
    <?php
        print_r($_POST);
        // print_r($_SESSION['array_com_produtos']);

        echo "<p>------------- Array alterada ----------------</p>";

        print_r($_SESSION['array_com_produtos_atualizados']);
    ?>
</pre> -->

</body>
</html>
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

echo '<p>###########################################</p>';

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

?>
</body>
</html>
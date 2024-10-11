<?php
    if($_SESSION['loggedUserLevel'] < 2){
        echo "<center><p>Você não tem permissão para acessar esta página</p></center>";
        die();
    }
?>
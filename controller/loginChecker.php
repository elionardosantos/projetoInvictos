<?php
    session_start();
    
    if(isset($_SESSION['loginStatus']) && $_SESSION['loginStatus'] === "logged"){
        //Verifica se o usuário está ativo
        if($_SESSION['loggedUserLevel'] < 1){
            echo "<center><p>Seu usuário está inativo. Contate um administrador do sistema | <a href=\"controller/logout.php\">Sair</a></p></center>";
            die();
        }
    } else {
        header('location: login.php');
    }
?>
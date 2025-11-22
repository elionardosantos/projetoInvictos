<?php
    session_start();
    
    if(isset($_SESSION['login']['loginStatus']) && $_SESSION['login']['loginStatus'] === "logged"){
        //Verifica se o usuário está ativo
        if($_SESSION['login']['loggedUserLevel'] < 1){
            die("<center><p>Seu usuário está inativo. Contate um administrador do sistema | <a href=\"/controller/logout.php\">Sair</a></p></center>");
        }
    } else {
        header('location: /login.php');
    }
?>
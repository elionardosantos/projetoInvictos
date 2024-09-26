<?php
    session_start();
    
    if (isset($_SESSION['loginStatus']) && $_SESSION['loginStatus'] === "logged"){
        //Mantém logado
    } else {
        header('location: login.php');
    }
?>
<?php
    session_start();

    if (isset($_SESSION['email']) && $_SESSION['email'] !== "") {
        echo "Logado pelo POST";

    } else {
        echo "Ninguém logado";
        header('location: login.php');
    }
?>
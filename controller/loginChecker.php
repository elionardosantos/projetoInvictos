<?php
    session_start();

    if (isset($_SESSION['email']) && $_SESSION['email'] !== "") {
        // $loggedUser = $_SESSION['email'];
        checkUserCredentials();

    } else if (isset($_POST['email']) && $_POST['email'] !== "") {
        // echo '<div class="alert alert-danger">Digite o usuário e senha para acessar</div>';

    } else {
        // require('partials/loginForm.php');
        header('login.php');
        // echo "<center>Fazer login</center>";
        // die();
    }

    function checkUserCredentials() {
        $userEmail = $_POST['email'];
        $userPass = $_POST['pass'];
        
        
    }

    function loggedUser() {
        $loggedUser = $_SESSION['user'];
        return "$loggedUser";
    }
?>
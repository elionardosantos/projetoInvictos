<?php
    session_start();

    if (isset($_SESSION['email']) && $_SESSION['email'] !== "") {
        $loggedUser = $_SESSION['email'];

    } else if (isset($_POST['email']) && $_POST['email'] !== "") {
        loginUser();
        loggedUser();

    } else {
        // require('partials/loginForm.php');
        // header('login.php');
        // echo "<center>Fazer login</center>";
        // die();
    }

    function loginUser() {
        $emailForm = $_POST['email'];
        $passForm = $_POST['pass'];
        
        $jsonFile = file_get_contents('configs/login.json');
        $jsonData = json_decode($jsonFile, true);

        if(isset($jsonData["$emailForm"]) && ($jsonData["$emailForm"]["senha"] === $passForm)) {
            $_SESSION['email'] = $emailForm;
            $_SESSION['user'] = $jsonData["$emailForm"]["nome"];
        } else {
            $loginMessage = "Email ou senha incorretos.";
            require('partials/loginForm.php');
            die();
        }
    }

    function loggedUser() {
        $loggedUser = $_SESSION['user'];
        return "$loggedUser";
    }
?>
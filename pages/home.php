<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../partials/head.php'); ?>
    <title>Home</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../controller/login_checker.php');
        require(__DIR__ . '/../partials/navbar.php');

        $day = date('d');
        $month = date('m');
        $year = date('Y');
        $weekDay = date('w');
        switch($month){
            case 1: $month = "janeiro"; break;
            case 2: $month = "fevereiro"; break;
            case 3: $month = "março"; break;
            case 4: $month = "abril"; break;
            case 5: $month = "maio"; break;
            case 6: $month = "junho"; break;
            case 7: $month = "julho"; break;
            case 8: $month = "agosto"; break;
            case 9: $month = "setembro"; break;
            case 10: $month = "outubro"; break;
            case 11: $month = "novembro"; break;
            case 12: $month = "dezembro"; break;
        }
        switch($weekDay){
            case 0: $weekDay = "Domingo"; break;
            case 1: $weekDay = "Segunda-feira"; break;
            case 2: $weekDay = "Terça-feira"; break;
            case 3: $weekDay = "Quarta-feira"; break;
            case 4: $weekDay = "Quinta-feira"; break;
            case 5: $weekDay = "Sexta-feira"; break;
            case 6: $weekDay = "Sábado"; break;
        }
    ?>

    <div class="container mt-4">
        <h5>
            Olá <?= $_SESSION['login']['loggedUserName'] ?>! Hoje é <?= $weekDay ?>, <?= $day ?> de <?= $month ?> de <?= $year ?>.
        </h5>
    </div>

</body>
</html>
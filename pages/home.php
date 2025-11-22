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
    <div class="container mt-3">
        <div id="ww_664f84fbe6e12" v='1.3' loc='id' a='{"t":"responsive","lang":"pt","sl_lpl":1,"ids":["wl4958"],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","cl_odd":"#0000000a"}'>Mais previsões: <a href="https://tempolongo.com/rio_de_janeiro_tempo_25_dias/" id="ww_664f84fbe6e12_u" target="_blank">30 day weather forecast Rio de Janeiro</a></div><script async src="https://app3.weatherwidget.org/js/?id=ww_664f84fbe6e12"></script>    
    </div>

    
    
        

</body>
</html>
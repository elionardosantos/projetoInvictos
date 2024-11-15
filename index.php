<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2>Início</h2>
        <p>
        <?php
            date_default_timezone_set('America/Sao_Paulo');
            echo $dataHoraAtual = date('d/m/Y');
        ?>
        </p>

        <!-- <div id="ww_f400bb6604242" v='1.3' loc='auto' a='{"t":"responsive","lang":"pt","sl_lpl":1,"ids":[],"font":"Arial","sl_ics":"one_a","sl_sot":"celsius","cl_bkg":"#FFFFFF00","cl_font":"#000000","cl_cloud":"#d4d4d4","cl_persp":"#2196F3","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","cl_odd":"#00000000"}'>Mais previsões: <a href="https://oneweather.org/pt/lisbon/25_days/" id="ww_f400bb6604242_u" target="_blank">Meteorologia 25 dias</a></div><script async src="https://app3.weatherwidget.org/js/?id=ww_f400bb6604242"></script> -->
    </div>
</body>
</html>
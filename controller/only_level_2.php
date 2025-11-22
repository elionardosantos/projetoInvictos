<?php
    if($_SESSION['login']['loggedUserLevel'] < 2){
        die("<center><p>Você não tem permissão para acessar esta página</p></center>");
    }
?>
<script>
    document.querySelector("body > nav").style = "background-color: #1d2935 !important"
</script>
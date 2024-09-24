<?php
    echo "<p>Saindo...</p>";
    session_start();
    session_destroy();
    header('location: ../index.php')
?>
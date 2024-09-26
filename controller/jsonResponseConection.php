<?php
    $jsonFile = file_get_contents("config/tokenRequestResponse.json");
    $jsonData = [];
    $jsonData = json_decode($jsonFile, true);

    echo $jsonFile;
    
?>
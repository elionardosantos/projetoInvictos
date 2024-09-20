<?php
    $jsonFile = file_get_contents("tokenRequestResponse.json");
    $jsonData = [];
    $jsonData = json_decode($jsonFile);

    echo $jsonFile;
    echo $jsonData['access_token'];

?>
<?php
$jsonFile = file_get_contents('config/credentials.json');
$jsonData = json_decode($jsonFile, true);

$client_id = isset($jsonData['client_id'])?$jsonData['client_id']:"";
$client_secret = isset($jsonData['client_secret'])?$jsonData['client_secret']:"";

echo $client_id . " " . $client_secret;
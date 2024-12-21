<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.bling.com.br/Api/v3/pedidos/vendas/<integer>',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'[postfields]',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: ••••••'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

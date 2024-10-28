<?php

$state = "SP";

$estados = [
    "SP", "RJ", "MG", "ES", 
    "AC", "AL", "AP", "AM", 
    "BA", "CE", "DF", "GO", 
    "MA", "MT", "MS", "PA", 
    "PB", "PR", "PE", "PI", 
    "RN", "RS", "RO", "RR", 
    "SC", "SE", "TO"
];

foreach($estados as $uf){
    echo "<option value=\"$uf\" <?php if(isset($state) && $state === '$uf') {echo 'selected';} ?>>$uf</option>\n";
}
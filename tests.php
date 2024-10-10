<?php

// echo "<div>Running...</div>";
require('config/connection.php');


$formEmail = 'elionars@gmail.co';

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email',$formEmail);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// echo $result->rowCount();

if($result) {
    echo "Maior"; 
} else {
    echo "Menor";
}


?>
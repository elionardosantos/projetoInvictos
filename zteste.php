<?php
require('partials/head.php');
require('config/connection.php');

echo "<br>";

$altura = floatVal(isset($_GET['altura'])?$_GET['altura']:"");
$largura = floatVal(isset($_GET['largura'])?$_GET['largura']:"");
// $peso = floatVal(isset($_GET['peso'])?$_GET['peso']:"");

if($altura !== "" && $largura !== ""){
    if($altura !== 0 && $largura !== 0){
        $sql = "SELECT * FROM produtos
                WHERE altura_minima <= $altura
                AND altura_maxima > $altura
                AND largura_minima <= $largura
                AND largura_maxima > $largura
                ";
                // AND peso_minimo <= $peso
                // AND peso_maximo > $peso
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Dados inválidos";
    }
} else {
    echo "Digite os dados";
}

?>
<head>
    <title>zTeste</title>
</head>
<form>
    <input type="text" id="altura" name="altura" placeholder="altura" autofocus>
    <input type="text" id="largura" name="largura" placeholder="largura">
    <!-- <input type="text" step="0.01" id="peso" name="peso" placeholder="peso"> -->
    <button type="submit">Enviar</button>
</form>
<?php
echo "Altura: " . $altura;
echo " / Largura: " . $largura;
// echo " / Peso: " . $peso;
?>
<div class="mt-4">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th>Referencia</th>
                <th>Titulo</th>
                <th>Peso</th>
                <th>Cons</th>
                <th>Mult</th>
                <th>Alt Min</th>
                <th>Alt Max</th>
                <th>Lar Min</th>
                <th>Lar Max</th>
                <th>Peso Min</th>
                <th>Peso Max</th>
                <th>Selec</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($resultado as $row){
                    $id = isset($row['id'])?$row['id']:"";
                    $codigo = isset($row['codigo'])?$row['codigo']:"";
                    $titulo = isset($row['titulo'])?$row['titulo']:"";
                    $peso = isset($row['peso'])?$row['peso']:"";
                    $consumo = isset($row['consumo'])?$row['consumo']:"";
                    $multiplicador = isset($row['multiplicador'])?$row['multiplicador']:"";
                    $alturaMinima = isset($row['altura_minima'])?$row['altura_minima']:"";
                    $alturaMaxima = isset($row['altura_maxima'])?$row['altura_maxima']:"";
                    $larguraMinima = isset($row['largura_minima'])?$row['largura_minima']:"";
                    $larguraMaxima = isset($row['largura_maxima'])?$row['largura_maxima']:"";
                    $pesoMinimo = isset($row['peso_minimo'])?$row['peso_minimo']:"";
                    $pesoMaximo = isset($row['peso_maximo'])?$row['peso_maximo']:"";
                    $selecionado = isset($row['selecionado'])?$row['selecionado']:"";

                echo "<tr>";
                echo "    <td>$codigo</td>";
                echo "    <td>$titulo</td>";
                echo "    <td>$peso</td>";
                echo "    <td>$consumo</td>";
                echo "    <td>$multiplicador</td>";
                echo "    <td>$alturaMinima</td>";
                echo "    <td>$alturaMaxima</td>";
                echo "    <td>$larguraMinima</td>";
                echo "    <td>$larguraMaxima</td>";
                echo "    <td>$pesoMinimo</td>";
                echo "    <td>$pesoMaximo</td>";
                echo "    <td>$selecionado</td>";
                echo "</tr>";
            
                }
            ?>
        </tbody>
    </table>
</div>
<div class="container mt-5">
<?php
    if($altura !== "" && $largura !== ""){
        $m2 = (($altura) * $largura);
    }
    
    $pesoTotal = 0;
    echo "<p>";
    foreach($resultado as $row){
        echo $row['codigo']." ".$row['titulo']." ".(($row['peso']*$m2)*$row['multiplicador'])."<br>";
        $pesoTotal += (($row['peso']*$m2)*$row['multiplicador']);
    }
    $sql = "SELECT * FROM produtos
        WHERE peso_minimo <= $pesoTotal
        AND peso_maximo > $pesoTotal
        ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    foreach($resultado as $row){
        echo $row['codigo']." ".$row['titulo']." ".(($row['peso']*$m2)*$row['multiplicador'])."<br>";
    }
    echo "</p>";

    echo "<br>m² = $m2" ;
    echo "<br>Peso total: $pesoTotal KG"; 

?>
</div>

<?php
require('partials/head.php');
require('config/connection.php');

echo "<br>";

$altura = isset($_GET['altura'])?floatVal(str_replace(",",".",$_GET['altura'])):"";
$largura = isset($_GET['largura'])?floatVal(str_replace(",",".",$_GET['largura'])):"";
// $peso = floatVal(isset($_GET['peso'])?$_GET['peso']:"");

if($altura !== "" && $largura !== ""){
    if($altura !== 0 && $largura !== 0){
        $sql = "SELECT * FROM produtos
                WHERE altura_minima_porta <= $altura
                AND altura_maxima_porta > $altura
                AND largura_minima_porta <= $largura
                AND largura_maxima_porta > $largura
                ";
                // AND peso_minimo <= $peso
                // AND peso_maximo > $peso
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Dimensões inválidas";
    }
} else {
    echo "Preencha as dimensões";
}

?>
<head>
    <title>zTeste</title>
</head>
<div class="container">
    <form>
        <input type="text" id="largura" name="largura" placeholder="largura" autofocus>
        <input type="text" id="altura" name="altura" placeholder="altura">
        <!-- <input type="text" step="0.01" id="peso" name="peso" placeholder="peso"> -->
        <button type="submit">Enviar</button>
    </form>
    <?php
    echo $altura !== ""?"Altura: " . $altura:"";
    echo $altura !== ""?" / Largura: " . $largura:"";
    // echo " / Peso: " . $peso;
    ?>
</div>
<!-- <div class="mt-4">
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
                if(isset($resultado) && count($resultado) > 0){
                    foreach($resultado as $row){
                        $id = isset($row['id'])?$row['id']:"";
                        $codigo = isset($row['codigo'])?$row['codigo']:"";
                        $titulo = isset($row['titulo'])?$row['titulo']:"";
                        $peso = isset($row['peso'])?$row['peso']:"";
                        $consumo = isset($row['tipo_consumo'])?$row['tipo_consumo']:"";
                        $multiplicador = isset($row['multiplicador'])?$row['multiplicador']:"";
                        $alturaMinima = isset($row['altura_minima_porta'])?$row['altura_minima_porta']:"";
                        $alturaMaxima = isset($row['altura_maxima_porta'])?$row['altura_maxima_porta']:"";
                        $larguraMinima = isset($row['largura_minima_porta'])?$row['largura_minima_porta']:"";
                        $larguraMaxima = isset($row['largura_maxima_porta'])?$row['largura_maxima_porta']:"";
                        $pesoMinimo = isset($row['peso_minimo_porta'])?$row['peso_minimo_porta']:"";
                        $pesoMaximo = isset($row['peso_maximo_porta'])?$row['peso_maximo_porta']:"";
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
                } else {
                    echo "Nenhum resultado retornado";
                }
            ?>
        </tbody>
    </table>
</div> -->
<div class="container mt-5">
<?php
    if($altura !== "" && $largura !== ""){
        $m2 = (($altura) * $largura);
    }
    
    $pesoTotalPorta = 0;
    echo "<p>";
    foreach($resultado as $row){
        echo $row['codigo']." ".$row['titulo']." ".(($row['peso']*$m2)*$row['multiplicador'])."<br>";
        $itens[] = $row['codigo'];
        $pesoTotalPorta += (($row['peso']*$m2)*$row['multiplicador']);
    }

    floatval(str_replace(",",".",$pesoTotalPorta));

    $sql = "SELECT * FROM produtos
        WHERE peso_minimo_porta <= $pesoTotalPorta
        AND peso_maximo_porta > $pesoTotalPorta
        ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    foreach($resultado as $row){
        echo $row['codigo']." ".$row['titulo']." ".(($row['peso']*$m2)*$row['multiplicador'])."<br>";
    }
    echo "</p>";

    echo "<br>m² = $m2" ;
    echo "<br>Peso total: $pesoTotalPorta KG";
?>
</div>

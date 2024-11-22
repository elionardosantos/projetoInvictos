<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
    ?>
    <div class="container my-3">
        <h2>Produtos</h2>
    </div>
    <div class="container mt-4">
        <a href="novo_produto.php" class="btn btn-primary" role="button">Novo Produto</a>
    </div>
    <div class="container mt-4">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Titulo</th>
                    <th>Peso</th>
                    <th>Consumo</th>
                    <th>Multiplicador</th>
                    <th>Altura Minima</th>
                    <th>Altura Maxima</th>
                    <th>Largura Minima</th>
                    <th>Largura Maxima</th>
                    <th>Peso Minimo</th>
                    <th>Peso Maximo</th>
                    <th>Selecionado</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require('config/connection.php');
                    $sql = "SELECT `id`,`codigo`,`titulo`,`peso`,`consumo`,`multiplicador`,`altura_minima`,`altura_maxima`,`largura_minima`,`largura_maxima`,`peso_minimo`,`peso_maximo`,`selecionado` 
                            FROM `produtos` 
                            WHERE `deleted` = :deleted";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':deleted', 0);
                    $stmt->execute();
                    
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
                    echo "    <td><a class=\"btn btn-primary btn-sm\" href=\"editar_produto.php?produto_id=$id\">editar</a></td>";
                    echo "</tr>";
                
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Produtos</title>
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
    <div class="container mt-4" style="font-size: 14px;">
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
                    $sql = "SELECT `id`,`codigo`,`titulo`,`peso`,`tipo_consumo`,`multiplicador`,`altura_minima_porta`,`altura_maxima_porta`,`largura_minima_porta`,`largura_maxima_porta`,`peso_minimo_porta`,`peso_maximo_porta`,`selecionado` 
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
                    echo "    <td><a class=\"btn btn-primary btn-sm\" href=\"editar_produto.php?produto_id=$id\">editar</a></td>";
                    echo "</tr>";
                
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
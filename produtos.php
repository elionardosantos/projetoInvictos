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
                    <th>Multiplicação</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require('config/connection.php');
                    $sql = "SELECT `id`,`referencia`,`titulo`,`peso`,`consumo`,`multiplicacao` FROM `produtos` WHERE `deleted` = :deleted";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':deleted', 0);
                    $stmt->execute();
                    
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    foreach($resultado as $row){
                        $referencia = isset($row['referencia'])?$row['referencia']:"";
                        $titulo = isset($row['titulo'])?$row['titulo']:"";
                        $peso = isset($row['peso'])?$row['peso']:"";
                        $consumo = isset($row['consumo'])?$row['consumo']:"";
                        $multiplicacao = isset($row['multiplicacao'])?$row['multiplicacao']:"";
                        $id = isset($row['id'])?$row['id']:"";
                
                    echo "<tr>";
                    echo "    <td>$referencia</td>";
                    echo "    <td>$titulo</td>";
                    echo "    <td>$peso</td>";
                    echo "    <td>$consumo</td>";
                    echo "    <td>$multiplicacao</td>";
                    echo "    <td><a href=\"editar_produto.php?produto_id=$id\">editar</a></td>";
                    echo "</tr>";
                
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
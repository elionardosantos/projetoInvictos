<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Categorias</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');
    ?>
    <div class="container my-3">
        <h2>Categorias</h2>
    </div>
    <div class="container my-3">
        <a href="nova_categoria.php" class="btn btn-primary" role="button">Cadastrar nova categoria</a>
    </div>
    <div class="container my-3">
        
        <?php 

            categsListing();
            
            function categsListing() {
                require('config/connection.php');

                $sql = "SELECT `id`,`name`,`indice`,`ativo` FROM `categorias_produtos` WHERE `deleted` = :deleted";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':deleted', 0);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                usort($result, function($a, $b) {
                    return $a['indice'] <=> $b['indice']; // Ordenação crescente pelo ID
                });

        ?>
                <div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <!-- <th scope="col">ID</th> -->
                                <th class="d-none d-sm-table-cell" scope="col">Índice</th>
                                <th scope="col">Nome</th>
                                <th class="d-none d-sm-table-cell" scope="col">Status</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    if($result) {

                                        foreach($result as $row) {
                                            $categId = $row['id'];
                                            $indice = $row['indice'];
                                            $categName = $row['name'];
                                            $categAtivo = $row['ativo'];

                                            $status = $categAtivo == 1 ? "Ativo" : "Inativo";
                                            
                                            echo "<tr>";
                                            // echo "<td>$categId</td>";
                                            echo "<td class=\"d-none d-sm-table-cell\">$indice</td>";
                                            echo "<td>$categName</td>";
                                            echo "<td class=\"d-none d-sm-table-cell\">$status</td>";
                                            echo "<td><a href=\"editar_categoria.php?id=$categId\" class=\"btn btn-primary btn-sm\">Editar</a></td>";
                                            echo "</tr>";
                                        }
                                    }
                                        
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
        <?php
        
            }
            
        ?>
    </div>
</body>
</html>
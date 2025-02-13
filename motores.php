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
        <h2>Motores</h2>
    </div>
    <div class="container mb-4">
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-3">
                    <label for="codigo_produto">Código</label>
                    <input value="<?= isset($_GET['codigo_produto'])?$_GET['codigo_produto']:null; ?>" type="text" class="form-control" name="codigo_produto" id="codigo_produto">
                </div>
                <div class="col-sm-5">
                    <label for="titulo_produto">Título</label>
                    <input value="<?= isset($_GET['titulo_produto'])?$_GET['titulo_produto']:null; ?>" type="text" class="form-control" name="titulo_produto" id="titulo_produto">
                </div>
                <div class="col-sm-4">
                    <label for="situacao">Status</label>
                    <select class="form-select" id="situacao" name="situacao">
                        <option value="">Todos</option>
                        <option <?= isset($_GET['situacao']) && $_GET['situacao'] == "1"?"selected":""; ?> value="1" >Ativo</option>
                        <option <?= isset($_GET['situacao']) && $_GET['situacao'] == "0"?"selected":""; ?> value="0">Inativo</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="classificar" class="form-label mb-0">Classificar por</label>
                    <select class="form-select" name="classificar" id="classificar">
                        <option value="codigo ASC">Código (A-Z)</option>
                        <option value="codigo DESC">Código (Z-A)</option>
                        <option value="titulo ASC">Titulo (A-Z)</option>
                        <option value="titulo DESC">Titulo (Z-A)</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <input type="submit" value="Buscar" class="btn btn-primary">
                    <a href="novo_motor.php" class="btn btn-primary ms-2" role="button">Cadastrar Novo</a>
                </div>
            </div>
        </form>
    </div>
    <div class="container mt-4" style="font-size: 14px;">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Titulo</th>
                    <th>Multiplicador</th>
                    <th>Peso Minimo</th>
                    <th>Peso Maximo</th>
                    <th>Selecionado</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require('config/connection.php');
                    $codigoProduto = isset($_GET['codigo_produto'])?$_GET['codigo_produto']:"";
                    $tituloProduto = isset($_GET['titulo_produto'])?$_GET['titulo_produto']:"";
                    $tipoConsumo = isset($_GET['tipo_consumo'])?$_GET['tipo_consumo']:"";
                    $situacaoProduto = isset($_GET['situacao']) && $_GET['situacao'] !== ""?$_GET['situacao']:"";
                    $ordem = isset($_GET['classificar'])?$_GET['classificar']:"";
                    $sql = "SELECT
                                `id`,
                                `codigo`,
                                `titulo`,
                                `multiplicador`,
                                `peso_minimo_porta`,
                                `peso_maximo_porta`,
                                `selecionado`,
                                `ativo`

                            FROM `motores`
                            WHERE `deleted` = :deleted";
                    

                    if(isset($codigoProduto) && $codigoProduto !== "") {
                        $sql .= " AND `codigo` = :codigo";
                    };
                    if(isset($tituloProduto) && $tituloProduto !== "") {
                        $sql .= " AND `titulo` LIKE :titulo";
                    };
                    if(isset($tipoConsumo) && $tipoConsumo !== "") {
                        $sql .= " AND `tipo_consumo` = :tipo_consumo";
                    };
                    if(isset($situacaoProduto) && $situacaoProduto !== "") {
                        $sql .= " AND `ativo` = :ativo";
                    };
                    if(isset($ordem) && $ordem !== ""){
                        $sql .= " ORDER BY $ordem";
                    } else {
                        $sql .= " ORDER BY codigo";
                    };

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':deleted', 0);
                    
                    if(isset($codigoProduto) && $codigoProduto !== "") {
                        $stmt->bindValue(':codigo',$codigoProduto);
                    };
                    if(isset($tituloProduto) && $tituloProduto !== "") {
                        $stmt->bindValue(':titulo',"%$tituloProduto%");
                    };
                    if(isset($situacaoProduto) && $situacaoProduto !== "") {
                        $stmt->bindValue(':ativo',$situacaoProduto);
                    };
                    if(isset($tipoConsumo) && $tipoConsumo !== "") {
                        $stmt->bindValue(':tipo_consumo',$tipoConsumo);
                    };
                    
                    
                    $stmt->execute();
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    foreach($resultado as $row){
                        $id = isset($row['id'])?$row['id']:"";
                        $codigo = isset($row['codigo'])?$row['codigo']:"";
                        $titulo = isset($row['titulo'])?$row['titulo']:"";
                        $multiplicador = isset($row['multiplicador'])?$row['multiplicador']:"";
                        $pesoMinimo = isset($row['peso_minimo_porta'])?$row['peso_minimo_porta']:"";
                        $pesoMaximo = isset($row['peso_maximo_porta'])?$row['peso_maximo_porta']:"";
                        $ativo = isset($row['ativo']) && $row['ativo'] == 1?"Ativo":"Inativo";
                        $selecionado = isset($row['selecionado']) && $row['selecionado'] === 1?"Sim":"Não";


                    echo "<tr>";
                    echo "    <td>$codigo</td>";
                    echo "    <td>$titulo</td>";
                    echo "    <td>$multiplicador</td>";
                    echo "    <td>$pesoMinimo</td>";
                    echo "    <td>$pesoMaximo</td>";
                    echo "    <td>$selecionado</td>";
                    echo "    <td>$ativo</td>";
                    echo "    <td><a class=\"btn btn-primary btn-sm\" href=\"editar_motor.php?produto_id=$id\">Editar</a></td>";
                    echo "</tr>";
                
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
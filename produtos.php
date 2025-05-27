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
        require('controller/only_level_2.php');
    ?>
    <div class="container my-3">
        <h2>Produtos</h2>
    </div>
    <div class="container mb-4">
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-3 col-lg-2">
                    <label for="codigo_produto">Código</label>
                    <input value="<?= isset($_GET['codigo_produto'])?$_GET['codigo_produto']:null; ?>" type="text" class="form-control" name="codigo_produto" id="codigo_produto">
                </div>
                <div class="col-sm-5 col-lg-4">
                    <label for="titulo_produto">Título</label>
                    <input value="<?= isset($_GET['titulo_produto'])?$_GET['titulo_produto']:null; ?>" type="text" class="form-control" name="titulo_produto" id="titulo_produto">
                </div>
                <div class="col-sm-3 col-lg-2">
                    <label for="categoria" class="form-label mb-0">Categoria</label>
                    <?php
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
                    <select class="form-select" name="categoria" id="categoria">
                        <option value="">Todos</option>
                        <?php
                            foreach ($result as $item => $value) {
                                $selected = isset($_GET['categoria']) && $_GET['categoria'] == $value['id'] ? "selected" : "";
                                $categId = $value['id'];
                                $categName = $value['name'];
                                $categIndice = $value['indice'];
                                $categAtivo  = $value['ativo'];

                                echo "\n<option $selected value=\"$categId\">$categName</option>";
                            }
                        ?>
                        
                    </select>
                </div>
                <div class="col-sm-3 col-lg-2">
                    <label for="situacao">Status</label>
                    <select class="form-select" id="situacao" name="situacao">
                        <option value="">Todos</option>
                        <option <?= isset($_GET['situacao']) && $_GET['situacao'] == "1"?"selected":""; ?> value="1" >Ativo</option>
                        <option <?= isset($_GET['situacao']) && $_GET['situacao'] == "0"?"selected":""; ?> value="0">Inativo</option>
                    </select>
                </div>
                <div class="col-sm-3 col-lg-2">
                    <label for="tipo_consumo" class="form-label mb-0">Consumo</label>
                    <select class="form-select" name="tipo_consumo" id="tipo_consumo">
                        <option value="">Todos</option>
                        <?php
                            // Opções que aparecem no select
                            $options = [
                                "Unidade"=>"unidade",
                                "Largura"=>"largura",
                                "Altura"=>"altura",
                                "Metro quadrado"=>"m2",
                                "Peso"=>"peso"
                            ];
                            foreach ($options as $option => $value) {
                                ?>
                                <option <?= isset($_GET['tipo_consumo']) && $_GET['tipo_consumo'] == $value?"selected":""; ?> value="<?=$value?>"><?= $option ?></option>
                                <?php
                            };
                        ?>
                    </select>
                </div>
                <div class="col-sm-4 col-md-3 col-lg-2">
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
                    <a href="novo_produto.php" class="btn btn-primary ms-2" role="button">Novo Produto</a>
                </div>
            </div>
        </form>
    </div>
    <div class="container mt-4">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Status</th>
                    <th>Titulo</th>
                    <th>Categoria</th>
                    <!-- <th>Peso</th> -->
                    <!-- <th>Consumo</th> -->
                    <!-- <th>Multiplicador</th> -->
                    <th>Altura Min</th>
                    <th>Altura Max</th>
                    <th>Largura Min</th>
                    <th>Largura Max</th>
                    <th>Peso Minimo</th>
                    <th>Peso Maximo</th>
                    <!-- <th>Selecionado</th> -->
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require('config/connection.php');
                    $codigoProduto = isset($_GET['codigo_produto'])?$_GET['codigo_produto']:"";
                    $tituloProduto = isset($_GET['titulo_produto'])?$_GET['titulo_produto']:"";
                    $categoriaId = isset($_GET['categoria'])?$_GET['categoria']:"";
                    $tipoConsumo = isset($_GET['tipo_consumo'])?$_GET['tipo_consumo']:"";
                    $situacaoProduto = isset($_GET['situacao']) && $_GET['situacao'] !== ""?$_GET['situacao']:"";
                    $ordem = isset($_GET['classificar'])?$_GET['classificar']:"";
                    $sql = "SELECT
                                `id`,
                                `codigo`,
                                `titulo`,
                                `categoria`,
                                `peso`,
                                `tipo_consumo`,
                                `multiplicador`,
                                `altura_minima_porta`,
                                `altura_maxima_porta`,
                                `largura_minima_porta`,
                                `largura_maxima_porta`,
                                `peso_minimo_porta`,
                                `peso_maximo_porta`,
                                `selecionado`,
                                `ativo`

                            FROM `produtos`
                            WHERE `deleted` = :deleted";
                    

                    if(isset($codigoProduto) && $codigoProduto !== "") {
                        $sql .= " AND `codigo` = :codigo";
                    };
                    if(isset($tituloProduto) && $tituloProduto !== "") {
                        $sql .= " AND `titulo` LIKE :titulo";
                    };
                    if(isset($categoriaId) && $categoriaId !== "") {
                        $sql .= " AND `categoria` = :categoria";
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
                    if(isset($categoriaId) && $categoriaId !== "") {
                        $stmt->bindValue(':categoria',$categoriaId);
                    };
                    if(isset($tipoConsumo) && $tipoConsumo !== "") {
                        $stmt->bindValue(':tipo_consumo',$tipoConsumo);
                    };
                    
                    
                    $stmt->execute();
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $sql = "SELECT `id`,`name`,`indice`,`ativo` FROM `categorias_produtos` WHERE `deleted` = :deleted";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':deleted', 0);
                    $stmt->execute();
                    $arrayCategs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

                    // Ordenar array ###########
                    // usort($arrayCategs, function($a, $b) {
                    //     return $a['indice'] <=> $b['indice']; // Ordenação crescente pelo ID
                    // });

                    
                    // echo "<pre>";
                    // print_r($arrayCategs);
                    // echo "</pre>";
        
                    foreach($resultado as $row){
                        $id = isset($row['id'])?$row['id']:"";
                        $codigo = isset($row['codigo'])?$row['codigo']:"";
                        $titulo = isset($row['titulo'])?$row['titulo']:"";
                        $categoria = isset($row['categoria'])?$row['categoria']:"";
                        $peso = isset($row['peso'])?$row['peso']:"";
                        $consumo = isset($row['tipo_consumo'])?$row['tipo_consumo']:"";
                        $multiplicador = isset($row['multiplicador'])?$row['multiplicador']:"";
                        $alturaMinima = isset($row['altura_minima_porta'])?$row['altura_minima_porta']:"";
                        $alturaMaxima = isset($row['altura_maxima_porta'])?$row['altura_maxima_porta']:"";
                        $larguraMinima = isset($row['largura_minima_porta'])?$row['largura_minima_porta']:"";
                        $larguraMaxima = isset($row['largura_maxima_porta'])?$row['largura_maxima_porta']:"";
                        $pesoMinimo = isset($row['peso_minimo_porta'])?$row['peso_minimo_porta']:"";
                        $pesoMaximo = isset($row['peso_maximo_porta'])?$row['peso_maximo_porta']:"";
                        $ativo = isset($row['ativo']) && $row['ativo'] == 1?"Ativo":"Inativo";
                        $selecionado = isset($row['selecionado']) && $row['selecionado'] === 1?"Sim":"Não";

                        if(isset($categoria)){
                            foreach($arrayCategs as $item => $value){
                                if($value['id'] == $categoria){
                                    $categTitulo = $value['name'];
                                    break;
                                } else {
                                    $categTitulo = "-";
                                }
                            }
                        } else {
                            $categTitulo = "-";
                        }


                    echo "<tr>";
                    echo "    <td>$codigo</td>";
                    echo "    <td>$ativo</td>";
                    echo "    <td>$titulo</td>";
                    echo "    <td>$categTitulo</td>";
                    // echo "    <td>$peso</td>";
                    // echo "    <td>$consumo</td>";
                    // echo "    <td>$multiplicador</td>";
                    echo "    <td>$alturaMinima</td>";
                    echo "    <td>$alturaMaxima</td>";
                    echo "    <td>$larguraMinima</td>";
                    echo "    <td>$larguraMaxima</td>";
                    echo "    <td>$pesoMinimo</td>";
                    echo "    <td>$pesoMaximo</td>";
                    // echo "    <td>$selecionado</td>";
                    echo "    <td><a class=\"btn btn-primary btn-sm\" href=\"editar_produto.php?produto_id=$id\">Editar</a></td>";
                    echo "</tr>";
                
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
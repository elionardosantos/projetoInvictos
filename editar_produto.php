<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Editar Produto</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('config/connection.php');

        $produtoId = isset($_GET['produto_id'])?$_GET['produto_id']:"";
        
        if($produtoId !== ""){
            $sql = "SELECT `id`,`codigo`,`titulo`,`peso`,`tipo_consumo`,`multiplicador`,`altura_minima_porta`,`altura_maxima_porta`,`largura_minima_porta`,`largura_maxima_porta`,`peso_minimo_porta`,`peso_maximo_porta`,`selecionado` 
            FROM `produtos` 
            WHERE `id` = :id 
            AND `deleted` = :deleted";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $produtoId);
            $stmt->bindValue(':deleted', 0);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $produto = $resultado[0];
        }

    ?>
    <div class="container">
        <h1>
            Editar produto
        </h1>
    </div>
    <div class="container">
        <form action="editar_produto_process.php" method="post">
            <div class="row">
                <div class="d-none">
                    <label for="id_produto" class="form-label mb-0">ID</label>
                    <input value="<?= $produto['id'] ?>" class="form-control" name="id_produto" type="text" placeholder="ID no BD" id="id_produto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="codigo_produto" class="form-label mb-0">codigo</label>
                    <input value="<?= $produto['codigo'] ?>" class="form-control" name="codigo_produto" type="text" placeholder="No Bling" id="codigo_produto">
                </div>
                <div class="col-lg-4 mt-2">
                    <label for="titulo_produto" class="form-label mb-0">Título</label>
                    <input value="<?= $produto['titulo'] ?>" class="form-control" name="titulo_produto" type="text" placeholder="No orçamento" id="titulo_produto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="peso_produto" class="form-label mb-0">Peso</label>
                    <input value="<?= $produto['peso'] ?>" class="form-control" name="peso_produto" type="text" inputmode="decimal" placeholder="Em KG" id="peso_produto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="consumo_produto" class="form-label mb-0">Consumo tipo</label>
                    <select class="form-select" name="consumo_produto" id="consumo_produto">
                        <option <?= $produto['tipo_consumo'] == "m2"?"selected":"" ?> value="m2">Metro quadrado</option>
                        <option <?= $produto['tipo_consumo'] == "altura"?"selected":"" ?> value="altura">Altura</option>
                        <option <?= $produto['tipo_consumo'] == "largura"?"selected":"" ?> value="largura">Largura</option>
                        <option <?= $produto['tipo_consumo'] == "peso"?"selected":"" ?> value="peso">Peso</option>
                        <option <?= $produto['tipo_consumo'] == "unidade"?"selected":"" ?> value="unidade">Unidade</option>
                    </select>
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="multiplicador_produto" class="form-label mb-0">Multiplicador</label>
                    <input value="<?= $produto['multiplicador'] ?>" class="form-control" name="multiplicador_produto" type="text" inputmode="decimal" placeholder="Fator de multiplicação" id="multiplicador_produto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="altura_minima" class="form-label mb-0">Altura mínima</label>
                    <input value="<?= $produto['altura_minima_porta'] ?>" class="form-control" name="altura_minima" type="text" inputmode="decimal" placeholder="Altura Mínima" id="altura_minima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="altura_maxima" class="form-label mb-0">Altura máxima</label>
                    <input value="<?= $produto['altura_maxima_porta'] ?>" class="form-control" name="altura_maxima" type="text" inputmode="decimal" placeholder="Altura Máxima" id="altura_maxima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="largura_minima" class="form-label mb-0">Largura mínima</label>
                    <input value="<?= $produto['largura_minima_porta'] ?>" class="form-control" name="largura_minima" type="text" inputmode="decimal" placeholder="Largura mínima" id="largura_minima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="largura_maxima" class="form-label mb-0">Largura máxima</label>
                    <input value="<?= $produto['largura_maxima_porta'] ?>" class="form-control" name="largura_maxima" type="text" inputmode="decimal" placeholder="Largura máxima" id="largura_maxima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="peso_minimo" class="form-label mb-0">Peso mínimo</label>
                    <input value="<?= $produto['peso_minimo_porta'] ?>" class="form-control" name="peso_minimo" type="text" inputmode="decimal" placeholder="Peso mínimo" id="peso_minimo">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="peso_maximo" class="form-label mb-0">Peso máximo</label>
                    <input value="<?= $produto['peso_maximo_porta'] ?>" class="form-control" name="peso_maximo" type="text" inputmode="decimal" placeholder="Peso máximo" id="peso_maximo">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="selecionado" class="form-label mb-0">Selecionado</label>
                    <select name="selecionado" id="selecionado" class="form-select">
                        <option <?= $produto['selecionado'] == "1"?"selected":"" ?> value="1">Sim</option>
                        <option <?= $produto['selecionado'] == "0"?"selected":"" ?> value="0">Não</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <input class="btn btn-primary" type="submit" value="Salvar">
                <a href="produtos.php" class="btn btn-primary ms-2">Voltar</a>
            </div>
        </form>
    </div>
    <div class="container mt-4">
    </div>
</body>
</html>
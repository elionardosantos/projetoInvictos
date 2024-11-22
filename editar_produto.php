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
            $sql = "SELECT `id`,`codigo`,`titulo`,`peso`,`consumo`,`multiplicador`,`altura_minima`,`altura_maxima`,`largura_minima`,`largura_maxima`,`peso_minimo`,`peso_maximo`,`selecionado` 
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
                    <label for="idProduto" class="form-label mb-0">ID</label>
                    <input value="<?= $produto['id'] ?>" class="form-control" name="idProduto" type="text" placeholder="ID no BD" id="idProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="codigoProduto" class="form-label mb-0">codigo</label>
                    <input value="<?= $produto['codigo'] ?>" class="form-control" name="codigoProduto" type="text" placeholder="No Bling" id="codigoProduto">
                </div>
                <div class="col-lg-4 mt-2">
                    <label for="tituloProduto" class="form-label mb-0">Título</label>
                    <input value="<?= $produto['titulo'] ?>" class="form-control" name="tituloProduto" type="text" placeholder="No orçamento" id="tituloProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="pesoProduto" class="form-label mb-0">Peso</label>
                    <input value="<?= $produto['peso'] ?>" class="form-control" name="pesoProduto" type="text" inputmode="decimal" placeholder="Em KG" id="pesoProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="consumoProduto" class="form-label mb-0">Consumo tipo</label>
                    <select class="form-select" name="consumoProduto" id="consumoProduto">
                        <option <?= $produto['consumo'] == "m2"?"selected":"" ?> value="m2">Metro quadrado</option>
                        <option <?= $produto['consumo'] == "altura"?"selected":"" ?> value="altura">Altura</option>
                        <option <?= $produto['consumo'] == "largura"?"selected":"" ?> value="largura">Largura</option>
                        <option <?= $produto['consumo'] == "peso"?"selected":"" ?> value="peso">Peso</option>
                    </select>
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="multiplicacaoProduto" class="form-label mb-0">Multiplicador</label>
                    <input value="<?= $produto['multiplicador'] ?>" class="form-control" name="multiplicadorProduto" type="text" inputmode="decimal" placeholder="Fator de multiplicação" id="multiplicadorProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="alturaMinima" class="form-label mb-0">Altura mínima</label>
                    <input value="<?= $produto['altura_minima'] ?>" class="form-control" name="alturaMinima" type="text" inputmode="decimal" placeholder="Altura Mínima" id="alturaMinima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="alturaMaxima" class="form-label mb-0">Altura máxima</label>
                    <input value="<?= $produto['altura_maxima'] ?>" class="form-control" name="alturaMaxima" type="text" inputmode="decimal" placeholder="Altura Máxima" id="alturaMaxima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="larguraMinima" class="form-label mb-0">Largura mínima</label>
                    <input value="<?= $produto['largura_minima'] ?>" class="form-control" name="larguraMinima" type="text" inputmode="decimal" placeholder="Largura mínima" id="larguraMinima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="larguraMaxima" class="form-label mb-0">Largura máxima</label>
                    <input value="<?= $produto['largura_maxima'] ?>" class="form-control" name="larguraMaxima" type="text" inputmode="decimal" placeholder="Largura máxima" id="larguraMaxima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="pesoMinimo" class="form-label mb-0">Peso mínimo</label>
                    <input value="<?= $produto['peso_minimo'] ?>" class="form-control" name="pesoMinimo" type="text" inputmode="decimal" placeholder="Peso mínimo" id="pesoMinimo">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="pesoMaximo" class="form-label mb-0">Peso máximo</label>
                    <input value="<?= $produto['peso_maximo'] ?>" class="form-control" name="pesoMaximo" type="text" inputmode="decimal" placeholder="Peso máximo" id="pesoMaximo">
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
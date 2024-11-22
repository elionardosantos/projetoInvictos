<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Novo Produto</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container">
        <h2>
            Novo produto
        </h2>
    </div>
    <div class="container">
        <form action="novo_produto_process.php" method="post">
            <div class="row">
                <div class="col-lg-2 mt-2">
                    <label for="codigoProduto" class="form-label mb-0">codigo</label>
                    <input class="form-control" name="codigoProduto" type="text" placeholder="No Bling" id="codigoProduto">
                </div>
                <div class="col-lg-4 mt-2">
                    <label for="tituloProduto" class="form-label mb-0">Título</label>
                    <input class="form-control" name="tituloProduto" type="text" placeholder="No orçamento" id="tituloProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="pesoProduto" class="form-label mb-0">Peso</label>
                    <input class="form-control" name="pesoProduto" type="text" inputmode="decimal" placeholder="Em KG" id="pesoProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="consumoProduto" class="form-label mb-0">Consumo tipo</label>
                    <select class="form-select" name="consumoProduto" id="consumoProduto">
                        <option value="m2">Metro quadrado</option>
                        <option value="altura">Altura</option>
                        <option value="largura">Largura</option>
                        <option value="peso">Peso</option>
                    </select>
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="multiplicacaoProduto" class="form-label mb-0">Multiplicador</label>
                    <input class="form-control" name="multiplicadorProduto" type="text" inputmode="decimal" placeholder="Fator de multiplicação" id="multiplicadorProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="alturaMinima" class="form-label mb-0">Altura mínima</label>
                    <input class="form-control" name="alturaMinima" type="text" inputmode="decimal" placeholder="Altura Mínima" id="alturaMinima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="alturaMaxima" class="form-label mb-0">Altura máxima</label>
                    <input class="form-control" name="alturaMaxima" type="text" inputmode="decimal" placeholder="Altura Máxima" id="alturaMaxima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="larguraMinima" class="form-label mb-0">Largura mínima</label>
                    <input class="form-control" name="larguraMinima" type="text" inputmode="decimal" placeholder="Largura mínima" id="larguraMinima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="larguraMaxima" class="form-label mb-0">Largura máxima</label>
                    <input class="form-control" name="larguraMaxima" type="text" inputmode="decimal" placeholder="Largura máxima" id="larguraMaxima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="pesoMinimo" class="form-label mb-0">Peso mínimo</label>
                    <input class="form-control" name="pesoMinimo" type="text" inputmode="decimal" placeholder="Peso mínimo" id="pesoMinimo">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="pesoMaximo" class="form-label mb-0">Peso máximo</label>
                    <input class="form-control" name="pesoMaximo" type="text" inputmode="decimal" placeholder="Peso máximo" id="pesoMaximo">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="selecionado" class="form-label mb-0">Selecionado</label>
                    <select name="selecionado" id="selecionado" class="form-select">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
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
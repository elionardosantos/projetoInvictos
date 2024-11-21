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
                    <label for="referenciaProduto" class="form-label mb-0">Referência</label>
                    <input class="form-control" name="referenciaProduto" type="text" placeholder="Referencia no Bling" id="referenciaProduto">
                </div>
                <div class="col-lg-4 mt-2">
                    <label for="tituloProduto" class="form-label mb-0">Título do produto</label>
                    <input class="form-control" name="tituloProduto" type="text" placeholder="Aparecerá no orçamento" id="tituloProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="pesoProduto" class="form-label mb-0">Peso em KG</label>
                    <input class="form-control" name="pesoProduto" type="text" inputmode="decimal" placeholder="Por unidade" id="pesoProduto">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="consumoProduto" class="form-label mb-0">Consumo tipo</label>
                    <select class="form-select" name="consumoProduto" id="consumoProduto">
                        <option value="m2">Metro quadrado</option>
                        <option value="altura">Altura</option>
                        <option value="largura">Largura</option>
                    </select>
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="multiplicacaoProduto" class="form-label mb-0">Multiplicação</label>
                    <input class="form-control" name="multiplicacaoProduto" type="text" inputmode="decimal" placeholder="Fator de multiplicação" id="multiplicacaoProduto">
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
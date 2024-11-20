<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Cadastrar Produto</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container">
        <h1>
            Cadastrar produto
        </h1>
    </div>
    <div class="container">
        <form action="cadastrar_produto_process.php" method="post">
            <div class="row">
                <div class="col-md mt-2">
                    <label for="referenciaProduto" class="form-label mb-0">Referência</label>
                    <input class="form-control" name="referencia" type="text" placeholder="Referencia no Bling" id="referenciaProduto">
                </div>
                <div class="col-md mt-2">
                    <label for="pesoProduto" class="form-label mb-0">Peso</label>
                    <input class="form-control" name="pesoProduto" type="number" placeholder="Peso por unidade" id="pesoProduto">
                </div>
                <div class="col-md mt-2">
                    <label for="calculoConsumo" class="form-label mb-0">Cálculo de consumo</label>
                    <select class="form-select" name="calculoConsumo" id="calculoConsumo">
                        <option value="m2">Metro quadrado</option>
                    </select>
                </div>
                <div class="col-md mt-2">
                    <label for="pesoProduto" class="form-label mb-0">Multiplicação</label>
                    <input class="form-control" name="pesoProduto" type="number" placeholder="Fator de multiplicação" id="pesoProduto">
                </div>
            </div>
            <input class="btn btn-primary mt-4" type="submit" value="Salvar">
        </form>
    </div>
    <div class="container mt-4">
        
    </div>

</body>
</html>
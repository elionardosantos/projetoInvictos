<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Document</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('controller/only_level_2.php');
        require('partials/navbar.php');
    ?>
    <div class="container my-3">
        <h2>Categorias</h2>
    </div>

    <div class="container mt-5">
        <h2>Formulário</h2>
        <form>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Digite o título">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label for="statusProduto" class="form-label mb-0">Status</label>
                    <select name="statusProduto" id="statusProduto" class="form-select">
                        <option <?= isset($produto['statusProduto']) && $produto['statusProduto'] == "1"?"selected":"" ?> value="1">1 - Ativo</option>
                        <option <?= isset($produto['statusProduto']) && $produto['statusProduto'] == "0"?"selected":"" ?> value="0">0 - Inativo</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>

    
</body>
</html>
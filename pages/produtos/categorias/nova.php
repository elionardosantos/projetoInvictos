<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Nova Categoria</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../../../controller/login_checker.php');
        require(__DIR__ . '/../../../partials/navbar.php');
        require(__DIR__ . '/../../../controller/only_level_2.php');
    ?>
    
    <div class="container">
        <p><h2>Nova Categoria</h2></p>
        <?= isset($screenMessage)?$screenMessage:"" ?>
        <form action="nova_process.php" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text col-md-2 col-3">Nome</span>
                <input type="text" class="form-control" placeholder="Digite o nome" name="formName" autofocus>
            </div>
            <!-- <div class="input-group mb-3">
                <span class="input-group-text">Status</span>
                <div class="">
                    <select class="form-select form-control" name="formLevel">
                        <option value="1" selected>1 - Ativo</option>
                        <option value="0">0 - Inativo</option>
                    </select>
                </div>
            </div> -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Cadastrar categoria</button>
                <a class="btn btn-primary" href="listar.php">Voltar</a>
            </div>
        </form>

    </div>
</body>
</html>
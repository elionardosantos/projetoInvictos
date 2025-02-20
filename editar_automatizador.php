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
            $sql = "SELECT `id`,`codigo`,`titulo`,`multiplicador`,`peso_minimo_porta`,`peso_maximo_porta`,`selecionado`,`ativo`
            FROM `automatizadores` 
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
    <div class="container my-3">
        <h2>
            Editar produto
        </h2>
    </div>
    <div class="container">
        <form action="editar_automatizador_process.php" method="post">
            <div class="mt-5">
                <h4>Dados do produto</h4>
            </div>
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
                    <label for="multiplicador_produto" class="form-label mb-0">Multiplicador</label>
                    <input value="<?= $produto['multiplicador'] ?>" class="form-control" name="multiplicador_produto" type="text" inputmode="decimal" placeholder="Fator de multiplicação" id="multiplicador_produto">
                </div>
            </div>
            <div class="mt-5">
                <h4>Faixa de Peso</h4>
            </div>
            <div class="row">
                <div class="col-lg-2 mt-2">
                    <label for="peso_minimo" class="form-label mb-0">Peso mínimo</label>
                    <input value="<?= $produto['peso_minimo_porta'] ?>" class="form-control" name="peso_minimo" type="text" inputmode="decimal" placeholder="Peso mínimo" id="peso_minimo">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="peso_maximo" class="form-label mb-0">Peso máximo</label>
                    <input value="<?= $produto['peso_maximo_porta'] ?>" class="form-control" name="peso_maximo" type="text" inputmode="decimal" placeholder="Peso máximo" id="peso_maximo">
                </div>
            </div>
            
            <div class="mt-5">
                <h4>Outro</h4>
            </div>
            <div class="row">
                <div class="col-lg-3 mt-2">
                    <label for="statusProduto" class="form-label mb-0">Status</label>
                    <select name="statusProduto" id="statusProduto" class="form-select">
                        <option <?= isset($produto['ativo']) && $produto['ativo'] == "1"?"selected":"" ?> value="1">1 - Ativo</option>
                        <option <?= isset($produto['ativo']) && $produto['ativo'] == "0"?"selected":"" ?> value="0">0 - Inativo</option>
                    </select>
                </div>
                <div class="col-lg-3 mt-2">
                    <label for="selecionado" class="form-label mb-0">Selecionado no orçamento</label>
                    <select name="selecionado" id="selecionado" class="form-select">
                        <option <?= $produto['selecionado'] == "1"?"selected":"" ?> value="1">1 - Sim</option>
                        <option <?= $produto['selecionado'] == "0"?"selected":"" ?> value="0">0 - Não</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <input class="btn btn-primary" type="submit" value="Salvar">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#deleteQuest">
                    Apagar
                </button>
                <a href="automatizadores.php" class="btn btn-primary">Voltar</a>
            </div>
        </form>
    </div>
    
    <div>
            <!-- Modal -->
            <div class="modal fade" id="deleteQuest" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Atenção!</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja apagar este produto?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a href="apagar_motor_process.php?id=<?= $produtoId; ?>">
                                <button type="button" class="btn btn-danger">Sim</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="container mt-4">
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Editar categoria</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../../../controller/login_checker.php');
        require(__DIR__ . '/../../../partials/navbar.php');
        require(__DIR__ . '/../../../controller/only_level_2.php');

        $categId = isset($_GET['id'])?$_GET['id']:"";

        if(isset($_POST['formName']) && isset($_POST['formAtivo'])){
            require(__DIR__ . '/../../../config/connection.php');
            
            $formName = $_POST['formName'];
            $formAtivo = $_POST['formAtivo'];
            $formIndice = $_POST['formIndice'];
            $created_by = $_SESSION['login']['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $dateTime = date('Y-m-d H:i:s');
            
            $sql = "UPDATE `categorias_produtos` SET `name` = :formName, `ativo` = :formAtivo, `indice` = :formIndice, `updated_by` = :updated_by, `updated_at` = :updated_at WHERE `id` = :categId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':formName', $formName);
            $stmt->bindParam(':formAtivo', $formAtivo);
            $stmt->bindParam(':formIndice', $formIndice);
            $stmt->bindParam(':categId', $categId);
            $stmt->bindValue(':updated_by', $_SESSION['login']['loggedUserId']);
            $stmt->bindValue(':updated_at', $dateTime);

            if($stmt->execute() === TRUE) {
                $screenMessage = "<div class=\"alert alert-success\">Atualizada</div>";                
            } else {
                $screenMessage = "<div class=\"alert alert-danger\">Erro na atualização</div>";
            }

        } else {
            // $screenMessage = "<div class=\"alert alert-danger\">Favor preencher todos os campos</div>";
        }
        
        // Auto fill with user data
        if($categId !== ""){
            require(__DIR__ . '/../../../config/connection.php');

            $sql = "SELECT `name`,`ativo`,`indice` FROM `categorias_produtos` WHERE `id` = :categId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':categId', $categId);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $row){
                $categName = isset($row['name'])?$row['name']:"";
                $categStatus = isset($row['ativo'])?$row['ativo']:"";
                $categIndice = isset($row['indice'])?$row['indice']:"";
            }

        }
        
    ?>
    <div class="container">
        <p><h2>Editar categoria</h2></p>
        <br>
        <?= isset($screenMessage)?$screenMessage:""; ?>
        <form action="" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-2 col-3">Nome</span>
                <input type="text" class="form-control" placeholder="Digite o nome" value="<?= $categName; ?>" name="formName" autofocus>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-2 col-3">Status</span>
                <div class="">
                    <select class="form-select form-control" name="formAtivo">
                        <option <?= $categStatus == 0?"selected":"" ?> value="0">Inativo</option>
                        <option <?= $categStatus == 1?"selected":"" ?> value="1">Ativo</option>
                    </select>
                </div>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-2 col-3">Índice</span>
                <input type="number" class="form-control" placeholder="(Posição do item no orçamento) Digite um número" value="<?= $categIndice; ?>" name="formIndice" autofocus>
            </div>
            <div>
                <p>
                    <button type="submit" class="btn btn-primary">Atualizar categoria</button>
                </p>
            </div>
        </form>
        <div class="mt-5">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategQuest">
                Apagar Categoria
            </button>
            <a href="listar.php">
                <button type="submit" class="btn btn-primary">Voltar</button>
            </a>
        </div>
        <div>
            <!-- Modal -->
            <div class="modal fade" id="deleteCategQuest" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Atenção!</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja apagar esta categoria?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a href="apagar.php?id=<?= $categId; ?>">
                                <button type="button" class="btn btn-danger">Sim</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        
        ?>
    </div>
</body>
</html>
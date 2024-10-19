<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Editar usuário</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');

        $userId = isset($_GET['id'])?$_GET['id']:"";

        if(isset($_POST['formName']) && isset($_POST['formEmail']) && isset($_POST['formLevel'])){
            require('config/connection.php');
            
            $formName = $_POST['formName'];
            $formEmail = $_POST['formEmail'];
            $formLevel = $_POST['formLevel'];
            
            $sql = "UPDATE `users` SET `name` = :formName, `email` = :formEmail, `level` = :formLevel WHERE `id` = :userId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':formName', $formName);
            $stmt->bindParam(':formEmail', $formEmail);
            $stmt->bindParam(':formLevel', $formLevel);
            $stmt->bindParam(':userId', $userId);

            if($stmt->execute() === TRUE) {
                $screenMessage = "<div class=\"alert alert-success\">Usuário atualizado</div>";                
            } else {
                $screenMessage = "<div class=\"alert alert-danger\">Erro na atualização</div>";
            }

        } else {
            // $screenMessage = "<div class=\"alert alert-danger\">Favor preencher todos os campos</div>";
        }
        
        // Auto fill with user data
        if($userId !== ""){
            require('config/connection.php');

            $sql = "SELECT `name`,`email`,`level` FROM `users` WHERE `id` = :userId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $row){
                $dbUserName = isset($row['name'])?$row['name']:"";
                $dbUserEmail = isset($row['email'])?$row['email']:"";
                $dbUserLevel = isset($row['level'])?$row['level']:"";
            }

        }
        
    ?>
    <div class="container">
        <p><h2>Editar usuário</h2></p>
        <br>
        <?= isset($screenMessage)?$screenMessage:""; ?>
        <form action="" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-2 col-3">Nome</span>
                <input type="text" class="form-control" placeholder="Digite o nome" value="<?= $dbUserName; ?>" name="formName">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-2 col-3">Email</span>
                <input type="email" class="form-control" placeholder="Digite o email" value="<?= $dbUserEmail; ?>" name="formEmail">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-2 col-3">Nível</span>
                <div class="">
                    <select class="form-select form-control" name="formLevel">
                        <option <?= $dbUserLevel == 0?"selected":"" ?> value="0">0 - Inativo</option>
                        <option <?= $dbUserLevel == 1?"selected":"" ?> value="1">1 - Usuário</option>
                        <option <?= $dbUserLevel >= 2?"selected":"" ?> value="2">2 - Administrador</option>
                    </select>
                </div>
            </div>
            <div>
                <p>
                    <button type="submit" class="btn btn-primary">Atualizar usuario</button>
                </p>
            </div>
        </form>
        <div class="mt-5">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserQuest">
                Apagar Usuário
            </button>
            <a href="listar_usuarios.php">
                <button type="submit" class="btn btn-primary">Voltar</button>
            </a>
        </div>
        <div>
            <!-- Modal -->
            <div class="modal fade" id="deleteUserQuest" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Atenção!</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja apagar este usuário?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a href="apagar_usuario_process.php?id=<?= $userId; ?>">
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
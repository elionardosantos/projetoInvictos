<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . '/../../../partials/head.php'); ?>
    <title>Nova Categoria...</title>
</head>
<body>
    <?php
        require(__DIR__ . '/../../../controller/login_checker.php');
        require(__DIR__ . '/../../../partials/navbar.php');
        require(__DIR__ . '/../../../controller/only_level_2.php');
    
        $formName = isset($_POST['formName'])?$_POST['formName']:"";
        // $formEmail = isset($_POST['formEmail'])?$_POST['formEmail']:"";
        // $formPassword = isset($_POST['formPassword'])?$_POST['formPassword']:"";
        // $formLevel = isset($_POST['formLevel'])?$_POST['formLevel']:"";
        // $formPasswordHash = hash('sha256',$formPassword);
        
        if($formName !== ""){
            require(__DIR__ . '/../../../config/connection.php');

            $sql = "SELECT `id` FROM `categorias_produtos` WHERE `name` = :formName AND `deleted` != :deleted";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':formName', $formName);
            $stmt->bindValue(':deleted', 1);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($result) {
                $screenMessage = '<div class="alert alert-danger">A categoria ' . $formName . ' já foi cadastrada. Por favor, escolha outro nome.</div>';
            } else {
                userInsert();
            }
            
        }
        
        function userInsert() {
            global $formName;
            $created_by = $_SESSION['login']['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $created_at = date('Y-m-d H:i:s');

            try {
                require(__DIR__ . '/../../../config/connection.php');
                $sql = "INSERT INTO `categorias_produtos`(`name`, `ativo`, `indice`, `deleted`, `created_by`, `created_at`) 
                    VALUES (:formName, :ativo, :indice, :deleted, :created_by, :created_at)";
                    
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':formName', $formName);
                $stmt->bindValue(':ativo', 1);
                $stmt->bindValue(':indice', 0);
                $stmt->bindValue(':created_by', $created_by);
                $stmt->bindValue(':created_at', $created_at);
                $stmt->bindValue(':deleted', 0);
                
                if($stmt->execute()){
                    global $screenMessage;
                    $screenMessage = '<div class="alert alert-success">Categoria cadastrada com sucesso</div>';
                } 
                
            } catch(PDOException $e) {
                global $screenMessage;
                $screenMessage = "Erro ao inserir dados: " . $e->getMessage();
            }
        }
    ?>
    <div class="container">
        <p><h2>Cadastrar categoria</h2></p>
        <?= isset($screenMessage)?$screenMessage:"" ?>
        <a href="listar.php">
            <button class="btn btn-primary">Voltar</button>
        </a>
    </div>
</body>
</html>
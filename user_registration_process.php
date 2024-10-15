<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Cadastrar usuário</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');
    
        $formName = isset($_POST['formName'])?$_POST['formName']:"";
        $formEmail = isset($_POST['formEmail'])?$_POST['formEmail']:"";
        $formPassword = isset($_POST['formPassword'])?$_POST['formPassword']:"";
        $formLevel = isset($_POST['formLevel'])?$_POST['formLevel']:"";
        $formPasswordHash = hash('sha256',$formPassword);
        
        if($formName !== "" && $formEmail !== "" && $formPassword !== ""){
            require('config/connection.php');

            $sql = "SELECT `id` FROM `users` WHERE `email` = :formEmail AND `deleted` != :deleted";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':formEmail', $formEmail);
            $stmt->bindValue(':deleted', 1);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($result) {
                $screenMessage = '<div class="alert alert-danger">O email ' . $formEmail . ' já está sendo utilizado. Por favor, escolha outro email</div>';
            } else {
                userInsert();
            }
            
        }
        
        function userInsert() {
            global $formName;
            global $formEmail;
            global $formPasswordHash;
            global $formLevel;
            $created_by = $_SESSION['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $created_at = date('Y-m-d H:i:s');

            try {
                require('config/connection.php');
                $sql = "INSERT INTO `users`(`name`, `email`, `level`, `deleted`, `password`, `created_by`, `created_at`) 
                    VALUES (:formName, :formEmail, :formLevel, :deleted, :formPasswordHash, :created_by, :created_at)";
                    
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':formName', $formName);
                $stmt->bindValue(':formEmail', $formEmail);
                $stmt->bindValue(':formPasswordHash', $formPasswordHash);
                $stmt->bindValue(':formLevel', $formLevel);
                $stmt->bindValue(':created_by', $created_by);
                $stmt->bindValue(':created_at', $created_at);
                $stmt->bindValue(':deleted', 0);
                
                if($stmt->execute()){
                    global $screenMessage;
                    $screenMessage = '<div class="alert alert-success">Usuário cadastrado com sucesso</div>';
                } 
                
            } catch(PDOException $e) {
                global $screenMessage;
                $screenMessage = "Erro ao inserir dados: " . $e->getMessage();
            }
        }
    ?>
    <div class="container">
        <p><h2>Cadastrar usuário</h2></p>
        <?= isset($screenMessage)?$screenMessage:"" ?>
        <a href="user_registration.php">
            <button class="btn btn-primary">Voltar</button>
        </a>
    </div>
</body>
</html>
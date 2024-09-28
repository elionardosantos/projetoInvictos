<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Editar usuário</title>
</head>
<body>
    <?php
        require('controller/loginChecker.php');
        require('partials/navbar.php');
        require('controller/onlyLevel2.php');

    ?>
    <div class="container">
        <p><h2>Editar usuário</h2></p>
        <br>
        <?php 
            $screenMessage = "<div class=\"alert alert-danger\">Esta tela ainda não está funcionando</div>";
        ?>
        <?= $screenMessage; ?>
        <form action="" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-1 col-3">Nome</span>
                <input type="text" class="form-control" placeholder="Digite o nome" name="formName">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text col-sm-1 col-3">Email</span>
                <input type="email" class="form-control" placeholder="Digite o email" name="formEmail">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Nível de Usuário</span>
                <div class="">
                    <select class="form-select form-control" name="formLevel">
                        <option value="0">0 - Inativo</option>
                        <option value="1">1 - Usuário</option>
                        <option value="2">2 - Administrador</option>
                    </select>
                </div>
            </div>
            <div>
                <p>
                    <button type="submit" class="btn btn-primary">Atualizar</button>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserQuest">
                        Apagar Usuário
                    </button>
                </p>

            </div>
        </form>
        <div>

            <!-- Modal -->
            <div class="modal fade" id="deleteUserQuest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja apagar este usuário?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a href="">
                                <button type="button" class="btn btn-danger">Apagar usuário</button>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $formName = isset($_POST['formName'])?$_POST['formName']:"";
            $formEmail = isset($_POST['formEmail'])?$_POST['formEmail']:"";
            $formPassNoHash = isset($_POST['formPass'])?$_POST['formPass']:"";
            $formPass = password_hash($formPassNoHash, PASSWORD_DEFAULT);

            // password_verify(senha_login, senha_hash)
            
            if($formName !== "" && $formEmail !== "" && $formPass !== ""){
                require('config/connection.php');

                $sql = "SELECT * FROM `users` WHERE email = \"$formEmail\"";
                $result = mysqli_query($conn, $sql);
                
                if($result -> num_rows > 0) {
                    echo '<div class="alert alert-danger">O email ' . $formEmail . ' já está sendo utilizado. Por favor, escolha outro email</div>';
                } else {
                    userInsert();
                    echo '<div class="alert alert-success">Usuário cadastrado com sucesso</div>';
                    
                }
                
                $conn -> close();
            }        
            
            function userInsert() {
                global $formName;
                global $formEmail;
                global $formPass;
                $formStatus = 1;

                require('config/connection.php');
                $sql = "INSERT INTO `users`(`email`, `name`, `password`, `status`) VALUES ('$formEmail','$formName','$formPass','$formStatus')";

                //Executando o insert
                $conn->query($sql);
                
                $conn -> close();
            }
        ?>
    </div>
</body>
</html>
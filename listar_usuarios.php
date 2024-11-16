<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');
    ?>
    <div class="container my-3">
        <a href="cadastrar_usuario.php" class="btn btn-primary" role="button">Cadastrar novo usuário</a>
    </div>
    <div class="container my-3">
        
        <?php 

            usersListing();
            
            function usersListing() {
                require('config/connection.php');

                $sql = "SELECT `id`,`name`,`email`,`level` FROM `users` WHERE `deleted` = :deleted";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':deleted', 0);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>
                <div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col" class="d-none d-sm-block">Email</th>
                                <th scope="col">Nível</th>
                                <!-- <th scope="col">Senha</th> -->
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    if($result) {

                                        foreach($result as $row) {
                                            $userId = $row['id'];
                                            $userName = $row['name'];
                                            $userEmail = $row['email'];
                                            $userStatus = $row['level'];
                                            
                                            echo "<tr>";
                                            echo "<td>$userId</td>";
                                            echo "<td>$userName</td>";
                                            echo "<td class=\"d-none d-sm-block\">$userEmail</td>";
                                            echo "<td>$userStatus</td>";
                                            // echo "<td>$userPass</td>";
                                            echo "<td><a href=\"editar_usuario.php?id=$userId\" class=\"btn btn-primary btn-sm\">Editar</a></td>";
                                            echo "</tr>";
                                        }
                                    }
                                        
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
        <?php
        
            }
            
        ?>
    </div>
</body>
</html>
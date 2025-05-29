<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Listar usuários</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');
    ?>
    <div class="container my-3">
        <h2>Listar usuários</h2>
    </div>
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
                                <th class="d-none d-md-table-cell" scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Login</th>
                                <th class="d-none d-sm-table-cell" scope="col">Nível</th>
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

                                            switch ($userStatus) {
                                                case 0:
                                                    $userStatus = "0 - Inativo";
                                                    break;
                                                
                                                case 1:
                                                    $userStatus = "1 - Usuário";
                                                    break;
                                                
                                                case 2:
                                                    $userStatus = "2 - Adm";
                                                    break;
                                                
                                                default:
                                                    # code...
                                                    break;
                                            }
                                            
                                            echo "<tr>";
                                            echo "<td class=\"d-none d-md-table-cell\">$userId</td>";
                                            echo "<td>$userName</td>";
                                            echo "<td>$userEmail</td>";
                                            echo "<td class=\"d-none d-sm-table-cell\">$userStatus</td>";
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
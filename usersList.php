<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
</head>
<body>
    <?php
        require('controller/loginChecker.php');
        require('partials/navbar.php');

    ?>
    <div class="container">
        <p>
            <div class="container">
                <a class="btn btn-primary" href="userRegistration.php">Cadastrar novo usuário</a>
            </div>
        </p>
        
        <?php 

            usersListing();
            
            function usersListing() {
                require('config/connection.php');

                // Consulta SQL
                $sql = "SELECT * FROM `users` WHERE 1";
                $result = mysqli_query($conn, $sql);
                if($result-> num_rows > 0) {


        ?>
                <div>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nível</th>
                                <!-- <th scope="col">Senha</th> -->
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    foreach($result as $row) {
                                        $userId = $row['id'];
                                        $userName = $row['name'];
                                        $userEmail = $row['email'];
                                        $userStatus = $row['level'];
                                        // $userPass = $row['password'];
                                        
                                        echo "<tr>";
                                        echo "<td>$userId</td>";
                                        echo "<td>$userName</td>";
                                        echo "<td>$userEmail</td>";
                                        echo "<td>$userStatus</td>";
                                        // echo "<td>$userPass</td>";
                                        echo "<td><a href=\"userEdit.php?id=$userId\" class=\"btn btn-primary btn-sm\">Editar</a></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
        <?php
        
                } else {
                    echo "Nenhum usuário cadastrado";
                }
            $conn -> close();
            }
        ?>
    </div>
</body>
</html>
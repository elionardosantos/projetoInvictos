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
            <h2>
                <a class="btn btn-primary" href="userRegistration.php">Novo</a>
            </h2>
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
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
                                        $userStatus = $row['status'];
                                        
                                        echo "<tr>";
                                        echo "<td>$userId</td>";
                                        echo "<td>$userName</td>";
                                        echo "<td>$userEmail</td>";
                                        echo "<td>$userStatus</td>";
                                        echo "<td><a href=\"userEdit.php?id=$userId\">Editar</a></td>";
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
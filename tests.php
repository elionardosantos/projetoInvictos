<head>
  <?php require('partials/head.php'); ?>
</head>
<form action="" method="post">
    <p>Nome: <input type="text" name="name" id=""></p>
    <p>Email: <input type="email" name="email" id=""></p>
    <p>Senha: <input type="password" name="pass" id=""></p>
    <p><input type="submit" value="Inserir"></p>
</form>
<?php
    $formName = isset($_POST['name'])?$_POST['name']:"";
    $formEmail = isset($_POST['email'])?$_POST['email']:"";
    $formPass = isset($_POST['pass'])?$_POST['pass']:"";

    require('config/connection.php');

    // Consulta SQL
    $sql = "SELECT * FROM `users` WHERE 1;";
    $result = mysqli_query($conn, $sql);

    // Verifica se há dados na consulta
    if(mysqli_num_rows($result) > 0){ 
?>
    <table class="table">
        <thead>
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Email</th>
              <th scope="col">Senha</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                      <tr>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['password']; ?></td>
                      </tr>
                    <?php
                };
                } else {
                    echo "Retorno < 0";
                }
            ?>
        </tbody>
    </table>
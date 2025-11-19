<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Consultar Clientes</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2>Consultar Clientes</h2>
    </div>
    <div class="container my-3">
        <form action="" method="GET">
            <div class="input-group mb-3">
                <span class="input-group-text" id="nome">Nome</span>
                <input type="text" name="nome" class="form-control" placeholder="Digite aqui" autofocus>
            </div>
            <input type="submit" class="btn btn-primary" value="Consultar">
            <a href="novo_orcamento.php" class="btn btn-primary">Voltar</a>
        </form>
    </div>
    <div class="container mt-5">
                <?php
                $passHere = "yes";
                
                //CONSULTANDO CONTATOS NO BLING
                $nome = isset($_GET['nome'])?$_GET['nome']:"";
                if($nome === ''){
                    // Nada acontece
                } else {
                    consultaContato($nome);
                }

                function consultaContato($nome){
                    global $passHere;

                    $jsonFile = file_get_contents('config/token_request_response.json');
                    $jsonData = json_decode($jsonFile, true);
                    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
                    $url = "https://api.bling.com.br/Api/v3/contatos?pesquisa=$nome";

                    $headers = array(
                        "authorization: Bearer " . $token
                    );
                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    // echo "<script>console.log($response)</script>";
                    
                    $data = json_decode($response, true);
                    
                    if(isset($data['error']['type']) && $data['error']['type'] === "invalid_token"){
                        require('controller/token_refresh.php');
                        consultaContato($nome);
                    }elseif(isset($data['data']) && $data['data'] == null){
                        if($passHere == "yes"){
                            $passHere = "no";
                            // Este IF pesquisa o contato utilizando % antes e depois da string se o primeiro if não retornar nenhum resultado.
                            // O Bling diferencia a pesquisa com e sem o símbolo % como em uma consulta SQL
                            consultaContato("%".$nome."%"); 
                        } else {
                            echo "Nenhum resultado encontrado";
                        }
                    }else{
                        ?>
                        <table class="table table-sm  table-striped">
                            <thead>
                                <tr>
                                    <th class="d-none d-md-table-cell" scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th class="d-none d-md-table-cell" scope="col">CPF/CNPJ</th>
                                    <th class="d-none d-md-table-cell" scope="col">Celular</th>
                                    <th class="d-none d-lg-table-cell" scope="col">Telefone</th>
                                </tr>
                            </thead>
                        <tbody>
                        <?php
                        if(isset($data['data'])){
                            foreach($data['data'] as $contato){
                                if($contato['situacao'] === "A"){
                                    $id = isset($contato['id'])?$contato['id']:"";
                                    $situacao = isset($contato['situacao'])?$contato['situacao']:"";
                                    $codigo = isset($contato['codigo'])?$contato['codigo']:"";
                                    $nome = isset($contato['nome'])?$contato['nome']:"";
                                    $numeroDocumento = isset($contato['numeroDocumento'])?$contato['numeroDocumento']:"";
                                    $celular = isset($contato['celular'])?$contato['celular']:"";
                                    $telefone = isset($contato['telefone'])?$contato['telefone']:"";
                                        
                                    ?>
                                    <tr onclick="window.location.href='novo_orcamento.php?contatoId=<?= $id ?>';" style="cursor: pointer;">
                                        <td class="d-none d-md-table-cell"><?= $codigo ?></td>
                                        <td><?= $nome ?></td>
                                        <td class="d-none d-md-table-cell"><?= $numeroDocumento ?></td>
                                        <td class="d-none d-md-table-cell"><?= $celular ?></td>
                                        <td class="d-none d-lg-table-cell"><?= $telefone ?></td>
                                    </tr>
                                    <?php
                                }
                            }

                        } else {
                            echo "Nenhum cliente encontrado";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container">

    </div>
</body>
</html>
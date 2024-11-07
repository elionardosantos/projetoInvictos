<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Pedidos/Orçamentos</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

        $dataInicial = isset($_GET['dataInicial'])?$_GET['dataInicial']:date('Y-m-d',strtotime('-30 days'));
        $dataFinal = isset($_GET['dataFinal'])?$_GET['dataFinal']:date('Y-m-d');
        $numeroPedido = isset($_GET['numeroPedido'])?$_GET['numeroPedido']:"";
        $nomePedido = isset($_GET['nomePedido'])?$_GET['nomePedido']:"";
        $urlData = "dataInicial=".$dataInicial."&dataFinal=".$dataFinal."&numero=".$numeroPedido."&nome=".$nomePedido;

    ?>
    <div class="container my-3">
        <h2>Pedidos/Orçamentos</h2>
    </div>
    <div class="container mb-4">
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-4">
                    <label for="dataInicial">Data inicial</label>
                    <input type="date" class="form-control" name="dataInicial" id="dataInicial" value="<?= $dataInicial ?>">
                </div>
                <div class="col-sm-4">
                    <label for="dataFinal">Data Final</label>
                    <input type="date" class="form-control" name="dataFinal" id="dataFinal" value="<?= $dataFinal ?>">
                </div>
                <!-- <div class="col">
                    <label for="nomePedido">Nome</label>
                    <input type="text" class="form-control" name="nomePedido" id="nomePedido" value="<?= $nomePedido ?>">
                </div> -->
                <div class="col-sm-4">
                    <label for="numeroPedido">Número do pedido</label>
                    <input type="number" class="form-control" name="numeroPedido" id="numeroPedido" value="<?= $numeroPedido ?>">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <input type="submit" value="Buscar" class="btn btn-primary">
                <a href="novo_pedido.php" class="btn btn-primary ms-4" role="button">Novo</a>
                <a href="consulta_cnpj.php" class="btn btn-primary" role="button">Consultar CNPJ</a>
                <a href="consulta_contato.php" class="btn btn-primary" role="button">Consultar Contatos</a>
                </div>
            </div>
        </form>
    </div>
    <div>
        <div class="container">
            <?php
                //Quering Bling orders by API
                ordersQuery();
                function ordersQuery(){
                    global $urlData;
                    $jsonFile = file_get_contents('config/token_request_response.json');
                    $jsonData = json_decode($jsonFile, true);
                    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
                    $endPoint = "https://api.bling.com.br/Api/v3/pedidos/vendas?$urlData";
                    
                    $cURL = curl_init($endPoint);
                    $headers = array(
                        'Authorization: Bearer '.$token
                    );
                    curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($cURL, );
                    $data = json_decode($response, true);
                    
                    //verify and refresh token
                    if(isset($data['error']['type']) && $data['error']['type'] === "invalid_token"){
                        require('controller/token_refresh.php');
                        echo "<p>Token atualizado</p>";
                        ordersQuery();
                    } else if(isset($data['data']) && $data['data'] == null) {
                        echo "<hr><p>Nenhum pedido encontrado baseado nos filtros atuais</p>";
                        echo $jsonData;
                    } else {
                        // echo $response;
                        ?>
                            <div>
                                <table class="table table-sm  table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Número</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Situação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($data['data'] as $row){
                                                $pedidoId = $row['id'];

                                                //Abrir o orçamento em uma nova guia ao clincar na linha do pedido
                                                echo "<tr onclick=\"window.location.href='pedido_visualizacao.php?pedidoId=$pedidoId'; return false;\" style=\"cursor: pointer;\">";
                                                
                                                echo "<td>" . $row['numero'] . "</td>";
                                                echo "<td>" . date('d/m/Y', strtotime($row['data'])) . "</td>";
                                                echo "<td>" . $row['contato']['nome'] . "</td>";
                                                echo "<td>R$" . number_format($row['total'], 2, ',', '.') . "</td>";
                                                echo "<td>" . $row['situacao']['id'] . "</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                    }
                
                    // echo "<p>".$response."</p>";
                }
            ?>
            
        </div>
    </div>
</body>
</html>
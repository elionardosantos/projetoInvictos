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
        $situacaoPedido = isset($_GET['situacao'])?$_GET['situacao']:"";

        $situacaoPedidoUrl = isset($_GET['situacao'])&&$situacaoPedido!==""?"&idsSituacoes[]=".$situacaoPedido:"";

        $urlData = "dataInicial=".$dataInicial."&dataFinal=".$dataFinal."&numero=".$numeroPedido."&nome=".$nomePedido.$situacaoPedidoUrl;
        
        $situacoes = consultaSituacoes(98310);
    ?>
    <div class="container my-3">
        <h2>Pedidos/Orçamentos</h2>
    </div>
    <div class="container mb-4">
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-3">
                    <label for="dataInicial">Data inicial</label>
                    <input type="date" class="form-control" name="dataInicial" id="dataInicial" value="<?= $dataInicial ?>">
                </div>
                <div class="col-sm-3">
                    <label for="dataFinal">Data Final</label>
                    <input type="date" class="form-control" name="dataFinal" id="dataFinal" value="<?= $dataFinal ?>">
                </div>
                <div class="col-sm-3">
                    <label for="numeroPedido">Número do pedido</label>
                    <input type="number" class="form-control" name="numeroPedido" id="numeroPedido" value="<?= $numeroPedido ?>">
                </div>
                <div class="col-sm-3">
                    <label for="situacao">Situação:</label>
                    <select class="form-select" id="situacao" name="situacao">
                        <option value="">Todos</option>
                        <?php
                            if(isset($situacoes)){
                                foreach($situacoes['data'] as $situacao){
                                    ?>
                                    <option <?php if($situacaoPedido == $situacao['id']){echo "selected";} ?> value="<?= $situacao['id'] ?>"><?= $situacao['nome'] ?></option>;
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <input type="submit" value="Buscar" class="btn btn-primary mt-1">
                    <a href="novo_orcamento.php" class="btn btn-primary ms-4 mt-1" role="button">Novo Orçamento</a>
                    <a href="consulta_cnpj.php" class="btn btn-primary mt-1" role="button">Consultar CNPJ</a>
                    <a href="consulta_contato.php" class="btn btn-primary mt-1" role="button">Consultar Contatos</a>
                </div>
            </div>
        </form>
    </div>
    <div>
        <div class="container">
            <?php
                //Quering Bling orders by API
                ordersQuery();
                
                function consultaSituacoes($idModulo){
                    $jsonFile = file_get_contents('config/token_request_response.json');
                    $jsonData = json_decode($jsonFile, true);
                    $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
                    $endPoint = "https://api.bling.com.br/Api/v3/situacoes/modulos/$idModulo";
                    
                    $cURL = curl_init($endPoint);
                    $headers = array(
                        'Authorization: Bearer '.$token
                    );
                    
                    curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
                    $response2 = curl_exec($cURL);
                    curl_close($cURL);
                    $jsonData = json_decode($response2, true);
                    
                    echo "<script>console.log('funcao ConsultaSituacoes')</script>";
                    echo "<script>console.log($response2)</script>";

                    
                    //verify and refresh token
                    if(isset($jsonData['error']['type']) && $jsonData['error']['type'] === "invalid_token"){
                        require('controller/token_refresh.php');
                        echo "<script>console.log('Token atualizado')</script></p>";
                        return consultaSituacoes($idModulo);
                    }else if(isset($jsonData['data']) && $jsonData['data'] == null) {
                        echo "<hr><p>Nenhum pedido encontrado baseado nos filtros atuais</p>";
                        // echo $jsonData;
                    }else if(count($jsonData['data']) > 0){
                        return $jsonData;
                    } else {
                        echo "<script>console.log('Nenhum status encontrado')</script>";
                    };
                };
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
                    $response = curl_exec($cURL);
                    curl_close($cURL);
                    $data = json_decode($response, true);
                    
                    //verify and refresh token
                    if(isset($data['error']['type']) && $data['error']['type'] === "invalid_token"){
                        require('controller/token_refresh.php');
                        echo "<p>Token atualizado</p>";
                        ordersQuery();
                    } else if(isset($data['data']) && $data['data'] == null) {
                        echo "<hr><p>Nenhum pedido encontrado baseado nos filtros atuais</p>";
                        // echo $jsonData;
                    } else {
                        // echo $response;
                        ?>
                            <div>
                                <table class="table table-sm table-hover">
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
                                            // /situacoes/modulos/
                                            foreach($data['data'] as $row){
                                                global $situacoes;
                                                $pedidoId = $row['id'];

                                                //Abrir o orçamento em uma nova guia ao clincar na linha do pedido
                                                echo "<tr onclick=\"window.location.href='pedido_visualizacao.php?pedidoId=$pedidoId'; return false;\" style=\"cursor: pointer;\">";
                                                
                                                echo "<td>" . $row['numero'] . "</td>";
                                                echo "<td>" . date('d/m/Y', strtotime($row['data'])) . "</td>";
                                                echo "<td>" . $row['contato']['nome'] . "</td>";
                                                echo "<td>R$" . number_format($row['total'], 2, ',', '.') . "</td>";
                                                $situacaoPedidoId = $row['situacao']['id'];
                                                if(isset($situacoes['data']) && $situacoes['data'] > 0) {
                                                    foreach($situacoes['data'] as $situacao){
                                                        if($situacaoPedidoId == $situacao['id']){
                                                            ?>
                                                            <td><?= $situacao['nome'] ?></td>
                                                            <?php
                                                        }
                                                    }
                                                }
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
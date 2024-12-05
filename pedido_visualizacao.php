<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Orçamento</title>
    <style>
        body {
            font-size: 0.9em;
        }
        .buttons {
            max-width: 800px;
            margin: 0 auto;
        }
        .printView {
            max-width: 800px;
            margin: 0 auto;
        }
        @media print {
            body {
                /* Para impressão em cores exatas */
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body><!--onload="window.print()"-->
    <?php
        require('controller/login_checker.php');
        $numeroPedido = isset($_GET['numero'])?$_GET['numero']:"";
        $urlData = "&numero=".$numeroPedido;

        //Pega as informações do pedido via API para preencher o orçamento
        orderDataQuery();
        function orderDataQuery(){
            global $jsonData;

            $pedidoId = isset($_GET['pedidoId'])?$_GET['pedidoId']:"";
            $jsonFile = file_get_contents('config/token_request_response.json');
            $jsonData = json_decode($jsonFile, true);
            $endPoint = "https://api.bling.com.br/Api/v3/pedidos/vendas/$pedidoId";
            $token = isset($jsonData['access_token'])?$jsonData['access_token']:"No";
            
            $cURL = curl_init($endPoint);
            $headers = array(
                'Authorization: Bearer '.$token
            );
            curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($cURL);
            curl_close($cURL);
            $jsonData = json_decode($response, true);

            // echo "<p>$response</p>";
            // print_r($jsonData['data']['itens']);
            
            //verify and refresh token
            if(isset($data['error']['type']) && $data['error']['type'] === "invalid_token"){
                require('controller/token_refresh.php');
                echo "<p>Token atualizado</p>";
                ordersQuery();
                curl_close($cURL);
            } else if($jsonData['data'] == null) {
                echo "<hr>Nenhum pedido encontrado baseado nos filtros atuais";
                curl_close($cURL);
            } else {
                echo "<script>console.log($response)</script>";
                global $numeroPedido;
                global $totalProdutos;
                global $totalPedido;
                global $valorDesconto;
                global $tipoDesconto;

                $numeroPedido = $jsonData['data']['numero'];
                $totalProdutos = $jsonData['data']['totalProdutos'];
                $totalPedido = $jsonData['data']['total'];
                $valorDesconto = $jsonData['data']['desconto']['valor'];
                $tipoDesconto = $jsonData['data']['desconto']['unidade'];

                foreach($jsonData as $row){
                    global $clienteNome;
                    global $endereco;
                    global $bairro;
                    global $numero;
                    global $municipio;
                    global $uf;
                    global $dataPedido;
                    global $totalProdutos;

                    $clienteNome = isset($row['contato']['nome'])?$row['contato']['nome']:"";
                    $endereco = isset($row['transporte']['etiqueta']['endereco'])?$row['transporte']['etiqueta']['endereco']:"";
                    $bairro = isset($row['transporte']['etiqueta']['bairro'])?$row['transporte']['etiqueta']['bairro']:"";
                    $numero = isset($row['transporte']['etiqueta']['numero'])?$row['transporte']['etiqueta']['numero']:"";
                    $municipio = isset($row['transporte']['etiqueta']['municipio'])?$row['transporte']['etiqueta']['municipio']:"";
                    $uf = isset($row['transporte']['etiqueta']['uf'])?$row['transporte']['etiqueta']['uf']:"";
                    $dataPedido = isset($row['data'])?date('d/m/Y',strtotime($row['data'])):"";
                }
            }
        }

    ?>
    <script>
        document.title = 'Orçamento n. <?= $numeroPedido ?> - <?= $clienteNome ?>';
    </script>
    
    <div class="py-2 mb-4 d-print-none shadow fixed-top bg-white">
        <div class="buttons">
            <a href="orcamentos.php" class="btn btn-primary ms-2">Voltar</a>
            <a href="editar_orcamento.php?pedidoId=<?= $_GET['pedidoId'] ?>" class="btn btn-primary">Editar</a>
            <a href="" class="btn btn-primary" onclick="window.print(); return false;">Imprimir</a>

        </div>
    </div>
    <div class="d-print-none" style="height: 70px;"></div>
    <?= $tituloDaPagina ?>
    <div class="printView">
        <!-- Área do cabeçalho -->
        <div class="row align-items-center">
            <!-- Dados do cliente -->
            <div class="col-8">
                <div class="row">
                    <div class="col">Cliente: <strong><?= $clienteNome ?></strong></div>
                </div>
                <div class="row">
                    <div class="col">Endereço: <strong><?= $endereco ?></strong></div>
                </div>
                <div class="row">
                    <div class="col">Bairro: <strong><?= $bairro ?></strong></div>
                    <div class="col-4">Número: <strong><?= $numero ?></strong></div>
                </div>
                <div class="row">
                    <div class="col-8">Município: <strong><?= $municipio ?></strong></div>
                    <div class="col-4">Estado: <strong><?= $uf ?></strong></div>
                </div>
                <div class="row">
                    <div class="col">Data: <strong><?= $dataPedido ?></strong></div>
                </div>
            </div>

            <!-- Logo -->
            <div class="col-4 text-end">
                <img class="logo img-fluid" src="assets/img/logo.png" alt="Logo">
            </div>
        </div>

        <!-- Número do orçamento -->
        <div class="row mt-3 mx-0 bg-dark text-white">
            <div class="col text-center fs-5">
                Número do orçamento: <strong><?= $numeroPedido ?></strong>
            </div>
        </div>

        <!-- Tabela de produtos -->
        <table class="table table-bordered table-sm text-center mt-3 mb-1" id="tabelaProdutos">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Material</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
                    <!-- <th>Valor Unitário</th> -->
                    <!-- <th>Valor Total</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                    $subTotal = 0;
                    foreach($jsonData['data']['itens'] as $item){

                        $codigo = isset($item['codigo'])?$item['codigo']:"";
                        $material = isset($item['descricao'])?$item['descricao']:"";
                        $unidade = isset($item['unidade'])?$item['unidade']:"";
                        $quantidade = isset($item['quantidade'])?$item['quantidade']:"";
                        $valorUnit = isset($item['valor'])?$item['valor']:"";
                        $valorTotal = $item['quantidade'] * $item['valor'];
                ?>
                       <tr>
                            <td><?= $codigo ?></td>
                            <td><?= $material ?></td>
                            <td><?= $unidade ?></td>
                            <td><?= number_format($quantidade, 2, ",", ".") ?></td>
                            <!-- <td>R$<?= number_format($valorUnit, 2, ",", ".") ?></td> -->
                            <!-- <td>R$<?= number_format($valorTotal, 2, ",", ".") ?></td> -->
                        </tr>
                <?php
                    }
                ?>
                
            </tbody>
        </table>
        <div class="row mx-0 mt-1 me-0">
            <div class="col-7"></div>
            <div class="border col row mx-0">
                <div class="col py-1">Subtotal:</div>
                <div class="col py-1">R$<?= number_format($totalProdutos, 2, ",", ".") ?></div>

            </div>
        </div>
        <?php
            if(isset($valorDesconto) && $valorDesconto > 0){
                ?>
                <div class="row mx-0 mt-1 me-0">
                    <div class="col-7"></div>
                    <div class="border col row mx-0">
                        <div class="col py-1">Desconto:</div>
                            <?php
                                if(isset($tipoDesconto) && $tipoDesconto == "REAL"){
                            ?>
                            <div class="col py-1">R$<?= number_format($totalProdutos, 2, ",", ".") ?></div>
                            <?php
                                }else if(isset($tipoDesconto) && $tipoDesconto == "PERCENTUAL"){
                            ?>
                            <div class="col py-1"><?= $valorDesconto ?>%</div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                <?php
            }
        ?>
        <div class="row mx-0 mt-1 me-0">
            <div class="col-5"></div>
            <div class="col-7 row mx-0 bg-dark text-white">
                <div class="col py-1"><strong><?= isset($valorDesconto) && $valorDesconto > 0 ?"Valor Total:":"Total em até 12x no cartão:"; ?></strong></div>
                <div class="col-4 py-1"><strong>R$<?= number_format($totalPedido, 2, ",", ".") ?></strong></div>

            </div>
        </div>
        <?php
        // $numeroPedido
        // $totalProdutos
        // $totalPedido
        // $valorDesconto
        // $tipoDesconto

        ?>
        <div class="mt-5">
            <p class="fs-7">
                Este orçamento poderá ter variação para mais ou para menos em seu valor final, pois após aprovação, um dos profissionais da Invictos Portas irá até o seu estabelecimento fazer a conferência das medidas, para que sua porta de enrolar seja fabricada na medida exata.
            </p>
            <p class="text-center">
                C S Silva Portas Automáticas LTDA / Rua Ceará, 310, Fazenda Sobradinho, Magé/RJ, CEP: 25.932-145
            </p>
            <p class="text-center">
                (21) 97200-1200 / (21) 99827-2006 <br>@invictosportasautomaticas / admin@invictosportas.com.br
            </p>
        </div>
    </div>
    
</body>
</html>
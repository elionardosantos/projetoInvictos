<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Orçamento</title>
    <style>
        body {
            margin: 5px;
            
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
            $jsonData = json_decode($response, true);

            // echo "<p>$response</p>";
            // print_r($data['data']['itens']);
            
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
                // echo "<p>$response</p>";
                global $numeroPedido;
                $numeroPedido = $jsonData['data']['numero'];
                
                foreach($jsonData as $row){
                    global $clienteNome;
                    global $clienteId;
                    global $data;
                    global $numeroPedido;

                    $clienteNome = isset($row['contato']['nome'])?$row['contato']['nome']:"Nada";
                    $data = isset($row['data'])?date('d/m/Y',strtotime($row['data'])):"";
                }
                curl_close($cURL);
            }
        }
    ?>
    <div class="py-2 mb-4 d-print-none">
        <a href="" class="btn btn-primary" onclick="window.close()">Fechar</a>
        <a href="" class="btn btn-primary">Editar</a>
        <a href="" class="btn btn-primary" onclick="window.print()">Imprimir</a>
    </div>
    <div class="">
        <!-- Área do cabeçalho -->
        <div class="row align-items-center">
            <!-- Dados do cliente -->
            <div class="col-8">
                <div class="row">
                    <div class="col">Cliente: <strong><?= $clienteNome ?></strong></div>
                </div>
                <div class="row">
                    <div class="col">Endereço: <strong>-</strong></div>
                </div>
                <div class="row">
                    <div class="col">Bairro: <strong>-</strong></div>
                    <div class="col-4">Número: <strong>-</strong></div>
                </div>
                <div class="row">
                    <div class="col-8">Município: <strong>-</strong></div>
                    <div class="col-4">Estado: <strong>-</strong></div>
                </div>
                <div class="row">
                    <div class="col">Data: <strong></strong></div>
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
        
        <!-- Tabela de dados do orçamento -->
        <table class="table table-sm table-bordered mt-3 text-center">
            <thead class="table-dark">
                <tr>
                    <th>Quantidade</th>
                    <th>Largura (m)</th>
                    <th>Altura (m)</th>
                    <th>Rolo (m)</th>
                    <th>m²</th>
                    <th>Peso Total (kg)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1,42</td>
                    <td>2,20</td>
                    <td>0,50</td>
                    <td>3,83</td>
                    <td>46,01</td>
                </tr>
            </tbody>
        </table>

        <!-- Tabela de produtos -->
        <table class="table table-bordered table-sm text-center mt-3 mb-1">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Material</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <td>10</td>
                    <td>Guia 50 x 30</td>
                    <td>ml</td>
                    <td>4,50</td>
                    <td>R$ 64,00</td>
                    <td>R$ 288,00</td>
                </tr> -->
                <?php
                    // print_r($jsonData['data']);
                    foreach($jsonData['data']['itens'] as $item){
                        $codigo = isset($item['codigo'])?$item['codigo']:"";
                        $material = isset($item['descricao'])?$item['descricao']:"";
                        $unidade = isset($item['unidade'])?$item['unidade']:"";
                        $quantidade = isset($item['quantidade'])?$item['quantidade']:"";
                        $valorUnit = isset($item['valor'])?$item['valor']:"";
                ?>
                    <tr>
                        <td><?= $codigo ?></td>
                        <td><?= $material ?></td>
                        <td><?= $unidade ?></td>
                        <td><?= $quantidade ?></td>
                        <td>R$<?= $valorUnit ?></td>
                        <td>R$<?= $quantidade * $valorUnit ?></td>
                    </tr>
                <?php
                    }
                ?>
                
            </tbody>
        </table>
        <div class="row mx-0 mt-1">
            <div class="col-7"></div>
            <div class="col-3 bg-dark text-white py-1">Subtotal:</div>
            <div class="col-2 bg-dark text-white py-1"><strong>R$2.800,00</strong></div>
        </div>
        

         <!-- Tabela de Serviços -->
         <table class="table table-bordered table-sm text-center mt-3 mb-1">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Serviço</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>3</td>
                    <td>Alçapão</td>
                    <td>Und</td>
                    <td>1</td>
                    <td>R$400,00</td>
                    <td>R$400,00</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Pintura eletrostática</td>
                    <td>m²</td>
                    <td>18,20</td>
                    <td>R$60,00</td>
                    <td>R$1.092,00</td>
                </tr>
                <tr>
                    <td>200</td>
                    <td>Mão de Obra Instalação até 100 km</td>
                    <td>Un</td>
                    <td>1,00</td>
                    <td>R$1.500,00</td>
                    <td>R$1.500,00</td>
                </tr>
            </tbody>
        </table>
        <div class="row mx-0 mt-1">
            <div class="col-7"></div>
            <div class="col-3 bg-dark text-white py-1">Subtotal:</div>
            <div class="col-2 bg-dark text-white py-1"><strong>R$2.950,00</strong></div>
        </div>
        <table class="table table-bordered mt-3 text-center table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Total sem desconto</th>
                    <th>Desconto</th>
                    <th>Total com desconto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>R$5.750,00</th>
                    <th>R$15%</th>
                    <th>R$5.420,00</th>
                </tr>
            </tbody>
        </table>
        <div>
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
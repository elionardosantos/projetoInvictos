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
            .page-break {
                page-break-before: always; /* Insere uma quebra antes do elemento */
            }
        }
    </style>
</head>
<body><!--onload="window.print()"-->
    <?php
        require('controller/login_checker.php');
        $numeroPedido = isset($_GET['numero'])?$_GET['numero']:"";
        $urlData = "&numero=".$numeroPedido;

        function orderDataQuery(){ //Pega as informações do pedido via API para preencher o orçamento
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

            echo "<script>console.log(".$response.")</script>";
            
            //verify and refresh token
            if(isset($data['error']['type']) && $data['error']['type'] === "invalid_token"){
                require('controller/token_refresh.php');
                echo "<p>Token atualizado</p>";
                ordersQuery();
                curl_close($cURL);
            } else if(!isset($jsonData['data'])) {
                ?>
                    <div class="container mt-5" style="max-width: 820px;">
                        <hr>    
                        <div class="alert alert-danger">Pedido não encontrado</div>
                    </div>
                <?php
                curl_close($cURL);
            } else {
                // echo "<script>console.log($response)</script>";
                global $numeroPedido;
                global $totalProdutos;
                global $totalPedido;
                global $valorDesconto;
                global $tipoDesconto;
                global $itensPedido;

                $numeroPedido = $jsonData['data']['numero'];
                $totalProdutos = $jsonData['data']['totalProdutos'];
                $totalPedido = $jsonData['data']['total'];
                $valorDesconto = $jsonData['data']['desconto']['valor'];
                $tipoDesconto = $jsonData['data']['desconto']['unidade'];
                $outrasDespesas = $jsonData['data']['outrasDespesas'];
                $itensPedido = $jsonData['data']['itens'];

                foreach($jsonData as $row){
                    global $clienteNome;
                    global $endereco;
                    global $bairro;
                    global $numero;
                    global $municipio;
                    global $uf;
                    global $dataPedido;
                    global $totalProdutos;
                    global $observacoes;

                    $clienteNome = isset($row['contato']['nome'])?$row['contato']['nome']:"";
                    $endereco = isset($row['transporte']['etiqueta']['endereco'])?$row['transporte']['etiqueta']['endereco']:"";
                    $bairro = isset($row['transporte']['etiqueta']['bairro'])?$row['transporte']['etiqueta']['bairro']:"";
                    $numero = isset($row['transporte']['etiqueta']['numero'])?$row['transporte']['etiqueta']['numero']:"";
                    $municipio = isset($row['transporte']['etiqueta']['municipio'])?$row['transporte']['etiqueta']['municipio']:"";
                    $uf = isset($row['transporte']['etiqueta']['uf'])?$row['transporte']['etiqueta']['uf']:"";
                    $dataPedido = isset($row['data'])?$row['data']:"";
                    $observacoes = isset($row['observacoes'])?$row['observacoes']:"";
                }
            }
        }
        
        function categsListing() {
            require('config/connection.php');
            $sql = "SELECT `id`,`name`,`indice`,`ativo` FROM `categorias_produtos` WHERE `deleted` = :deleted AND `ativo` = 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':deleted', 0);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        };
        function itensListing(){
            require('config/connection.php');
            $sql = "SELECT
                        `id`,
                        `codigo`,
                        `titulo`,
                        `categoria`
                    FROM `produtos`
                    WHERE `deleted` = :deleted";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':deleted', 0);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        function setaCategoria($itensPedido,$dadosCategorias,$dadosItens){
            
            foreach($itensPedido as &$itemPedido){

                foreach($dadosItens as $itemBd){

                    $itemPedido['categoria'] = "";

                    if($itemPedido['codigo'] == $itemBd['codigo']){
                        $itemPedido['categoria'] = $itemBd['categoria'];
                        break;
                    }
                }
                foreach($dadosCategorias as $categ){
                    
                    $itemPedido['indice'] = "";
                    
                    if($categ['id'] == $itemPedido['categoria']){
                        $itemPedido['indice'] = $categ['indice'];
                        break;
                    }
                }
            }
            foreach($itensPedido as &$itemPedido){ //Jogando os sem categoria para o final
                if($itemPedido['indice'] == ""){
                    $itemPedido['indice'] = 9999;
                }
            }

            usort($itensPedido, function($a, $b) {
                return $a['indice'] <=> $b['indice']; // Ordenação crescente pelo indice
            });

            return $itensPedido;
        }


        $dadosCategorias = categsListing();
        $dadosItens = itensListing();

        orderDataQuery(); //Pega as informações do pedido via API para preencher o orçamento
        $itensPedido = setaCategoria($itensPedido,$dadosCategorias,$dadosItens);

            
    ?>
    <script>
        document.title = 'Orçamento n. <?= $numeroPedido ?> - <?= $clienteNome ?>';
    </script>
    
    <div class="py-2 mb-4 d-print-none shadow fixed-top bg-white">
        <div class="buttons">
            <a href="orcamentos.php" class="btn btn-primary ms-2">Voltar</a>
            <!-- <a href="editar_orcamento.php?pedidoId=<?= $_GET['pedidoId'] ?>" class="btn btn-primary">Editar</a> -->
            <a href="" class="btn btn-primary" onclick="window.print(); return false;">Imprimir orçamento</a>

        </div>
    </div>

    <!-- Espaço para distanciar dos botões do topo -->
    <div class="d-print-none" style="height: 70px;"></div>
    <div class="printView">

        <!-- Área do cabeçalho -->
        <div class="row">
            <!-- Logo -->
            <div class="col">
                <a href="https://www.invictosportas.com.br" style="text-decoration: none; color: black">
                    <img class="logo img-fluid" src="assets/img/logo.png" alt="Logo">
                </a>
            </div>
            
            <!-- Dados da empresa -->
            <div class="col">
                <div class="row">
                    <div class="col"><strong>INVICTOS PORTAS AUTOMATICAS</strong></div>
                </div>
                <div class="row">
                    <a href="https://www.invictosportas.com.br" style="text-decoration: none; color: black">
                        <div class="col"><img src="assets/img/globe-americas.svg"> www.invictosportas.com.br</div>
                    </a>
                </div>
                <div class="row">
                    <a href="mailto:admin@invictosportas.com.br" style="text-decoration: none; color: black">
                        <div class="col"><img src="assets/img/envelope.svg"> admin@invictosportas.com.br</div>
                    </a>
                </div>
                <div class="row">
                    <a href="https://www.instagram.com/invictosportasautomaticas" style="text-decoration: none; color: black">
                        <div class="col"><img src="assets/img/instagram.svg"> @invictosportasautomaticas</div>
                    </a>
                </div>
                <div class="row">
                    <a href="https://wa.me/5521972001200" style="text-decoration: none; color: black">
                        <div class="col"><img src="assets/img/whatsapp.svg"> (21) 97200-1200</div>
                    </a>
                </div>
                <div class="row">
                    <a href="https://wa.me/5521998272006" style="text-decoration: none; color: black">
                        <div class="col"><img src="assets/img/whatsapp.svg"> (21) 99827-2006</div>
                    </a>
                </div>
            </div>


        </div>

        <!-- Número do orçamento -->
        <div class="row mt-3 mx-0 bg-dark text-white">
            <div class="col text-center fs-5">
                Número do orçamento: <strong><?= $numeroPedido ?></strong>
            </div>
        </div>

            <!-- Dados do cliente -->
            <div class="col mt-2">
                <?php if(isset($clienteNome) && $clienteNome !== ""){ ?>
                    <div class="row">
                        <div class="col">Cliente: <strong><?= isset($clienteNome)?$clienteNome:""; ?></strong></div>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if(isset($endereco) && $endereco !== ""){ ?>
                        <div class="col-7">Endereço: <strong><?= isset($endereco)?$endereco:""; ?></strong></div>
                    <?php } ?>
                    <?php if(isset($numero) && $numero !== ""){ ?>
                        <div class="col">Número: <strong><?= isset($numero)?$numero:""; ?></strong></div>
                    <?php } ?>
                    <?php if(isset($uf) && $uf !== ""){ ?>
                        <div class="col">Estado: <strong><?= isset($uf)?$uf:""; ?></strong></div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if(isset($municipio) && $municipio !== ""){ ?>
                        <div class="col-7">Município: <strong><?= isset($municipio)?$municipio:""; ?></strong></div>
                    <?php } ?>
                    <?php if(isset($bairro) && $bairro !== ""){ ?>
                        <div class="col">Bairro: <strong><?= isset($bairro)?$bairro:""; ?></strong></div>
                    <?php } ?>
                </div>
                <!-- <?php if(isset($dataPedido) && $dataPedido !== ""){ ?>
                    <div class="row">
                        <div class="col">Data: <strong><?= isset($dataPedido)?$dataPedido:""; ?></strong></div>
                    </div>
                <?php } ?> -->
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
                    if(isset($jsonData['data']['itens'])){

                        foreach($itensPedido as $item){

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
                    }else{
                        echo "Nenhum item encontrado";
                    }
                ?>
                
            </tbody>
        </table>
        <?php
            if($totalProdutos > $totalPedido){
                ?>
                    <div class="row mx-0 mt-1 me-0">
                        <div class="col-7"></div>
                        <div class="border col row mx-0">
                            <div class="col py-1">Subtotal:</div>
                            <div class="col py-1">R$<?= isset($totalProdutos)?number_format($totalProdutos, 2, ",", "."):"" ?></div>
            
                        </div>
                    </div>
                <?php
            }
        ?>
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
                            <div class="col py-1">R$<?= number_format($valorDesconto, 2, ",", ".") ?></div>
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
            }elseif(isset($outrasDespesas) && $outrasDespesas > 0){
                ?>
                    <div class="row mx-0 mt-1 me-0">
                    <div class="col-7"></div>
                    <div class="border col row mx-0">
                        <div class="col py-1">Outras despesas:</div>
                            <div class="col py-1">R$<?= number_format($outrasDespesas, 2, ",", ".") ?></div>
                        </div>
                    </div>

                <?php
            }
        ?>
        <div class="row mx-0 mt-1 me-0">
            <div class="col-5"></div>
            <div class="col-7 row mx-0 bg-dark text-white mt-2">
                <!-- <div class="col py-1"><strong><?= isset($valorDesconto) && $valorDesconto > 0 ?"Valor Total:":"Total no cartão em até 12x:"; ?></strong></div> -->
                <div class="col py-1"><strong><?= isset($valorDesconto) && $valorDesconto > 0 ?"Valor total com desconto:":"Valor total:"; ?></strong></div>
                <div class="col-4 py-1"><strong>R$<?= isset($totalPedido)?number_format($totalPedido, 2, ",", "."):""; ?></strong></div>

            </div>
        </div>

        <?php
        if(isset($observacoes) && $observacoes !== ""){
        ?>
            <table class="table table-bordered table-sm text-center mt-3 mb-1">
                <thead class="table-dark">
                    <tr>
                        <th>
                            Observações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $observacoes ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php
        }
        ?>

        <div class="row text-center mt-3">
            <div class="col">Data do orçamento: <strong><?= isset($dataPedido)?date('d/m/Y',strtotime($dataPedido)):""; ?></strong></div>
            <div class="col">Orçamento válido até: <strong><?= isset($dataPedido)?date('d/m/Y',strtotime($dataPedido . '+15 days')):""; ?></strong></div>
        </div>
        
        <div class="mt-4">
            <p class="fs-7">
                Este orçamento poderá ter variação para mais ou para menos em seu valor final, pois após aprovação, um dos profissionais da Invictos Portas irá até o seu estabelecimento fazer a conferência das medidas, para que sua porta de enrolar seja fabricada na medida exata.
                Orçamento válido por 30 dias após a data de emissão.
            </p>
            <p class="text-center">
                C S Silva Portas Automáticas LTDA / Rua Ceará, 310, Fazenda Sobradinho, Magé/RJ, CEP: 25.932-145
            </p>
            <!-- <p class="text-center">
                (21) 97200-1200 / (21) 99827-2006 <br>@invictosportasautomaticas / admin@invictosportas.com.br
            </p> -->
        </div>
        <!-- <div class="page-break"></div> -->
    </div>

    <!-- <div class="container">
        <?php
        
        echo "<pre>";
        print_r($itensPedido);
        print_r($dadosCategorias);
        print_r($dadosItens);
        echo "</pre>";
        
        
        ?>
    </div> -->
    
</body>
</html>
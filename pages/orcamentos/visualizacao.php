<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('../../partials/head.php'); ?>
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
        require('../../controller/login_checker.php');
        $numeroPedido = isset($_GET['numero'])?$_GET['numero']:"";
        $urlData = "&numero=".$numeroPedido;

        function orderDataQuery(){ //Pega as informações do pedido via API para preencher o orçamento
            global $jsonData;

            $pedidoId = isset($_GET['pedidoId'])?$_GET['pedidoId']:"";
            $jsonFile = file_get_contents('../../config/token_request_response.json');
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
            }else if($_GET['pedidoId'] == "") {
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
                global $numeroDocumento;
                global $tipoPessoa;
                global $contatoId;

                $contatoId = $jsonData['data']['contato']['id'];
                $numeroPedido = $jsonData['data']['numero'];
                $totalProdutos = $jsonData['data']['totalProdutos'];
                $totalPedido = $jsonData['data']['total'];
                $valorDesconto = $jsonData['data']['desconto']['valor'];
                $tipoDesconto = $jsonData['data']['desconto']['unidade'];
                // $outrasDespesas = $jsonData['data']['outrasDespesas'];
                $itensPedido = $jsonData['data']['itens'];
                $numeroDocumento = $jsonData['data']['contato']['numeroDocumento'];
                $tipoPessoa = $jsonData['data']['contato']['tipoPessoa'];

                foreach($jsonData as $row){
                    global $clienteNome;
                    global $responsavelLocalServico;
                    global $enderecoServico;
                    global $bairroServico;
                    global $numeroServico;
                    global $municipioServico;
                    global $ufServico;
                    global $dataPedido;
                    global $totalProdutos;
                    global $observacoes;
                    global $observacoesInternas;
                    

                    $clienteNome = isset($row['contato']['nome'])?$row['contato']['nome']:"";
                    
                    $responsavelLocalServico = isset($row['transporte']['etiqueta']['nome'])?$row['transporte']['etiqueta']['nome']:"";
                    $enderecoServico = isset($row['transporte']['etiqueta']['endereco'])?$row['transporte']['etiqueta']['endereco']:"";
                    $bairroServico = isset($row['transporte']['etiqueta']['bairro'])?$row['transporte']['etiqueta']['bairro']:"";
                    $numeroServico = isset($row['transporte']['etiqueta']['numero'])?$row['transporte']['etiqueta']['numero']:"";
                    $municipioServico = isset($row['transporte']['etiqueta']['municipio'])?$row['transporte']['etiqueta']['municipio']:"";
                    $ufServico = isset($row['transporte']['etiqueta']['uf'])?$row['transporte']['etiqueta']['uf']:"";
                    
                    $dataPedido = isset($row['data'])?$row['data']:"";
                    $observacoes = isset($row['observacoes'])?$row['observacoes']:"";
                    $observacoesInternas = isset($row['observacoesInternas'])?$row['observacoesInternas']:"";
                }
            }
        }

        function contatoQuery($contatoId){ //Pega as informações do contato via API para preencher o orçamento

            // $contatoId = $_GET['contatoId'];
            $jsonFile = file_get_contents('../../config/token_request_response.json');
            $jsonData = json_decode($jsonFile, true);
            $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
            $url = "https://api.bling.com.br/Api/v3/contatos/$contatoId";

            $headers = array(
                "authorization: Bearer " . $token
            );
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            
            echo "<script>console.log($response)</script>";
            $data = json_decode($response, true);

            // Atualizando token
            if(isset($data['error']['type']) && $data['error']['type'] === 'invalid_token'){
                require('../../controller/token_refresh.php');
            }

            global $contatoDocumento;
            global $contatoName;
            global $contatoStreet;
            global $contatoNumber;
            global $contatoDistrict;
            global $contatoCity;
            global $contatoState;
            global $contatoTipoPessoa;
            global $contatoEmail;
            global $contatoCelular;
            global $contatoTelefone;
            global $contatoZip;
            global $contatoInscricaoEstadual;

            $contatoTipoPessoa = $data['data']['tipo'];
            $contatoDocumento = $data['data']['numeroDocumento'];
            $contatoName = $data['data']['nome'];
            $contatoStreet = $data['data']['endereco']['geral']['endereco'];
            $contatoNumber = $data['data']['endereco']['geral']['numero'];
            $contatoDistrict = $data['data']['endereco']['geral']['bairro'];
            $contatoCity = $data['data']['endereco']['geral']['municipio'];
            $contatoZip = $data['data']['endereco']['geral']['cep'];
            $contatoState = $data['data']['endereco']['geral']['uf'];
            $contatoInscricaoEstadual = $data['data']['ie'];
            $contatoEmail = isset($data['data']['email'])?$data['data']['email']:"";
            $contatoCelular = isset($data['data']['celular'])?$data['data']['celular']:"";
            $contatoTelefone = isset($data['data']['telefone'])?$data['data']['telefone']:"";
        }
        
        function categsListing() {
            require('../../config/connection.php');
            $sql = "SELECT `id`,`name`,`indice`,`ativo` FROM `categorias_produtos` WHERE `deleted` = :deleted AND `ativo` = 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':deleted', 0);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        };
        function itensListing(){
            require('../../config/connection.php');
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

        isset($contatoId)?contatoQuery($contatoId):null; //Pega as informações do contato via API para preencher o orçamento
        if(isset($itensPedido) && $itensPedido !== ""){
            $itensPedido = setaCategoria($itensPedido,$dadosCategorias,$dadosItens);

        }

            
    ?>
    <script>
        document.title = 'Orçamento n. <?= $numeroPedido ?> - <?= $clienteNome ?>';
    </script>
    
    <div class="py-2 mb-4 d-print-none shadow fixed-top bg-white">
        <div class="buttons">
            <a href="listar.php" class="btn btn-primary">Voltar</a>
            <a href="#" class="btn btn-primary" onclick="window.print(); return false;">Imprimir</a>
            <a href="editar.php?pedidoId=<?= $_GET['pedidoId'] ?>" class="btn btn-primary" disabled>Editar</a>
            <a href="novo.php?contatoId=<?= $contatoId ?>" class="btn btn-primary">Novo (Mesmo cliente)</a>
            
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalExclusao">
                Excluir
            </button>

            <?php
                if(isset($_SESSION['login']['loggedUserLevel']) && $_SESSION['login']['loggedUserLevel'] >= 2){
                    ?>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSituacao">
                            Situação no Bling
                        </button>

                    <?php
                }
            ?>
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
                    <img class="logo img-fluid" src="../../assets/img/logo.png" alt="Logo">
                </a>
            </div>
            
            <!-- Dados da empresa -->
            <div class="col">
                <div class="row">
                    <div class="col"><strong>INVICTOS PORTAS AUTOMATICAS</strong></div>
                </div>
                <div class="row">
                    <a href="https://www.invictosportas.com.br" style="text-decoration: none; color: black">
                        <div class="col"><img src="../../assets/img/globe-americas.svg"> www.invictosportas.com.br</div>
                    </a>
                </div>
                <div class="row">
                    <a href="mailto:admin@invictosportas.com.br" style="text-decoration: none; color: black">
                        <div class="col"><img src="../../assets/img/envelope.svg"> admin@invictosportas.com.br</div>
                    </a>
                </div>
                <div class="row">
                    <a href="https://www.instagram.com/invictosportasautomaticas" style="text-decoration: none; color: black">
                        <div class="col"><img src="../../assets/img/instagram.svg"> @invictosportasautomaticas</div>
                    </a>
                </div>
                <div class="row">
                    <a href="https://wa.me/5521972001200" style="text-decoration: none; color: black">
                        <div class="col"><img src="../../assets/img/whatsapp.svg"> (21) 97200-1200</div>
                    </a>
                </div>
                <div class="row">
                    <a href="https://wa.me/5521998272006" style="text-decoration: none; color: black">
                        <div class="col"><img src="../../assets/img/whatsapp.svg"> (21) 99827-2006</div>
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
        <div>
            <div class="row mt-2 mx-0">
                <div class="col mx-0">
                    <div class="text-center border-bottom fs-5">
                        Dados do cliente
                    </div>
                    <div class="mx-0 mt-2">
                        <div>Nome: <b><?= isset($clienteNome)?$clienteNome:"" ?></b></div>
                        <div>Endereço: <b><?= isset($contatoStreet)?$contatoStreet:"" ?></b></div>
                        <div>Bairro: <b><?= isset($contatoDistrict)?$contatoDistrict:"" ?></b></div>
                        <div>Município: <b><?= isset($contatoCity)?$contatoCity:"" ?></b></div>
                        <div>Número: <b><?= isset($contatoNumber)?$contatoNumber:"" ?></b></div>
                        <div>Estado: <b><?= isset($contatoState)?$contatoState:"" ?></b></div>
                    </div>
                </div>
                <div class="col mx-0">
                    <div class="text-center border-bottom fs-5">
                        Local do serviço
                    </div>
                    <div class="mx-0 mt-2">
                        <div>Nome: <b><?= isset($responsavelLocalServico)?$responsavelLocalServico:"" ?></b></div>
                        <div>Endereço: <b><?= isset($enderecoServico)?$enderecoServico:"" ?></b></div>
                        <div>Bairro: <b><?= isset($bairroServico)?$bairroServico:"" ?></b></div>
                        <div>Município: <b><?= isset($municipioServico)?$municipioServico:"" ?></b></div>
                        <div>Número: <b><?= isset($numeroServico)?$numeroServico:"" ?></b></div>
                        <div>Estado: <b><?= isset($ufServico)?$ufServico:"" ?></b></div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if(isset($observacoesInternas) && $observacoesInternas !== ""){
                $dadosPorta = json_decode($observacoesInternas);

                $quantidadePorta = isset($dadosPorta->quantidade)?$dadosPorta->quantidade:null;
                $larguraPorta = isset($dadosPorta->largura)?$dadosPorta->largura:null;
                $alturaPorta = isset($dadosPorta->altura)?$dadosPorta->altura:null;
                $pesoPorta = isset($dadosPorta->peso)?$dadosPorta->peso:null;
            }
        ?>
        <div class="row mt-3 mx-0">
            <div class="col border">Quantidade: <b><?= isset($quantidadePorta)?$quantidadePorta:"" ?></b></div>
            <div class="col border">Largura:  <b><?= isset($larguraPorta)?$larguraPorta:"" ?></b></div>
            <div class="col border">Altura:  <b><?= isset($alturaPorta)?$alturaPorta:"" ?></b></div>
            <?php
                if(isset($pesoPorta) && $pesoPorta !== ""){
                    
                    ?>
                        <div class="col border">Peso:  <b><?= isset($pesoPorta)?number_format($pesoPorta, 2, ",", "."):"" ?> Kg</b></div>
                    <?php
                }
            ?>
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
                        // echo "Nenhum item encontrado";
                    }
                ?>
                
            </tbody>
        </table>
        <?php
            if(isset($totalPedido) && isset($totalProduto)){
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
                <div class="col py-1">
                    <strong>
                        <?= isset($valorDesconto) && $valorDesconto > 0 ?"Valor Total:":"Total no cartão em até 12x:"; ?>
                    </strong>
                </div>
                <!-- <div class="col py-1"><strong><?= isset($valorDesconto) && $valorDesconto > 0 ?"Valor total com desconto:":"Valor total:"; ?></strong></div> -->
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
        
        <div class="mt-4 mb-5">
            <p class="fs-7">
                Este orçamento poderá ter variação para mais ou para menos em seu valor final, pois após aprovação, um dos profissionais da Invictos Portas irá até o seu estabelecimento fazer a conferência das medidas, para que sua porta de enrolar seja fabricada na medida exata.
                Orçamento válido por 30 dias após a data de emissão.
            </p>
            <!-- <p class="text-center">
                C S Silva Portas Automáticas LTDA / Rua Ceará, 310, Fazenda Sobradinho, Magé/RJ, CEP: 25.932-145
            </p> -->
            <!-- <p class="text-center">
                (21) 97200-1200 / (21) 99827-2006 <br>@invictosportasautomaticas / admin@invictosportas.com.br
            </p> -->
        </div>
        


        <!-- GARANTIA -->

        <div class="page-break"></div>
        <div>
            <div class="row mt-3 mx-0 bg-dark text-white">
                <div class="col text-center fs-5">
                    Condições da garantia
                </div>
            </div>
            <div class="mt-4">
                <div class="fw-bold">
                    PERÍODO DA GARANTIA:
                </div>
                <div  class="mt-2">
                    - 1 ano
                </div>
            </div>
            <div class="mt-4">
                <div class="fw-bold">
                    PRAZOS DE GARANTIA:
                </div>
                <div  class="mt-2">
                    - 2 anos ano diretamente com o fabricante/importador conforme indicado na etiqueta do produto, sendo necessária a remoção do automatizador e avaliação e reparo - “garantia balcão”;<br>
                    - O prazo de garantia se inicia a partir da data de emissão da Nota Fiscal.
                </div>
            </div>
            <div class="mt-4">
                <div class="fw-bold">
                    PERDA DA GARANTIA:
                </div>
                <div  class="mt-2">
                    - Remoção do lacre de garantia;<br>
                    - Constatação de intervenção ou conserto realizado por terceiros não autorizados;<br>
                    - Instalação de acessórios não fornecidos ou incompatíveis com o equipamento;<br>
                    - Montagem ou utilização fora da especificação do fabricante;<br>
                    - Detecção de uso excessivo no número de acionamentos diários (4 acionamentos diários, exceto para automatizadores de tipo “alto fluxo”);<br>
                    - Constatação de inexistência de disjuntor exclusivo ou cabeamento inadequado;<br>
                    - Funcionamento fora das especificações do MANUAL DE INSTRUÇÕES;<br>
                    - Danos causados por intempéries (ações climáticas): descarga elétrica, maresia, infiltração de água no sistema elétrico, mecânico ou afins;<br>
                    - Danos físicos: sinais de queda/riscos, choque com veículo, incêndio, danos causados por terceiros, corrosão por produtos de químicos, ácido, detergentes e afins;

                </div>
            </div>
        </div>
        <div class="text-center mt-5 mb-5">
            <div class="fw-bold">
                Magé - <?= date('d/m/Y') ?>
            </div>
            <div class="row">
                <div class="col-6">
                    <img  style="height: 50px;" src="/assets/img/assinatura-sem-fundo.png" alt="">
                </div>
            </div>
            <div class="row" style="margin-top: -20px">
                <div class="col">
                    <div>_____________________________________________________</div>
                    <div class="fw-bold">INVICTOS PORTAS AUTOMÁTICAS</div>
                    <div>Cristiano Salomé da Silva</div>
                </div>
                <?php
                    if(isset($tipoPessoa)){
                        switch ($tipoPessoa) {
                            case 'F':
                                $tipoDocumento = "CPF";
                                break;
    
                            case 'J':
                                $tipoDocumento = "CNPJ";
                                break;
    
                            default:
                                $tipoDocumento = "";
                                break;
                        }
                    }
                ?>
                <div class="col">
                    <div>_____________________________________________________</div>
                    <div class="fw-bold text-uppercase"><?= isset($clienteNome)?$clienteNome:"" ?></div>
                    <div>
                        <?php
                            if(isset($numeroDocumento) && $numeroDocumento !== ""){
                                echo $tipoDocumento." ";
                            }
                            echo isset($numeroDocumento)?$numeroDocumento:"";
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <!-- MODAL PARA MUDANÇA DE STATUS DO ORÇAMENTO -->
    <div class="modal fade" id="modalSituacao" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="selecaoSituacaoTitulo">Situação</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div>
                <?php 
                    $pedidoId = isset($_GET['pedidoId'])?$_GET['pedidoId']:null;
                ?>
                <form action="situacao.php?pedidoId=<?=$pedidoId?>" method="get">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="d-none">
                                    <input type="text" name="pedidoId" id="" value="<?=$pedidoId?>">
                                </div>
                                <label for="situacao">Selecione uma nova situação para o pedido:</label>
                                <select class="form-select" id="situacaoId" name="situacaoId">
                                    <option value=""></option>
                                    <?php
                                        $situacoes = consultaSituacoes(98310);
                                        if(isset($situacoes) && count($situacoes)>0){
                                            $idSituacaoAtual = $jsonData['data']['situacao']['id'];
                                            foreach($situacoes['data'] as $situacao){
                                                if($situacao['id'] !== $idSituacaoAtual){
                                                    $selected = $situacao['id'] == $idSituacaoAtual?"selected":"";
                                                    ?>
                                                        <option <?= $selected ?> value="<?= $situacao['id'] ?>"><?= $situacao['nome'] ?></option>;
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Mudar situação</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>


    <!-- MODAL CONFIRMAÇÃO DE EXCLUSÃO DO ORÇAMENTO -->
    <div class="modal fade" id="modalExclusao" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Atenção</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php 
                        $pedidoId = isset($_GET['pedidoId'])?$_GET['pedidoId']:null;
                    ?>
                    <p>Tem certeza que deseja excluir este orçamento? Esta ação é irreversível.</p>

                    <a href="#" class="btn btn-primary" data-bs-dismiss="modal">Voltar</a>
                    <a class="btn btn-danger" href="excluir.php?pedidoId=<?= $pedidoId ?>">Sim</a>
                </div>
            </div>
        </div>
    </div>

    <?php
                
        function consultaSituacoes($idModulo){
            $jsonFile = file_get_contents('../../config/token_request_response.json');
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
            
            // echo "<script>console.log($response2)</script>";

            
            //verify and refresh token
            if(isset($jsonData['error']['type']) && $jsonData['error']['type'] === "invalid_token"){
                require('../../controller/token_refresh.php');
                echo "<script>console.log('Token atualizado')</script></p>";
                return consultaSituacoes($idModulo);
            }else if(isset($jsonData['data']) && $jsonData['data'] == null) {
                echo "<hr><p>Nenhum pedido encontrado baseado nos filtros atuais</p>";
                // echo $jsonData;
            }else if(isset($jsonData['data']) && count($jsonData['data']) > 0){
                return $jsonData;
            } else {
                echo "<script>console.log('Nenhum status encontrado')</script>";
            };
        };

    ?>
    
</body>
</html>
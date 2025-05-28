<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Editar Orçamento</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        // die('<div class="alert">Tela em desenvolvimento<div>');
    ?>
    <div class="container my-3">
        <h2>Editar Orçamento</h2>
    </div>
    <div class="container">
        <a href="" class="btn btn-primary mt-1" onclick="window.history.back(); return false;">Voltar</a>
    </div>
    <div class="container">
        <?php
        $pedidoId = isset($_GET['pedidoId'])?$_GET['pedidoId']:"";
        if(isset($_GET['pedidoId'])){
            $_SESSION['pedidoId'] = $_GET['pedidoId'];
            $dadosPedido = orderDataQuery($pedidoId);
        }


        if(isset($dadosPedido['itens']) && $dadosPedido['itens'] !== ""){
            foreach($dadosPedido['itens'] as $item){
                $itensDoPedido[$item['codigo']] = "selected";
            }
            $_SESSION['itensPedido'] = $itensDoPedido;
        }

        // print_r($_SESSION['itensPedido']);
        
        $_SESSION['numeroPedido'] = isset($dadosPedido['numero'])?$dadosPedido['numero']:"";
        
        $name = isset($dadosPedido['contato']['nome'])?$dadosPedido['contato']['nome']:"";
        $documento = isset($dadosPedido['contato']['numeroDocumento'])?$dadosPedido['contato']['numeroDocumento']:"";
        $tipoPessoa = isset($dadosPedido['contato']['tipoPessoa'])?$dadosPedido['contato']['tipoPessoa']:"";
        $contatoId = isset($dadosPedido['contato']['id'])?$dadosPedido['contato']['id']:"";
        $valorDesconto = isset($dadosPedido['desconto']['valor'])?$dadosPedido['desconto']['valor']:"";
        $tipoDesconto = isset($dadosPedido['desconto']['unidade'])?$dadosPedido['desconto']['unidade']:"";
        
        
        // Dados do local de serviço
        $cepServico = isset($dadosPedido['transporte']['etiqueta']['cep'])?$dadosPedido['transporte']['etiqueta']['cep']:"";
        $bairroServico = isset($dadosPedido['transporte']['etiqueta']['bairro'])?$dadosPedido['transporte']['etiqueta']['bairro']:"";
        $municipioServico = isset($dadosPedido['transporte']['etiqueta']['municipio'])?$dadosPedido['transporte']['etiqueta']['municipio']:"";
        $ufServico = isset($dadosPedido['transporte']['etiqueta']['uf'])?$dadosPedido['transporte']['etiqueta']['uf']:"";
        $enderecoServico = isset($dadosPedido['transporte']['etiqueta']['endereco'])?$dadosPedido['transporte']['etiqueta']['endereco']:"";
        $numeroServico = isset($dadosPedido['transporte']['etiqueta']['numero'])?$dadosPedido['transporte']['etiqueta']['numero']:"";
        $nomeServico = isset($dadosPedido['transporte']['etiqueta']['nome'])?$dadosPedido['transporte']['etiqueta']['nome']:"";
        $observacoes = isset($dadosPedido['observacoes'])?$dadosPedido['observacoes']:"";
        $observacoesInternas = isset($dadosPedido['observacoesInternas'])?$dadosPedido['observacoesInternas']:"";



        ########## Funções ############
         
        function orderDataQuery($pedidoId){
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
            if(isset($jsonData['error']['type']) && $jsonData['error']['type'] === "invalid_token"){
                require('controller/token_refresh.php');
                echo "<p>Token atualizado</p>";
                ordersQuery();
                curl_close($cURL);
            } else if(isset($jsonData['data']) && $jsonData['data'] == null) {
                echo "<hr>Houve um erro ao recuperar os dados do pedido";
                curl_close($cURL);
            } else {
                return $jsonData['data'];
            }
        } 
        function consultaContatoId($contatoId){
            if(isset($contatoId) && $contatoId !== ""){
                $url = "https://api.bling.com.br/Api/v3/contatos/$contatoId";
                $jsonFile = file_get_contents('config/token_request_response.json');
                $jsonData = json_decode($jsonFile, true);
                $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";
                $header = array(
                    "authorization: bearer " . $token
                );
                $cURL = curl_init($url);
                curl_setopt($cURL, CURLOPT_URL, $url);
                curl_setopt($cURL, CURLOPT_HTTPHEADER, $header);
                curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
            
                $response = curl_exec($cURL);
                $data = json_decode($response, true);
                
                echo "<script>console.log('Consulta contato por ID')</script>";
                echo "<script>console.log($response)</script>";
                
                if(isset($data['data']['id']) && $data['data']['id'] == $contatoId){
                    return $data['data'];
                }else{
                    return false;
                }
        
            }
        }

        ########## Fim das funções ############

        
        $dadosCliente = consultaContatoId($contatoId);

        $_SESSION['codigoContato'] = isset($dadosCliente['codigo'])?$dadosCliente['codigo']:"";
        ?>
    </div>
    
    <div class="container mt-4">
        <form action="editar_orcamento_itens.php" method="POST">

            <div class="mt-4"><h4>Dados cadastrais</h4></div>
            <div class="row">
                <div class="col-md-3 d-none">
                    <label for="contatoId" class="form-label mb-0 mt-2">ID</label>
                    <input type="text" class="form-control" name="contatoId" id="contatoId" value="<?= isset($dadosCliente['id'])?$dadosCliente['id']:""; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label for="cliente" class="form-label mb-0 mt-2">Nome completo / Razão social*</label>
                    <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Nome completo" value="<?= isset($dadosCliente['nome'])?$dadosCliente['nome']:""; ?>" required>
                </div>                
                <div class="col-md-4">
                    <label for="documento" class="form-label mb-0 mt-2">CPF/CNPJ*</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="documento" name="documento" placeholder="CPF ou CNPJ" value="<?= isset($dadosCliente['numeroDocumento'])?$dadosCliente['numeroDocumento']:""; ?>">
                </div>
                <div class="col-md-3">
                    <label for="tipoPessoa" class="form-label mb-0 mt-2">Tipo de pessoa</label>
                    <select class="form-select" id="tipodepessoa" name="tipoPessoa">
                        <option <?php if(isset($dadosCliente['tipo']) && $dadosCliente['tipo'] === "J"){echo "selected";} ?> value="J">Pessoa jurídica</option>
                        <option <?php if(isset($dadosCliente['tipo']) && $dadosCliente['tipo'] === "F"){echo "selected";} ?> value="F">Pessoa física</option>
                    </select>
                </div>                
                <div class="col-md-4">
                    <label for="inscricaoEstadual" class="form-label mb-0 mt-2">Inscrição estadual</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="inscricaoEstadual" name="inscricaoEstadual" placeholder="CPF ou CNPJ" value="<?= isset($inscricaoEstadual)?$inscricaoEstadual:""; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="cep" class="form-label mb-0 mt-2">CEP</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="cep" name="cep" placeholder="CEP" value="<?= isset($dadosCliente['endereco']['geral']['cep'])?$dadosCliente['endereco']['geral']['cep']:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="bairro" class="form-label mb-0 mt-2">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?= isset($dadosCliente['endereco']['geral']['bairro'])?$dadosCliente['endereco']['geral']['bairro']:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipio" class="form-label mb-0 mt-2">Município</label>
                    <input type="text" class="form-control" name="municipio" id="municipio" placeholder="Município" value="<?= isset($dadosCliente['endereco']['geral']['municipio'])?$dadosCliente['endereco']['geral']['municipio']:""; ?>">
                </div>
                <div class="col-md-2">
                    <label for="estado" class="form-label mb-0 mt-2">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <!-- <option selected>Escolha...</option> -->
                         <?php
                            // Lista de estados que irá aparecer no formulário
                            $estados = [
                                "RJ", "SP", "MG", "ES", 
                                "AC", "AL", "AP", "AM", 
                                "BA", "CE", "DF", "GO", 
                                "MA", "MT", "MS", "PA", 
                                "PB", "PR", "PE", "PI", 
                                "RN", "RS", "RO", "RR", 
                                "SC", "SE", "TO"
                            ];
                            foreach($estados as $uf){
                                if(isset($dadosCliente['endereco']['geral']['uf']) && $dadosCliente['endereco']['geral']    ['uf'] === "$uf"){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option value=\"$uf\" $selected>$uf</option>\n";
                            }
                         ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label for="endereco" class="form-label mb-0 mt-2">Endereço</label>
                    <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Rua, Avenida, etc." value="<?= isset($dadosCliente['endereco']['geral']['endereco'])?$dadosCliente['endereco']['geral']['endereco']:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="numero" class="form-label mb-0 mt-2">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="<?= isset($dadosCliente['endereco']['geral']['numero'])?$dadosCliente['endereco']['geral']['numero']:""; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="tabelaPreco" class="form-label mb-0 mt-2">Tabela</label>
                    <select class="form-select" id="tabelaPreco" name="tabelaPreco">
                        <option value="consumidor-final" selected>Consumidor final</option>
                        <option value="serralheiro" >Serralheiro</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="condicaoPagamento" class="form-label mb-0 mt-2">Condição de Pagto</label>
                    <select class="form-select" id="condicaoPagamento" name="condicaoPagamento">
                        <option selected>À vista</option>
                        <?php
                            for($i=1; $i<=12; $i++){
                               echo "<option value=\"cartao".$i."x\">Cartão $i"."x</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="desconto" class="form-label mb-0 mt-2">Valor do Desconto</label>
                    <input value="<?= isset($valorDesconto)?$valorDesconto:"" ?>" type="number" inputmode="numeric" id="desconto" name="desconto" class="form-control" placeholder="Somente números">
                </div>
                <div class="col-md-2">
                    <label for="tipoDesconto" class="form-label mb-0 mt-2">Tipo</label>
                    <select class="form-select" name="tipoDesconto">
                        <option <?= isset($tipoDesconto) && $tipoDesconto == "PERCENTUAL"?"selected":"" ?> value="PERCENTUAL">%</option>
                        <option <?= isset($tipoDesconto) && $tipoDesconto == "REAL"?"selected":"" ?> value="REAL" >R$</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4"><h4>Contato</h4></div>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="tel">Telefone</label>
                    <input class="form-control" type="tel" name="tel" id="tel" value="<?= $dadosCliente['telefone']?$dadosCliente['telefone']:"" ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="cel">Celular*</label>
                    <input class="form-control" type="tel" name="cel" id="cel" value="<?= isset($dadosCliente['celular'])?$dadosCliente['celular']:"" ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="email">email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?= isset($dadosCliente['email'])?$dadosCliente['email']:""; ?>">
                </div>
            </div>
            
            <div class="mt-4"><h4>Endereço do serviço</h4></div>
            <div class="row">
                <div class="col-md-2">
                    <label for="cepServico" class="form-label mb-0 mt-2">CEP</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="cepServico" name="cepServico" placeholder="CEP" value="<?= isset($cepServico)?$cepServico:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="bairroServico" class="form-label mb-0 mt-2">Bairro</label>
                    <input type="text" class="form-control" id="bairroServico" name="bairroServico" placeholder="Bairro" value="<?= isset($bairroServico)?$bairroServico:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipioServico" class="form-label mb-0 mt-2">Município</label>
                    <input type="text" class="form-control" name="municipioServico" id="municipioServico" placeholder="Município" value="<?= isset($municipioServico)?$municipioServico:""; ?>">
                </div>
                <div class="col-md-2">
                    <label for="estadoServico" class="form-label mb-0 mt-2">Estado</label>
                    <select class="form-select" id="estadoServico" name="estadoServico">
                        <!-- <option selected>Escolha...</option> -->
                        <?php
                            // Lista de estados que irá aparecer no formulário
                            $estados = [
                                "RJ", "SP", "MG", "ES", 
                                "AC", "AL", "AP", "AM", 
                                "BA", "CE", "DF", "GO", 
                                "MA", "MT", "MS", "PA", 
                                "PB", "PR", "PE", "PI", 
                                "RN", "RS", "RO", "RR", 
                                "SC", "SE", "TO"
                            ];
                            foreach($estados as $ufServico){
                                if(isset($state) && $state === "$ufServico"){
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option value=\"$ufServico\" $selected>$ufServico</option>\n";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="enderecoServico" class="form-label mb-0 mt-2">Endereço</label>
                    <input type="text" class="form-control" name="enderecoServico" id="enderecoServico" placeholder="Rua, Avenida, etc." value="<?= isset($enderecoServico)?$enderecoServico:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="numeroServico" class="form-label mb-0 mt-2">Número</label>
                    <input type="text" class="form-control" id="numeroServico" name="numeroServico" placeholder="Número" value="<?= isset($numeroServico)?$numeroServico:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="nomeServico" class="form-label mb-0 mt-2">Nome do responsável</label>
                    <input type="text" class="form-control" name="nomeServico" id="nomeServico" placeholder="Responsável no local" value="<?= isset($nomeServico)?$nomeServico:""; ?>">
                </div>
            </div>
            
            <?php 
                $dadosJsonObs = json_decode($observacoesInternas, true);
            ?>
            <div class="mt-4"><h4>Dados adicionais</h4></div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="observacoes" class="form-label mb-0 mt-2">Observações</label>
                    <textarea type="text" class="form-control" rows="3" name="observacoes" id="observacoes" placeholder="As informações digitadas aqui serão impressas no orçamento, na fatura e transferida para as observações da nota"><?= $observacoes ?></textarea>
                </div>
                <div class="col-md-6">
                    <label for="observacoesInternas" class="form-label mb-0 mt-2">Observações internas</label>
                    <textarea type="text" class="form-control" rows="3" id="observacoesInternas" name="observacoesInternas" style="color: blue;" placeholder="Esta área é de uso interno, portanto não será impressa"><?= isset($dadosJsonObs['obs'])?$dadosJsonObs['obs']:"" ?></textarea>
                </div>
            </div>
            
            <div class="mt-4"><h4>Dados da instalação</h4></div>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="quantidade">Quantidade*</label>
                    <input class="form-control" inputmode="numeric" name="quantidade" id="quantidade" value="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="largura">Largura*</label>
                    <input class="form-control" inputmode="numeric" name="largura" id="largura" value="<?= isset($dadosJsonObs['largura'])?$dadosJsonObs['largura']:"" ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="altura">Altura*</label>
                    <input class="form-control" inputmode="numeric" name="altura" id="altura" value="<?= isset($dadosJsonObs['altura'])?$dadosJsonObs['altura']:"" ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="rolo">Rolo*</label>
                    <input class="form-control" inputmode="numeric" name="rolo" id="rolo" value="0,5">
                </div>
            </div>

            <div class="my-5">
                <button type="submit" class="btn btn-primary">Continuar</button>
                <a href="orcamentos.php" class="btn btn-primary mx-2">Voltar</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cepInput = document.getElementById("cep");
            const enderecoInput = document.getElementById("endereco");
            const bairroInput = document.getElementById("bairro");
            const cidadeInput = document.getElementById("municipio");
            const estadoInput = document.getElementById("estado");

            cepInput.addEventListener("blur", function () {
                const cep = cepInput.value.replace(/\D/g, '');
                if (cep.length === 8) {
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                enderecoInput.value = data.logradouro || "";
                                bairroInput.value = data.bairro || "";
                                cidadeInput.value = data.localidade || "";
                                estadoInput.value = data.uf || "";

                                // enderecoInput.disabled = true;
                                // bairroInput.disabled = true;
                                // cidadeInput.disabled = true;
                                // estadoInput.disabled = true;

                            } else {
                                alert("CEP não encontrado.");
                            }
                        })
                        .catch(error => {
                            console.error("Erro ao consultar o CEP:", error);
                            alert("Erro ao consultar o CEP. Verifique a conexão com a internet.");
                        });
                } else {
                    alert("CEP inválido. Por favor, digite um CEP com 8 dígitos.");
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const cepServico = document.getElementById("cepServico");
            const enderecoServico = document.getElementById("enderecoServico");
            const bairroServico = document.getElementById("bairroServico");
            const cidadeServico = document.getElementById("municipioServico");
            const estadoServico = document.getElementById("estadoServico");

            cepServico.addEventListener("blur", function () {
                const cep = cepServico.value.replace(/\D/g, '');
                if (cep.length === 8) {
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(response => response.json())
                        .then(data => {
                            if (!data.erro) {
                                enderecoServico.value = data.logradouro || "";
                                bairroServico.value = data.bairro || "";
                                cidadeServico.value = data.localidade || "";
                                estadoServico.value = data.uf || "";

                                // enderecoServico.disabled = true;
                                // bairroServico.disabled = true;
                                // cidadeServico.disabled = true;
                                // estadoServico.disabled = true;

                            } else {
                                alert("CEP não encontrado.");
                            }
                        })
                        .catch(error => {
                            console.error("Erro ao consultar o CEP:", error);
                            alert("Erro ao consultar o CEP. Verifique a conexão com a internet.");
                        });
                } else {
                    alert("CEP inválido. Por favor, digite um CEP com 8 dígitos.");
                }
            });
        });
    </script>


</body>
</html>
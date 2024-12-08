<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Novo Orçamento</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
    ?>
    <div class="container my-3">
        <h2>Novo Pedido/Orçamento</h2>
    </div>
    <div class="container">
        <a href="" class="btn btn-primary mt-1" onclick="window.history.back(); return false;">Voltar</a>
        <a href="consulta_clientes.php" class="btn btn-primary mt-1" role="button">Consultar Clientes (Bling)</a>
        <a href="consulta_cnpj.php" class="btn btn-primary mt-1" role="button">Consultar CNPJ</a>
    </div>
    <div class="container">
        <?php
            global $cnpj;
            global $name;
            global $street;
            global $number;
            global $district;
            global $city;
            global $state;
            
            isset($_GET['cnpj'])?cnpjQuery():"";
            isset($_GET['contatoId'])?contatoQuery():"";

            function contatoQuery(){
                global $contatoId;

                $contatoId = $_GET['contatoId'];
                $jsonFile = file_get_contents('config/token_request_response.json');
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
                curl_close($ch);
                
                echo "<script>console.log($response)</script>";
                $data = json_decode($response, true);

                // Atualizando token
                if(isset($data['error']['type']) && $data['error']['type'] === 'invalid_token'){
                    require('controller/token_refresh.php');
                }

                global $documento;
                global $name;
                global $street;
                global $number;
                global $district;
                global $city;
                global $state;
                global $tipoPessoa;
                global $email;
                global $celular;
                global $telefone;
                global $zip;

                $tipoPessoa = $data['data']['tipo'];
                $documento = $data['data']['numeroDocumento'];
                $name = $data['data']['nome'];
                $street = $data['data']['endereco']['geral']['endereco'];
                $number = $data['data']['endereco']['geral']['numero'];
                $district = $data['data']['endereco']['geral']['bairro'];
                $city = $data['data']['endereco']['geral']['municipio'];
                $zip = $data['data']['endereco']['geral']['cep'];
                $state = $data['data']['endereco']['geral']['uf'];
                $email = isset($data['data']['email'])?$data['data']['email']:"";
                $celular = isset($data['data']['celular'])?$data['data']['celular']:"";
                $telefone = isset($data['data']['telefone'])?$data['data']['telefone']:"";
            }
            function cnpjQuery() {

                $formCnpj = isset($_GET['cnpj'])?$_GET['cnpj']:"";

                //removing no numeric characters
                $cnpj = preg_replace("/[^0-9]/", "", $formCnpj);

                $url = "https://open.cnpja.com/office/$cnpj";

                if($cnpj === ''){
                    // echo "O CNPJ não está preenchido";
                } else {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);

                    echo "<script>console.log($response)</script>";
                    $data = json_decode($response);

                    if(isset($data->company->name)){
                        global $documento;
                        global $name;
                        global $street;
                        global $number;
                        global $district;
                        global $city;
                        global $state;
                        global $tipoPessoa;
                        global $zip;

                        $tipoPessoa = "J";
                        $updated = new DateTime($data->updated);
                        $updated2 = $updated->format('d/m/Y');
                        $documento = $data->taxId;
                        $name = $data->company->name;
                        $street = $data->address->street;
                        $number = $data->address->number;
                        $district = $data->address->district;
                        $city = $data->address->city;
                        $state = isset($data->address->state)?$data->address->state:"";
                        $zip = $data->address->zip;
                        
                        echo "<div class=\"mt-3\">Última atualização dos dados: " . $updated2 . "</div>";
                        
                    } else if($data->code === 429){
                        echo "<div class='alert alert-danger'>Você excedeu o limite de consultas por minuto. Por favor aguarde um pouco para consultar novamente</div>";
                    }
                    else {
                        echo "<div class='alert alert-danger mt-4'><p>Verifique se o CNPJ digitado está correto. Houve um erro na requisição dos dados</p>" . "<p>Erro: " . $response . "</p></div>";
                    }
                }
            }
        ?>
    </div>
    
    <div class="container mt-4">
        <form action="novo_orcamento_itens.php" method="POST">

            <div class="mt-4"><h4>Dados cadastrais</h4></div>
            <div class="row">
                <div class="col-md-3 d-none">
                    <label for="contatoId" class="form-label mb-0 mt-2">ID</label>
                    <input type="text" class="form-control" name="contatoId" id="contatoId" value="<?= isset($contatoId)?$contatoId:""; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label for="cliente" class="form-label mb-0 mt-2">Nome completo / Razão social*</label>
                    <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Nome completo" value="<?= isset($name)?$name:""; ?>" required>
                </div>                
                <div class="col-md-4">
                    <label for="documento" class="form-label mb-0 mt-2">CPF/CNPJ*</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="documento" name="documento" placeholder="CPF ou CNPJ" value="<?= isset($documento)?$documento:""; ?>">
                </div>
                <div class="col-md-3">
                    <label for="tipoPessoa" class="form-label mb-0 mt-2">Tipo de pessoa</label>
                    <select class="form-select" id="tipodepessoa" name="tipoPessoa">
                        <option <?php if(isset($tipoPessoa) && $tipoPessoa === "J"){echo "selected";} ?> value="J">Pessoa jurídica</option>
                        <option <?php if(isset($tipoPessoa) && $tipoPessoa === "F"){echo "selected";} ?> value="F">Pessoa física</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="cep" class="form-label mb-0 mt-2">CEP</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="cep" name="cep" placeholder="CEP" value="<?= isset($zip)?$zip:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="bairro" class="form-label mb-0 mt-2">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?= isset($district)?$district:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipio" class="form-label mb-0 mt-2">Município</label>
                    <input type="text" class="form-control" name="municipio" id="municipio" placeholder="Município" value="<?= isset($city)?$city:""; ?>">
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
                                if(isset($state) && $state === "$uf"){
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
                    <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Rua, Avenida, etc." value="<?= isset($street)?$street:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="numero" class="form-label mb-0 mt-2">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="<?= isset($number)?$number:""; ?>">
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
                    <input type="number" inputmode="numeric" id="desconto" name="desconto" class="form-control" placeholder="Somente números">
                </div>
                <div class="col-md-2">
                    <label for="tipoDesconto" class="form-label mb-0 mt-2">Tipo</label>
                    <select class="form-select" name="tipoDesconto">
                        <option value="REAL" selected>R$</option>
                        <option value="PERCENTUAL">%</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4"><h4>Contato</h4></div>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="tel">Telefone</label>
                    <input class="form-control" type="tel" name="tel" id="tel" value="<?= isset($telefone)?$telefone:"" ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="cel">Celular*</label>
                    <input class="form-control" type="tel" name="cel" id="cel" value="<?= isset($celular)?$celular:"" ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="email">email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?= isset($email)?$email:""; ?>">
                </div>
            </div>
            
            <div class="mt-4"><h4>Endereço do serviço</h4></div>
            <div class="row">
                <div class="col-md-2">
                    <label for="cepServico" class="form-label mb-0 mt-2">CEP</label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" id="cepServico" name="cepServico" placeholder="CEP" value="<?= isset($zip)?$zip:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="bairroServico" class="form-label mb-0 mt-2">Bairro</label>
                    <input type="text" class="form-control" id="bairroServico" name="bairroServico" placeholder="Bairro" value="<?= isset($district)?$district:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipioServico" class="form-label mb-0 mt-2">Município</label>
                    <input type="text" class="form-control" name="municipioServico" id="municipioServico" placeholder="Município" value="<?= isset($city)?$city:""; ?>">
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
                            foreach($estados as $uf){
                                if(isset($state) && $state === "$uf"){
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
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="enderecoServico" class="form-label mb-0 mt-2">Endereço</label>
                    <input type="text" class="form-control" name="enderecoServico" id="enderecoServico" placeholder="Rua, Avenida, etc." value="<?= isset($street)?$street:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="numeroServico" class="form-label mb-0 mt-2">Número</label>
                    <input type="text" class="form-control" id="numeroServico" name="numeroServico" placeholder="Número" value="<?= isset($number)?$number:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="nomeServico" class="form-label mb-0 mt-2">Nome do responsável</label>
                    <input type="text" class="form-control" name="nomeServico" id="nomeServico" placeholder="Responsável no local" value="<?= isset($name)?$name:""; ?>">
                </div>
            </div>
            
            <div class="mt-4"><h4>Dados adicionais</h4></div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="observacoes" class="form-label mb-0 mt-2">Observações</label>
                    <textarea type="text" class="form-control" rows="3" name="observacoes" id="observacoes" placeholder="As informações digitadas aqui serão impressas no orçamento, na fatura e transferida para as observações da nota" value=""></textarea>
                </div>
                <div class="col-md-6">
                    <label for="observacoesInternas" class="form-label mb-0 mt-2">Observações internas</label>
                    <textarea type="text" class="form-control" rows="3" id="observacoesInternas" name="observacoesInternas" style="color: blue;" placeholder="Esta área é de uso interno, portanto não será impressa" value=""></textarea>
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
                    <input class="form-control" inputmode="numeric" name="largura" id="largura">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="altura">Altura*</label>
                    <input class="form-control" inputmode="numeric" name="altura" id="altura">
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

                                enderecoInput.disabled = true;
                                bairroInput.disabled = true;
                                cidadeInput.disabled = true;
                                estadoInput.disabled = true;

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

                                enderecoServico.disabled = true;
                                bairroServico.disabled = true;
                                cidadeServico.disabled = true;
                                estadoServico.disabled = true;

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
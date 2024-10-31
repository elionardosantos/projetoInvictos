<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Novo Pedido/Orçamento</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
    ?>
    <div class="container my-3">
        <h2>Novo Pedido/Orçamento</h2>
    </div>
    <div class="container my-3">
        <a href="consulta_cnpj.php" class="btn btn-primary" role="button">Consultar CNPJ</a>
    </div>
    <div class="container">
        <?php
            global $cnpj;
            global $companyName;
            global $street;
            global $number;
            global $district;
            global $city;
            global $state;
            
            isset($_POST['cnpj'])?cnpjQuery():"";
            function cnpjQuery() {

                $formCnpj = isset($_POST['cnpj'])?$_POST['cnpj']:"";

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

                    $data = json_decode($response);

                    if(isset($data->company->name)){
                        global $cnpj;
                        global $companyName;
                        global $street;
                        global $number;
                        global $district;
                        global $city;
                        global $state;

                        $updated = new DateTime($data->updated);
                        $updated2 = $updated->format('d/m/Y');
                        $cnpj = $data->taxId;
                        $companyName = $data->company->name;
                        $street = $data->address->street;
                        $number = $data->address->number;
                        $district = $data->address->district;
                        $city = $data->address->city;
                        $state = isset($data->address->state)?$data->address->state:"";
                        $phones = isset($data->phones)?$data->phones:"";
                        
                        echo "Última atualização dos dados: $updated2";
                        
                        /*
                        echo "<div class='alert alert-success'>";
                        echo "Status: $status <br>";
                        echo "Nome fantasia: $alias <br>";
                        echo "Razão Social: $companyName <br>";
                        echo "CNPJ: $cnpj <br>";
                        echo "Rua: $street <br>";
                        echo "Número: $number <br>";
                        echo "Bairro: $district <br>";
                        echo "Município: $city <br>";
                        echo "Estado: $state <br>";
                        echo "Código postal: $zip";
                        echo "</div>";
                        */
                    } else if($data->code === 429){
                        echo "<div class='alert alert-danger'>Você excedeu o limite de consultas por minuto. Por favor aguarde um pouco para consultar novamente</div>";
                    }
                    else {
                        echo "<div class='alert alert-danger'><p>Verifique se o CNPJ digitado está correto. Houve um erro na requisição dos dados</p>" . "<p>Erro: " . $response . "</p></div>";
                    }
                }
            }
        ?>
    </div>
    
    <div class="container mt-4">
        <form action="novo_pedido_process.php" method="POST">

            <div class="mt-4"><h4>Dados cadastrais</h4></div>
            <div class="row">
                <div class="col-md-5">
                    <label for="cliente" class="form-label mb-0 mt-2">Nome completo / Razão social*</label>
                    <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Nome completo" value="<?= isset($companyName)?$companyName:""; ?>">
                </div>                
                <div class="col-md-4">
                    <label for="documento" class="form-label mb-0 mt-2">CPF/CNPJ*</label>
                    <input type="text" class="form-control" id="documento" name="documento" placeholder="CPF ou CNPJ" value="<?= isset($cnpj)?$cnpj:""; ?>">
                </div>
                <div class="col-md-3">
                    <label for="tipoPessoa" class="form-label mb-0 mt-2">Tipo de pessoa</label>
                    <select class="form-select" id="tipodepessoa" name="tipoPessoa">
                        <option value="J">Pessoa jurídica</option>
                        <option value="F">Pessoa física</option>
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
                    <label for="bairro" class="form-label mb-0 mt-2">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?= isset($district)?$district:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipio" class="form-label mb-0 mt-2">Município</label>
                    <input type="text" class="form-control" name="municipio" id="municipio" placeholder="Município" value="<?= isset($city)?$city:""; ?>">
                </div>
                <div class="col-md-4">
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
                                echo "<option value=\"$uf\" <?php if(isset($state) && $state === '$uf') {echo 'selected';} ?>$uf</option>\n";
                            }
                         ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="tabelaPreco" class="form-label mb-0 mt-2">Tabela</label>
                    <select class="form-select" id="tabelaPreco" name="tabelaPreco">
                        <option value="consumidor-final" selected>Consumidor final</option>
                        <option value="serralheiro" >Serralheiro</option>
                    </select>
                </div>
                <div class="col-md-6">
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
            </div>
            
            <div class="mt-4"><h4>Contato</h4></div>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="tel">Telefone</label>
                    <input class="form-control" type="tel" name="tel" id="tel">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="cel">Celular*</label>
                    <input class="form-control" type="tel" name="cel" id="cel">
                </div>
                <div class="col-md-4">
                    <label class="form-label mb-0 mt-2" for="email">email</label>
                    <input class="form-control" type="email" name="email" id="email">
                </div>
            </div>
            
            <div class="mt-4"><h4>Dados da instalação</h4></div>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="quantidade">Quantidade*</label>
                    <input class="form-control" name="quantidade" id="quantidade">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="largura">Largura*</label>
                    <input class="form-control" name="largura" id="largura">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="altura">Altura*</label>
                    <input class="form-control" name="altura" id="altura">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-0 mt-2" for="rolo">Rolo*</label>
                    <input class="form-control" name="rolo" id="rolo">
                </div>
            </div>
            
            <div class="mt-4"><h4>Endereço do serviço</h4></div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="enderecoServico" class="form-label mb-0 mt-2">Endereço</label>
                    <input type="text" class="form-control" name="enderecoServico" id="enderecoServico" placeholder="Rua, Avenida, etc." value="<?= isset($street)?$street:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="numeroServico" class="form-label mb-0 mt-2">Número</label>
                    <input type="text" class="form-control" id="numeroServico" name="numeroServico" placeholder="Número" value="<?= isset($number)?$number:""; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="bairroServico" class="form-label mb-0 mt-2">Bairro</label>
                    <input type="text" class="form-control" id="bairroServico" name="bairroServico" placeholder="Bairro" value="<?= isset($district)?$district:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipioServico" class="form-label mb-0 mt-2">Município</label>
                    <input type="text" class="form-control" name="municipioServico" id="municipioServico" placeholder="Município" value="<?= isset($city)?$city:""; ?>">
                </div>
                <div class="col-md-4">
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
                                echo "<option value=\"$uf\" <?php if(isset($state) && $state === '$uf') {echo 'selected';} ?>$uf</option>\n";
                            }
                        ?>
                    </select>
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

            <div class="my-5">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <a href="pedidos.php" class="btn btn-primary mx-2">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
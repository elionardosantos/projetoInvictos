<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Novo orçamento</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
    ?>
    <div class="container my-3">
        <h2>Novo orçamento</h2>
    </div>
    <div class="container my-3">
        <a href="consulta_cnpj.php" class="btn btn-primary" role="button">Consultar CNPJ</a>
    </div>
    <div class="container">
        <?php
            isset($_POST['cnpj'])?cnpjQuery():"";
            function cnpjQuery() {
                global $cnpj;
                global $companyName;
                global $street;
                global $number;
                global $district;
                global $city;
                global $state;

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

                        $updated = new DateTime($data->updated);
                        $updated2 = $updated->format('d/m/Y');
                        $status = $data->status->text;
                        $alias = $data->alias;
                        $companyName = $data->company->name;
                        $street = $data->address->street;
                        $number = $data->address->number;
                        $district = $data->address->district;
                        $city = $data->address->city;
                        $state = $data->address->state;
                        $zip = $data->address->zip;
                        
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
        <form action="novo_orcamento_process.php" method="POST">

            <div class="my-4"><h4>Dados cadastrais</h4></div>
            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="cliente" class="form-label">Nome completo / Razão social</label>
                    <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Nome completo">
                </div>                
                <div class="col-md-4">
                    <label for="documento" class="form-label">CPF/CNPJ</label>
                    <input type="text" class="form-control" id="documento" name="documento" placeholder="CPF ou CNPJ" value="<?= isset($cnpj)?$cnpj:""; ?>">
                </div>
                <div class="col-md-3">
                    <label for="tipoPessoa" class="form-label">Tipo de pessoa</label>
                    <select class="form-select" id="tipodepessoa" name="tipoPessoa">
                        <option value="J">Pessoa jurídica</option>
                        <option value="F">Pessoa física</option>
                    </select>
                </div>
            </div>

            <div class="my-4"><h4>Endereço</h4></div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Rua, Avenida, etc." value="<?= isset($street)?$street:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="<?= isset($number)?$number:""; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?= isset($district)?$district:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipio" class="form-label">Município</label>
                    <input type="text" class="form-control" name="municipio" id="municipio" placeholder="Município" value="<?= isset($city)?$city:""; ?>">
                </div>
                <div class="col-md-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <!-- <option selected>Escolha...</option> -->
                        <option value="RJ" <?php if(isset($state) && $state === 'RJ') {echo 'selected';} ?>>RJ</option>
                        <option value="SP" <?php if(isset($state) && $state === 'SP') {echo 'selected';} ?>>SP</option>
                        <option value="ES" <?php if(isset($state) && $state === 'ES') {echo 'selected';} ?>>ES</option>
                        <option value="MG" <?php if(isset($state) && $state === 'MG') {echo 'selected';} ?>>MG</option>
                        <option value="AC" <?php if(isset($state) && $state === 'AC') {echo 'selected';} ?>>AC</option>
                        <option value="AL" <?php if(isset($state) && $state === 'AL') {echo 'selected';} ?>>AL</option>
                        <option value="AP" <?php if(isset($state) && $state === 'AP') {echo 'selected';} ?>>AP</option>
                        <option value="AM" <?php if(isset($state) && $state === 'AM') {echo 'selected';} ?>>AM</option>
                        <option value="BA" <?php if(isset($state) && $state === 'BA') {echo 'selected';} ?>>BA</option>
                        <option value="CE" <?php if(isset($state) && $state === 'CE') {echo 'selected';} ?>>CE</option>
                        <option value="DF" <?php if(isset($state) && $state === 'DF') {echo 'selected';} ?>>DF</option>
                        <option value="GO" <?php if(isset($state) && $state === 'GO') {echo 'selected';} ?>>GO</option>
                        <option value="MA" <?php if(isset($state) && $state === 'MA') {echo 'selected';} ?>>MA</option>
                        <option value="MT" <?php if(isset($state) && $state === 'MT') {echo 'selected';} ?>>MT</option>
                        <option value="MS" <?php if(isset($state) && $state === 'MS') {echo 'selected';} ?>>MS</option>
                        <option value="PA" <?php if(isset($state) && $state === 'PA') {echo 'selected';} ?>>PA</option>
                        <option value="PB" <?php if(isset($state) && $state === 'PB') {echo 'selected';} ?>>PB</option>
                        <option value="PR" <?php if(isset($state) && $state === 'PR') {echo 'selected';} ?>>PR</option>
                        <option value="PE" <?php if(isset($state) && $state === 'PE') {echo 'selected';} ?>>PE</option>
                        <option value="PI" <?php if(isset($state) && $state === 'PI') {echo 'selected';} ?>>PI</option>
                        <option value="RN" <?php if(isset($state) && $state === 'RN') {echo 'selected';} ?>>RN</option>
                        <option value="RS" <?php if(isset($state) && $state === 'RS') {echo 'selected';} ?>>RS</option>
                        <option value="RO" <?php if(isset($state) && $state === 'RO') {echo 'selected';} ?>>RO</option>
                        <option value="RR" <?php if(isset($state) && $state === 'RR') {echo 'selected';} ?>>RR</option>
                        <option value="SC" <?php if(isset($state) && $state === 'SC') {echo 'selected';} ?>>SC</option>
                        <option value="SE" <?php if(isset($state) && $state === 'SE') {echo 'selected';} ?>>SE</option>
                        <option value="TO" <?php if(isset($state) && $state === 'TO') {echo 'selected';} ?>>TO</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tabelaPreco" class="form-label">Tabela</label>
                    <select class="form-select" id="tabelaPreco" name="tabelaPreco">
                        <option value="consumidor-final" selected>Consumidor final</option>
                        <option value="serralheiro" >Serralheiro</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="condicaoPagamento" class="form-label">Condição de Pagto</label>
                    <select class="form-select" id="condicaoPagamento" name="condicaoPagamento">
                        <option selected>À vista</option>
                        <option value="cartao1x">Cartão 1x</option>
                        <option value="cartao2x">Cartão 2x</option>
                        <option value="cartao3x">Cartão 3x</option>
                        <option value="cartao4x">Cartão 4x</option>
                        <option value="cartao5x">Cartão 5x</option>
                        <option value="cartao6x">Cartão 6x</option>
                        <option value="cartao7x">Cartão 7x</option>
                        <option value="cartao8x">Cartão 8x</option>
                        <option value="cartao9x">Cartão 9x</option>
                        <option value="cartao10x">Cartão 10x</option>
                        <option value="cartao11x">Cartão 11x</option>
                        <option value="cartao12x">Cartão 12x</option>
                    </select>
                </div>
            </div>
            
            <!-- Add email, telefone -->
            <div class="my-4"><h4>Contato</h4></div>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label" for="tel">Telefone</label>
                    <input class="form-control" type="tel" name="tel" id="tel">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="cel">Celular</label>
                    <input class="form-control" type="tel" name="cel" id="cel">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="email">email</label>
                    <input class="form-control" type="email" name="email" id="email">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <a href="orcamentos.php" class="btn btn-primary mx-2">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
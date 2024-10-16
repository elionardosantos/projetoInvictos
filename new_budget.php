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
        <a href="cnpj_query.php" class="btn btn-primary" role="button">Consultar CNPJ</a>
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
                    echo "<div class='alert alert-danger'>Você excedeu o linite de consultas por minuto. Por favor aguarde um pouco para consultar novamente</div>";
                }
                else {
                    echo "<div class='alert alert-danger'><p>Verifique se o CNPJ digitado está correto. Houve um erro na requisição dos dados</p>" . "<p>Erro: " . $response . "</p></div>";
                }
            }
        }
        ?>
    </div>
    <div class="container mt-4">
        <form action="new_budget_process.php" method="POST">
            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="cliente" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="cliente" placeholder="Nome do Cliente">
                </div>
                <div class="col-md-4">
                    <label for="cliente" class="form-label">CPF</label>
                    <input type="number" class="form-control" id="cliente" placeholder="CPF">
                </div>
                <div class="col-md-3">
                    <label for="data" class="form-label">Data</label>
                    <input type="date" class="form-control" id="data" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cliente" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cliente" placeholder="CNPJ do Cliente" value="<?= isset($cnpj)?$cnpj:""; ?>">
                </div>
                <div class="col-md-6">
                    <label for="data" class="form-label">Razão Social</label>
                    <input type="text" class="form-control" id="data" placeholder="Razão social do Cliente" value="<?= isset($companyName)?$companyName:""; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" placeholder="Rua, Avenida, etc." value="<?= isset($street)?$street:$street; ?>">
                </div>
                <div class="col-md-4">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" placeholder="Número" value="<?= isset($number)?$number:$number; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" placeholder="Bairro" value="<?= isset($district)?$district:$district; ?>">
                </div>
                <div class="col-md-4">
                    <label for="municipio" class="form-label">Município</label>
                    <input type="text" class="form-control" id="municipio" placeholder="Município" value="<?= isset($city)?$city:$city; ?>">
                </div>
                <div class="col-md-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado">
                        <option selected>Escolha...</option>
                        <option value="RJ" <?= $state === 'RJ'?'selected':''; ?>>RJ</option>
                        <option value="SP" <?= $state === 'SP'?'selected':''; ?>>SP</option>
                        <option value="ES" <?= $state === 'ES'?'selected':''; ?>>ES</option>
                        <option value="MG" <?= $state === 'MG'?'selected':''; ?>>MG</option>
                        <option value="AC" <?= $state === 'AC'?'selected':''; ?>>AC</option>
                        <option value="AL" <?= $state === 'AL'?'selected':''; ?>>AL</option>
                        <option value="AP" <?= $state === 'AP'?'selected':''; ?>>AP</option>
                        <option value="AM" <?= $state === 'AM'?'selected':''; ?>>AM</option>
                        <option value="BA" <?= $state === 'BA'?'selected':''; ?>>BA</option>
                        <option value="CE" <?= $state === 'CE'?'selected':''; ?>>CE</option>
                        <option value="DF" <?= $state === 'DF'?'selected':''; ?>>DF</option>
                        <option value="GO" <?= $state === 'GO'?'selected':''; ?>>GO</option>
                        <option value="MA" <?= $state === 'MA'?'selected':''; ?>>MA</option>
                        <option value="MT" <?= $state === 'MT'?'selected':''; ?>>MT</option>
                        <option value="MS" <?= $state === 'MS'?'selected':''; ?>>MS</option>
                        <option value="PA" <?= $state === 'PA'?'selected':''; ?>>PA</option>
                        <option value="PB" <?= $state === 'PB'?'selected':''; ?>>PB</option>
                        <option value="PR" <?= $state === 'PR'?'selected':''; ?>>PR</option>
                        <option value="PE" <?= $state === 'PE'?'selected':''; ?>>PE</option>
                        <option value="PI" <?= $state === 'PI'?'selected':''; ?>>PI</option>
                        <option value="RN" <?= $state === 'RN'?'selected':''; ?>>RN</option>
                        <option value="RS" <?= $state === 'RS'?'selected':''; ?>>RS</option>
                        <option value="RO" <?= $state === 'RO'?'selected':''; ?>>RO</option>
                        <option value="RR" <?= $state === 'RR'?'selected':''; ?>>RR</option>
                        <option value="SC" <?= $state === 'SC'?'selected':''; ?>>SC</option>
                        <option value="SE" <?= $state === 'SE'?'selected':''; ?>>SE</option>
                        <option value="TO" <?= $state === 'TO'?'selected':''; ?>>TO</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tabela" class="form-label">Tabela</label>
                    <select class="form-select" id="tabela">
                        <option value="consumidor-final" selected>Consumidor final</option>
                        <option value="serralheiro" >Serralheiro</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="condicao" class="form-label">Condição de Pagto</label>
                    <select class="form-select" id="condicao">
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

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>
</html>
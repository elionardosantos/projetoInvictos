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
        <div class="container mt-5">
        <h2 class="mb-4">Cadastro de Novo Contato</h2>
        <form>
            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o nome completo" required>
            </div>
            
            <!-- CPF/CNPJ -->
            <div class="mb-3">
                <label for="cpfCnpj" class="form-label">CPF/CNPJ</label>
                <input type="text" class="form-control" id="cpfCnpj" placeholder="Digite o CPF ou CNPJ" required>
            </div>
            
            <!-- E-mail -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" placeholder="Digite o e-mail" required>
            </div>
            
            <!-- Telefone -->
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="telefone" placeholder="(XX) XXXXX-XXXX" required>
            </div>

            <!-- Endereço -->
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" placeholder="Digite o endereço" required>
            </div>

            <!-- Bairro -->
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" placeholder="Digite o bairro" required>
            </div>

            <!-- CEP -->
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" class="form-control" id="cep" placeholder="Digite o CEP" required>
            </div>

            <!-- Cidade -->
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidade" placeholder="Digite a cidade" required>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" required>
                    <option value="" selected disabled>Selecione o estado</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="SP">São Paulo</option>
                    <option value="MG">Minas Gerais</option>
                    <!-- Adicione outros estados conforme necessário -->
                </select>
            </div>
            
            <!-- Botão de enviar -->
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>
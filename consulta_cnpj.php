<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Consultar CNPJ</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2>Consultar CNPJ</h2>
    </div>
    <div class="container my-3">
        <form action="novo_pedido.php" method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text" id="formCnpj">CNPJ</span>
                <input type="text" name="cnpj" class="form-control" placeholder="Digite aqui" autofocus>
            </div>
            <input type="submit" class="btn btn-primary" value="Consultar">
            <a href="novo_pedido.php" class="btn btn-primary">Voltar</a>
        </form>
    </div>
    <div class="container">
        <?php

        $formCnpj = isset($_GET['cnpj'])?$_GET['cnpj']:"";

        //removing no numeric characters
        $cnpj = preg_replace("/[^0-9]/", "", $formCnpj);

        $url = "https://open.cnpja.com/office/$cnpj";

        if($cnpj === ''){
            
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            $data = json_decode($response);

            if(isset($data->company->name)){

                $updated = $data->updated;
                $status = $data->status->text;
                $alias = $data->alias;
                $companyName = $data->company->name;
                $street = $data->address->street;
                $number = $data->address->number;
                $district = $data->address->district;
                $city = $data->address->city;
                $state = $data->address->state;
                $zip = $data->address->zip;
                $name = $data->address->country->name;
                
                echo "Última atualização: $updated<br>";
                echo "<br>Status: $status";
                echo "<br>Nome fantasia: $alias";
                echo "<br>Razão Social: $companyName";
                echo "<br>CNPJ: $cnpj";
                echo "<br>Rua: $street";
                echo "<br>Número: $number";
                echo "<br>Bairro: $district";
                echo "<br>Cidade: $city";
                echo "<br>Estado: $state";
                echo "<br>Código postal: $zip";
                
            } else if($data->code === 429){
                echo "<div class='alert alert-danger'>Você excedeu o linite de consultas por minuto. Por favor aguarde um pouco para consultar novamente</div>";
            }
            else {
                echo "<div class='alert alert-danger'><p>Verifique se o CNPJ digitado está correto. Houve um erro na requisição dos dados</p>" . "<p>Erro: " . $response . "</p></div>";
            }
        }
        ?>

    </div>
</body>
</html>
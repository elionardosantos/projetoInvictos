<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Cadastrar Produto</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('config/connection.php');

        $pesoForm = isset($_POST['peso_produto'])?$_POST['peso_produto']:"";
        $multiplicadorForm = isset($_POST['multiplicador_produto'])?$_POST['multiplicador_produto']:"";
        $consumo = isset($_POST['consumo_produto'])?$_POST['consumo_produto']:"";
        $alturaMinimaForm = isset($_POST['altura_minima'])?$_POST['altura_minima']:"";
        $alturaMaximaForm = isset($_POST['altura_maxima'])?$_POST['altura_maxima']:"";
        $larguraMinimaForm = isset($_POST['largura_minima'])?$_POST['largura_minima']:"";
        $larguraMaximaForm = isset($_POST['largura_maxima'])?$_POST['largura_maxima']:"";
        $pesoMinimoForm = isset($_POST['peso_minimo'])?$_POST['peso_minimo']:"";
        $pesoMaximoForm = isset($_POST['peso_maximo'])?$_POST['peso_maximo']:"";
        $tipoProduto = isset($_POST['tipoProduto'])?$_POST['tipoProduto']:"";
        
        $codigoProduto = isset($_POST['codigo_produto'])?$_POST['codigo_produto']:"";
        $titulo = isset($_POST['titulo_produto'])?$_POST['titulo_produto']:"";
        $selecionado = isset($_POST['selecionado'])?$_POST['selecionado']:"";
        $peso = floatval(str_replace(",",".",$pesoForm));
        $multiplicador = floatval(str_replace(",",".",$multiplicadorForm));
        $alturaMinima = floatval(str_replace(",",".",$alturaMinimaForm));
        $alturaMaxima = floatval(str_replace(",",".",$alturaMaximaForm));
        $larguraMinima = floatval(str_replace(",",".",$larguraMinimaForm));
        $larguraMaxima = floatval(str_replace(",",".",$larguraMaximaForm));
        $pesoMinimo = floatval(str_replace(",",".",$pesoMinimoForm));
        $pesoMaximo = floatval(str_replace(",",".",$pesoMaximoForm));

        //Lógica da página
        if(consultaProdutoBling($codigoProduto) == true){
            if(verificaReferenciaBD($codigoProduto) == "naoExiste"){
                novoProduto();
            }else{
                $screenMessage = '<div class="alert alert-danger">Este produto já está cadastrado no sistema</div>';
            };
        }else{
            $screenMessage = '<div class="alert alert-danger">Este código de produto não existe no Bling</div>';
        }

        //Funções
        function verificaReferenciaBD($codigoProduto){
            require('config/connection.php');
            $sql = "SELECT `codigo` FROM `produtos` WHERE `codigo` = :codigo AND `deleted` = :deleted";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':codigo', $codigoProduto);
            $stmt->bindValue(':deleted', 0);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // print_r($resultado);

            if(isset($resultado[0]['codigo']) && $resultado[0]['codigo'] !== ""){
                return "existe";

            } else {
                return "naoExiste";
            }
        };
        
        function consultaProdutoBling($codigoProduto){
            global $nomeProdutoBling;

            $url = "https://api.bling.com.br/Api/v3/produtos?codigos%5B%5D=$codigoProduto";
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
            $responseData = json_decode($response, true);
            
            
            if(isset($responseData['error']['type']) && $responseData['error']['type'] == "invalid_token"){
                require('controller/token_refresh.php');
                // echo "<script>console.log('Token atualizado')</script>";
                sleep(2);
                return consultaProdutoBling($codigoProduto);

            }
            else if(isset($responseData['data']) && count($responseData['data']) == 1 && isset($responseData['data'][0]['codigo'])){
                echo "<script>console.log('Consulta do produto')</script>";
                echo "<script>console.log($response)</script>";
                echo "<script>console.log('Returns true')</script>";
                $nomeProdutoBling = $responseData['data'][0]['nome'];
                return true;
                
            }
            else {
                echo "<script>console.log('Resposta da consulta:')</script>";
                echo "<script>console.log($response)</script>";
                // return "erro";
                return false;

            }
        }
        
        function novoProduto(){
            global $nomeProdutoBling;
            global $codigoProduto;
            global $titulo;
            global $peso;
            global $consumo;
            global $multiplicador;
            global $alturaMinima;
            global $alturaMaxima;
            global $larguraMinima;
            global $larguraMaxima;
            global $pesoMinimo;
            global $pesoMaximo;
            global $selecionado;
            global $tipoProduto;

            if(isset($titulo) && $titulo !== ""){
                $nomeProduto = $titulo;
            } else {
                $nomeProduto = $nomeProdutoBling;
            }

            $created_by = $_SESSION['login']['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $created_at = date('Y-m-d H:i:s');

            try {
                require('config/connection.php');
                $sql = "INSERT INTO `produtos`(`id`,`codigo`,`titulo`,`peso`,`tipo_consumo`,`multiplicador`,`altura_minima_porta`,`altura_maxima_porta`,`largura_minima_porta`,`largura_maxima_porta`,`peso_minimo_porta`,`peso_maximo_porta`,`tipo_produto`,`selecionado`,`deleted`,`created_by`,`created_at`)
                    VALUES (:id, :codigo, :titulo, :peso, :tipo_consumo, :multiplicador, :altura_minima_porta, :altura_maxima_porta, :largura_minima_porta, :largura_maxima_porta, :peso_minimo_porta, :peso_maximo_porta, :tipo_produto, :selecionado, :deleted, :created_by, :created_at)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', null);
                $stmt->bindValue(':codigo', $codigoProduto);
                $stmt->bindValue(':titulo', $nomeProduto);
                $stmt->bindValue(':peso', $peso);
                $stmt->bindValue(':tipo_consumo', $consumo);
                $stmt->bindValue(':multiplicador', $multiplicador);
                $stmt->bindValue(':altura_minima_porta', $alturaMinima);
                $stmt->bindValue(':altura_maxima_porta', $alturaMaxima);
                $stmt->bindValue(':largura_minima_porta', $larguraMinima);
                $stmt->bindValue(':largura_maxima_porta', $larguraMaxima);
                $stmt->bindValue(':peso_minimo_porta', $pesoMinimo);
                $stmt->bindValue(':peso_maximo_porta', $pesoMaximo);
                $stmt->bindValue(':tipo_produto', $tipoProduto);
                $stmt->bindValue(':selecionado', $selecionado);
                $stmt->bindValue(':deleted', 0);
                $stmt->bindValue(':created_by', $created_by);
                $stmt->bindValue(':created_at', $created_at);

                if($stmt->execute()){
                    global $screenMessage;
                    $screenMessage = '<div class="alert alert-success">Produto cadastrado com sucesso</div>';
                }

            } catch(PDOException $e) {
                global $screenMessage;
                $screenMessage = "Erro ao inserir dados: " . $e->getMessage();
            }

        }

    ?>
    <div class="container">
        <h1>
            Cadastrar produto
        </h1>
    </div>
    <div class="container">
        <p><?= isset($screenMessage)?$screenMessage:""; ?></p>
    </div>
    <div class="container mt-4">
        <a href="produtos.php" class="btn btn-primary">Voltar</a>
    </div>
    <div class="container mt-4">
    </div>
</body>
</html>
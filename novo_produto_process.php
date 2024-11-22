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
        $multiplicacaoForm = isset($_POST['multiplicador_produto'])?$_POST['multiplicador_produto']:"";
        $consumo = isset($_POST['consumo_produto'])?$_POST['consumo_produto']:"";
        $alturaMinimaForm = isset($_POST['altura_minima'])?$_POST['altura_minima']:"";
        $alturaMaximaForm = isset($_POST['altura_maxima'])?$_POST['altura_maxima']:"";
        $larguraMinimaForm = isset($_POST['largura_minima'])?$_POST['largura_minima']:"";
        $larguraMaximaForm = isset($_POST['largura_maxima'])?$_POST['largura_maxima']:"";
        $pesoMinimoForm = isset($_POST['peso_minimo'])?$_POST['peso_minimo']:"";
        $pesoMaximoForm = isset($_POST['peso_maximo'])?$_POST['peso_maximo']:"";
        
        $codigoProduto = isset($_POST['codigo_produto'])?$_POST['codigo_produto']:"";
        $titulo = isset($_POST['titulo_produto'])?$_POST['titulo_produto']:"";
        $selecionado = isset($_POST['selecionado'])?$_POST['selecionado']:"";
        $peso = floatval(str_replace(",",".",$pesoForm));
        $multiplicacao = floatval(str_replace(",",".",$multiplicacaoForm));
        $alturaMinima = floatval(str_replace(",",".",$alturaMinimaForm));
        $alturaMaxima = floatval(str_replace(",",".",$alturaMaximaForm));
        $larguraMinima = floatval(str_replace(",",".",$larguraMinimaForm));
        $larguraMaxima = floatval(str_replace(",",".",$larguraMaximaForm));
        $pesoMinimo = floatval(str_replace(",",".",$pesoMinimoForm));
        $pesoMaximo = floatval(str_replace(",",".",$pesoMaximoForm));

        //Lógica da página
        if(consultaProdutoBling($codigoProduto)){
            if(verificaReferenciaBD($codigoProduto) === "naoExiste"){
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
            $sql = "SELECT `codigo` FROM `produtos` WHERE `codigo` = :codigo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':codigo', $codigoProduto);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($resultado)>0){
                return "existe";
            } else {
                return "naoExiste";
            }
        };
        
        function consultaProdutoBling($codigoProduto){
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
            
            
            if(isset($responseData['error']['type']) && $responseData['error']['type'] === "VALIDATION_ERROR"){
                echo "VALIDATION_ERROR";
            } else if (isset($responseData['data']) && $responseData['data'] !== ""){
                if(count($responseData['data']) == 1){
                    echo "<script>console.log('Consulta do produto')</script>";
                    echo "<script>console.log($response)</script>";
                    return true;
                }
            } else {
                return "erro";
                return false;
            }
        }
        
        function novoProduto(){
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

            $created_by = $_SESSION['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $created_at = date('Y-m-d H:i:s');

            try {
                require('config/connection.php');
                $sql = "INSERT INTO `produtos`(`codigo`,`titulo`,`peso`,`consumo`,`multiplicador`,`altura_minima`,`altura_maxima`,`largura_minima`,`largura_maxima`,`peso_minimo`,`peso_maximo`,`selecionado`,`deleted`,`created_by`,`created_at`)
                    VALUES (:codigo,:titulo, :peso, :consumo, :multiplicador, :altura_minima, :altura_maxima, :largura_minima, :largura_maxima, :peso_minimo, :peso_maximo, :selecionado, :deleted, :created_by, :created_at)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':codigo', $codigoProduto);
                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':peso', $peso);
                $stmt->bindValue(':consumo', $consumo);
                $stmt->bindValue(':multiplicador', $multiplicador);
                $stmt->bindValue(':altura_minima', $alturaMinima);
                $stmt->bindValue(':altura_maxima', $alturaMaxima);
                $stmt->bindValue(':largura_minima', $larguraMinima);
                $stmt->bindValue(':largura_maxima', $larguraMaxima);
                $stmt->bindValue(':peso_minimo', $pesoMinimo);
                $stmt->bindValue(':peso_maximo', $pesoMaximo);
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
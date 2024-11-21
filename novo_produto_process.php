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

        $pesoForm = isset($_POST['pesoProduto'])?$_POST['pesoProduto']:"";
        $multiplicacaoForm = isset($_POST['multiplicacaoProduto'])?$_POST['multiplicacaoProduto']:"";
        
        $referencia = isset($_POST['referenciaProduto'])?$_POST['referenciaProduto']:"";
        $titulo = isset($_POST['tituloProduto'])?$_POST['tituloProduto']:"";
        $consumo = isset($_POST['consumoProduto'])?$_POST['consumoProduto']:"";
        $peso = floatval(str_replace(",",".",$pesoForm));
        $multiplicacao = floatval(str_replace(",",".",$multiplicacaoForm));

        //Lógica da página
        if(consultaProdutoBling($referencia)){
            if(verificaReferenciaBD($referencia) === "naoExiste"){
                novoProduto();
            }else{
                $screenMessage = '<div class="alert alert-danger">Este produto já está cadastrado no sistema</div>';
            };
        }else{
            $screenMessage = '<div class="alert alert-danger">Este código de produto não existe no Bling</div>';
        }

        //Funções
        function verificaReferenciaBD($referencia){
            require('config/connection.php');
            $sql = "SELECT `referencia` FROM `produtos` WHERE `referencia` = :referencia";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':referencia', $referencia);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($resultado)>0){
                return "existe";
            } else {
                return "naoExiste";
            }
        };
        
        function consultaProdutoBling($referencia){
            $url = "https://api.bling.com.br/Api/v3/produtos?codigos%5B%5D=$referencia";
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
            global $referencia;
            global $titulo;
            global $peso;
            global $consumo;
            global $multiplicacao;
            $created_by = $_SESSION['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $created_at = date('Y-m-d H:i:s');

            try {
                require('config/connection.php');
                $sql = "INSERT INTO `produtos`(`referencia`,`titulo`,`peso`,`consumo`,`multiplicacao`,`deleted`,`created_by`,`created_at`)
                    VALUES (:referencia,:titulo, :peso, :consumo, :multiplicacao, :deleted, :created_by, :created_at)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':referencia', $referencia);
                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':peso', $peso);
                $stmt->bindValue(':consumo', $consumo);
                $stmt->bindValue(':multiplicacao', $multiplicacao);
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
        <a href="novo_produto.php" class="btn btn-primary">Voltar</a>
    </div>
    <div class="container mt-4">
    </div>
</body>
</html>
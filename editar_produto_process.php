<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Editar Produto</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('config/connection.php');

        $idProduto = isset($_POST['idProduto'])?$_POST['idProduto']:"";
        $pesoForm = isset($_POST['pesoProduto'])?$_POST['pesoProduto']:"";
        $multiplicadorForm = isset($_POST['multiplicadorProduto'])?$_POST['multiplicadorProduto']:"";
        $alturaMinimaForm = isset($_POST['altura_minima'])?$_POST['altura_minima']:"";
        $alturaMaximaForm = isset($_POST['altura_maxima'])?$_POST['altura_maxima']:"";
        $larguraMinimaForm = isset($_POST['largura_minima'])?$_POST['largura_minima']:"";
        $larguraMaximaForm = isset($_POST['largura_maxima'])?$_POST['largura_maxima']:"";
        $pesoMinimoForm = isset($_POST['peso_minimo'])?$_POST['peso_minimo']:"";
        $pesoMaximoForm = isset($_POST['peso_maximo'])?$_POST['peso_maximo']:"";
        
        $codigoProduto = isset($_POST['codigoProduto'])?$_POST['codigoProduto']:"";
        $titulo = isset($_POST['tituloProduto'])?$_POST['tituloProduto']:"";
        $peso = floatval(str_replace(",",".",$pesoForm));
        $multiplicador = floatval(str_replace(",",".",$multiplicadorForm));
        $consumoProduto = isset($_POST['consumoProduto'])?$_POST['consumoProduto']:"";
        $alturaMinima = floatval(str_replace(",",".",$alturaMinimaForm));
        $alturaMaxima = floatval(str_replace(",",".",$alturaMaximaForm));
        $larguraMinima = floatval(str_replace(",",".",$larguraMinimaForm));
        $larguraMaxima = floatval(str_replace(",",".",$larguraMaximaForm));
        $pesoMinimo = floatval(str_replace(",",".",$pesoMinimoForm));
        $pesoMaximo = floatval(str_replace(",",".",$pesoMaximoForm));
        $selecionado = isset($_POST['selecionado'])?$_POST['selecionado']:"";

        //Lógica da página
        if(consultaProdutoBling($codigoProduto)){
            atualizaProduto($idProduto);
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
        
        function atualizaProduto($idProduto){
            
            global $idProduto;
            global $codigoProduto;
            global $titulo;
            global $peso;
            global $consumoProduto;
            global $multiplicador;
            global $alturaMinima;
            global $alturaMaxima;
            global $larguraMinima;
            global $larguraMaxima;
            global $pesoMinimo;
            global $pesoMaximo;
            global $selecionado;

            $updated_by = $_SESSION['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $updated_at = date('Y-m-d H:i:s');

            try {
                require('config/connection.php');
                $sql = "UPDATE `produtos` 
                        SET
                            `codigo` = :codigo,
                            `titulo` = :titulo,
                            `peso` = :peso,
                            `consumo` = :consumo,
                            `multiplicador` = :multiplicador,
                            `altura_minima` = :altura_minima,
                            `altura_maxima` = :altura_maxima,
                            `largura_minima` = :largura_minima,
                            `largura_maxima` = :largura_maxima,
                            `peso_minimo` = :peso_minimo,
                            `peso_maximo` = :peso_maximo,
                            `selecionado` = :selecionado,
                            `deleted` = :deleted,
                            `updated_by` = :updated_by,
                            `updated_at` = :updated_at
                        WHERE id = :id";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $idProduto);
                $stmt->bindValue(':codigo', $codigoProduto);
                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':peso', $peso);
                $stmt->bindValue(':consumo', $consumoProduto);
                $stmt->bindValue(':multiplicador', $multiplicador);
                $stmt->bindValue(':altura_minima', $alturaMinima);
                $stmt->bindValue(':altura_maxima', $alturaMaxima);
                $stmt->bindValue(':largura_minima', $larguraMinima);
                $stmt->bindValue(':largura_maxima', $larguraMaxima);
                $stmt->bindValue(':peso_minimo', $pesoMinimo);
                $stmt->bindValue(':peso_maximo', $pesoMaximo);
                $stmt->bindValue(':selecionado', $selecionado);
                $stmt->bindValue(':deleted', 0);
                $stmt->bindValue(':updated_by', $updated_by);
                $stmt->bindValue(':updated_at', $updated_at);

                if($stmt->execute() == true){
                    global $screenMessage;
                    $screenMessage = '<div class="alert alert-success">Produto atualizado com sucesso</div>';
                } else {
                    $screenMessage = '<div class="alert alert-danger">Erro ao atualizar o produto</div>';
                }

            } catch(PDOException $e) {
                global $screenMessage;
                $screenMessage = "Erro ao inserir dados: " . $e->getMessage();
            }

        }

    ?>
    <div class="container">
        <h1>
            Editar produto
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
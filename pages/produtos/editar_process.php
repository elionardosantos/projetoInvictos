<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require(__DIR__ . "/../../partials/head.php"); ?>
    <title>Editar Produto</title>
</head>
<body>
    <?php
        require(__DIR__ . "/../../controller/login_checker.php");
        require(__DIR__ . "/../../partials/navbar.php");
        require(__DIR__ . '/../../controller/only_level_2.php');
        require(__DIR__ . "/../../config/connection.php");

        // Dados vindos diretamente do formulário e sem tratamento
        $idProduto = isset($_POST['id_produto'])?$_POST['id_produto']:"";
        $pesoForm = isset($_POST['peso_produto'])?$_POST['peso_produto']:"";
        $multiplicadorForm = isset($_POST['multiplicador_produto'])?$_POST['multiplicador_produto']:"";
        $alturaMinimaForm = isset($_POST['altura_minima'])?$_POST['altura_minima']:"";
        $alturaMaximaForm = isset($_POST['altura_maxima'])?$_POST['altura_maxima']:"";
        $larguraMinimaForm = isset($_POST['largura_minima'])?$_POST['largura_minima']:"";
        $larguraMaximaForm = isset($_POST['largura_maxima'])?$_POST['largura_maxima']:"";
        $pesoMinimoForm = isset($_POST['peso_minimo'])?$_POST['peso_minimo']:"";
        $pesoMaximoForm = isset($_POST['peso_maximo'])?$_POST['peso_maximo']:"";
        $tipoProduto = isset($_POST['tipoProduto'])?$_POST['tipoProduto']:"";
        $itemBasico = isset($_POST['itemBasico'])?$_POST['itemBasico']:"";
        
        // Variaveis com o tratamento dos dados realizado
        $codigoProduto = isset($_POST['codigo_produto'])?$_POST['codigo_produto']:"";
        $titulo = isset($_POST['titulo_produto'])?$_POST['titulo_produto']:"";
        $categoria = isset($_POST['categoria'])?$_POST['categoria']:null;
        $peso = $pesoForm !== ""?floatval(str_replace(",",".",$pesoForm)):null;
        $multiplicador = $multiplicadorForm !== ""?floatval(str_replace(",",".",$multiplicadorForm)):null;
        $consumoProduto = isset($_POST['consumo_produto'])?$_POST['consumo_produto']:"";
        $alturaMinima = $alturaMinimaForm !== ""?floatval(str_replace(",",".",$alturaMinimaForm)):null;
        $alturaMaxima = $alturaMaximaForm !== ""?floatval(str_replace(",",".",$alturaMaximaForm)):null;
        $larguraMinima = $larguraMinimaForm !== ""?floatval(str_replace(",",".",$larguraMinimaForm)):null;
        $larguraMaxima = $larguraMaximaForm !== ""?floatval(str_replace(",",".",$larguraMaximaForm)):null;
        $pesoMinimo = $pesoMinimoForm !== ""?floatval(str_replace(",",".",$pesoMinimoForm)):null;
        $pesoMaximo = $pesoMaximoForm !== ""?floatval(str_replace(",",".",$pesoMaximoForm)):null;
        $selecionado = isset($_POST['selecionado'])?$_POST['selecionado']:"";
        $statusProduto = isset($_POST['statusProduto']) && $_POST['statusProduto'] !== "" ? $_POST['statusProduto'] : null;

        //Lógica da página
        if(consultaProdutoBling($codigoProduto)){
            atualizaProduto($idProduto);
        }else{
            $screenMessage = '<div class="alert alert-danger">Este código de produto não existe no Bling</div>';
        }

        //Funções
        function verificaReferenciaBD($codigoProduto){
            require(__DIR__ . "/../../config/connection.php");
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
            $jsonFile = file_get_contents(__DIR__ . '/../../config/token_request_response.json');
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
            global $categoria;
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
            global $itemBasico;
            global $statusProduto;
            global $tipoProduto;

            // print_r($statusProduto);

            $updated_by = $_SESSION['login']['loggedUserId'];
            date_default_timezone_set('America/Sao_Paulo');
            $updated_at = date('Y-m-d H:i:s');

            try {
                require(__DIR__ . "/../../config/connection.php");
                $sql = "UPDATE `produtos` 
                        SET
                            `codigo` = :codigo,
                            `titulo` = :titulo,
                            `categoria` = :categoria,
                            `peso` = :peso,
                            `tipo_consumo` = :tipo_consumo,
                            `multiplicador` = :multiplicador,
                            `altura_minima_porta` = :altura_minima_porta,
                            `altura_maxima_porta` = :altura_maxima_porta,
                            `largura_minima_porta` = :largura_minima_porta,
                            `largura_maxima_porta` = :largura_maxima_porta,
                            `peso_minimo_porta` = :peso_minimo_porta,
                            `peso_maximo_porta` = :peso_maximo_porta,
                            `tipo_produto` = :tipoProduto,
                            `basico` = :item_basico,
                            `selecionado` = :selecionado,
                            `ativo` = :ativo,
                            `deleted` = :deleted,
                            `updated_by` = :updated_by,
                            `updated_at` = :updated_at
                        WHERE id = :id";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $idProduto);
                $stmt->bindValue(':codigo', $codigoProduto);
                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':categoria', $categoria);
                $stmt->bindValue(':peso', $peso);
                $stmt->bindValue(':tipo_consumo', $consumoProduto);
                $stmt->bindValue(':multiplicador', $multiplicador);
                $stmt->bindValue(':altura_minima_porta', $alturaMinima);
                $stmt->bindValue(':altura_maxima_porta', $alturaMaxima);
                $stmt->bindValue(':largura_minima_porta', $larguraMinima);
                $stmt->bindValue(':largura_maxima_porta', $larguraMaxima);
                $stmt->bindValue(':peso_minimo_porta', $pesoMinimo);
                $stmt->bindValue(':peso_maximo_porta', $pesoMaximo);
                $stmt->bindValue(':selecionado', $selecionado);
                $stmt->bindValue(':tipoProduto', $tipoProduto);
                $stmt->bindValue(':item_basico', $itemBasico);
                $stmt->bindValue(':ativo', $statusProduto);
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
        <a href="listar.php" class="btn btn-primary">Voltar</a>
    </div>
    <div class="container mt-4">
    </div>
</body>
</html>
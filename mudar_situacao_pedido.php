<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Situação alterada</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');
        require('controller/only_level_2.php');

        $pedidoId = isset($_GET['pedidoId'])?$_GET['pedidoId']:null;
        $situacaoId = isset($_GET['situacaoId'])?$_GET['situacaoId']:null;
    ?>
    <div class="container">
        <div class="mt-3">
            <?php
                $response = json_decode(alteraStatus($pedidoId, $situacaoId), true);

                if(isset($response['error'])){
                    if($response['error']['type'] == "VALIDATION_ERROR"){
                        echo "<div class=\"alert alert-danger\">".$response['error']['message'];
                        foreach($response['error']['fields'] as $msg){
                            $mensagem = $msg['msg'];
                            echo "<br>".$mensagem;
                        }
                        echo "</div>";
                    }
                }else{
                    echo "<div class=\"alert alert-success\">Situação alterada com sucesso</div>";
                }
            ?>
        </div>
        <div class="buttons">
            <a href="pedido_visualizacao.php?pedidoId=<?= $pedidoId ?>" class="btn btn-primary">Voltar</a>
            <a href="orcamentos.php" class="btn btn-primary ms-1">Orçamentos</a>
        </div>
    </div>

    <?php
        function alteraStatus($pedidoId,$novoStatusId){

            $url = "https://api.bling.com.br/Api/v3/pedidos/vendas/$pedidoId/situacoes/$novoStatusId";
            
            $jsonFile = file_get_contents('config/token_request_response.json');
            $jsonData = json_decode($jsonFile, true);
            $token = isset($jsonData['access_token'])?$jsonData['access_token']:"";

            $headers = [
                "Accept: application/json",
                "Authorization: Bearer $token"
            ];

            // Inicializa o cURL
            $ch = curl_init();

            // Configurações da requisição PATCH
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Executa a requisição
            $response = curl_exec($ch);

            // Verifica erros
            if (curl_errno($ch)) {
                echo "Erro: " . curl_error($ch);
            } else {
                // Exibe a resposta
                return $response;
            }

            // Fecha a conexão cURL
            curl_close($ch);
        }
    ?>
</body>
</html>
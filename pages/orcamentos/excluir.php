<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('../../partials/head.php'); ?>
    <title>Excluindo orçamento</title>
</head>
<body>
    <?php
        require('../../controller/login_checker.php');
        require('../../partials/navbar.php');

        $pedidoId = isset($_GET['pedidoId'])?$_GET['pedidoId']:"";
    
        if(isset($pedidoId) && $pedidoId !== ""){
    ?>

            <div class="container">
                <div class="mt-3">
                    <?php
                        $response = json_decode(alteraStatus($pedidoId), true);

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
                            echo "<div class=\"alert alert-success\">Orçamento excluído</div>";
                        }
                    ?>
                </div>
                <div class="buttons">
                    <a href="listar.php" class="btn btn-primary">Voltar</a>
                </div>
            </div>

    <?php
        } else {
            echo "<div class=\"container\">";
            echo "<div class=\"alert alert-danger mt-2\">Pedido não encontrado</div>";
            echo "</div>";
        }



        
        function alteraStatus($pedidoId){
            $url = "https://api.bling.com.br/Api/v3/pedidos/vendas?idsPedidosVendas[]=$pedidoId";
            // $url = "https://api.bling.com.br/Api/v3/pedidos/vendas?idsPedidosVendas[]=".$pedidoId;
            
            $jsonFile = file_get_contents('../../config/token_request_response.json');
            $jsonData = json_decode($jsonFile, true);
            if(isset($jsonData['access_token']) && $jsonData['access_token'] !== ""){
                $token = $jsonData['access_token'];
            } else {
                echo "<div class=\"alert alert-danger\">Erro: access_token não definido. Favor entrar em contato com um administrador do sistema</div>";
            }

            $headers = [
                "Accept: application/json",
                "Authorization: Bearer $token"
            ];

            // Inicializa o cURL
            $ch = curl_init();

            // Configurações da requisição PATCH
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
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
        }
    ?>
</body>
</html>
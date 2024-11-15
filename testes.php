<?php

// RETORNA O ID DOS PRODUTOS
// echo consultaProdutoId([44, 45]);

function consultaProdutoId($listaProdutos){
    global $m2;
    $link = "";
    foreach($listaProdutos as $produto){
        $link .= "&codigos%5B%5D=$produto";
    }
    $url = "https://api.bling.com.br/Api/v3/produtos?$link";
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
    
    echo "<script>console.log('Consulta produtos')</script>";
    echo "<script>console.log($response)</script>";
    
    foreach($responseData as $item){
        $teste = $item;
    }
    echo "<pre>";
    print_r($responseData['data']);
    echo "</pre>";
}



//  pf24	Perfil Fechado Meia Cana #24				
//  GUI70	Guia 70 x 30				
//  AC300	Motor AC 300				
//  EIX11	Eixo Tubo 114,3				
//  SOLT	Soleira em T Reforçada				
//  BOR	Borracha para soleira	

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário com Tabela</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <form action="#" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Selecionar</th>
                        <th scope="col">Item</th>
                        <th scope="col">Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="item1" id="item1">
                                <label class="form-check-label" for="item1"></label>
                            </div>
                        </td>
                        <td>Item 1</td>
                        <td>Descrição do Item 1</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="item2" id="item2">
                                <label class="form-check-label" for="item2"></label>
                            </div>
                        </td>
                        <td>Item 2</td>
                        <td>Descrição do Item 2</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="item3" id="item3">
                                <label class="form-check-label" for="item3"></label>
                            </div>
                        </td>
                        <td>Item 3</td>
                        <td>Descrição do Item 3</td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

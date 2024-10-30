<?php
// echo "cliente: " . $cliente = isset($_POST['cliente'])?$_POST['cliente']:""; echo "<br>";
// echo "documento: " . $documento = isset($_POST['documento'])?$_POST['documento']:""; echo "<br>";
// echo "tipoPessoa: " . $tipoPessoa = isset($_POST['tipoPessoa'])?$_POST['tipoPessoa']:""; echo "<br>";
// echo "endereco: " . $endereco = isset($_POST['endereco'])?$_POST['endereco']:""; echo "<br>";
// echo "numero: " . $numero = isset($_POST['numero'])?$_POST['numero']:""; echo "<br>";
// echo "bairro: " . $bairro = isset($_POST['bairro'])?$_POST['bairro']:""; echo "<br>";
// echo "municipio: " . $municipio = isset($_POST['municipio'])?$_POST['municipio']:""; echo "<br>";
// echo "estado: " . $estado = isset($_POST['estado'])?$_POST['estado']:""; echo "<br>";
// echo "tabelaPreco: " . $tabelaPreco = isset($_POST['tabelaPreco'])?$_POST['tabelaPreco']:""; echo "<br>";
// echo "tel: " . $tel = isset($_POST['tel'])?$_POST['tel']:""; echo "<br>";
// echo "cel: " . $cel = isset($_POST['cel'])?$_POST['cel']:""; echo "<br>";
// echo "email: " . $email = isset($_POST['email'])?$_POST['email']:""; echo "<br>";
// echo "condicaoPagamento: " . $condicaoPagamento = isset($_POST['condicaoPagamento'])?$_POST['condicaoPagamento']:""; echo "<br>";
// echo "email: " . $email = isset($_POST['email'])?$_POST['email']:""; echo "<br>";
// echo "enderecoServico: " . $enderecoServico = isset($_POST['enderecoServico'])?$_POST['enderecoServico']:""; echo "<br>";
// echo "numeroServico: " . $numeroServico = isset($_POST['numeroServico'])?$_POST['numeroServico']:""; echo "<br>";
// echo "bairroServico: " . $bairroServico = isset($_POST['bairroServico'])?$_POST['bairroServico']:""; echo "<br>";
// echo "estadoServico: " . $estadoServico = isset($_POST['estadoServico'])?$_POST['estadoServico']:""; echo "<br>";
// echo "observacoes: " . $observacoes = isset($_POST['observacoes'])?$_POST['observacoes']:""; echo "<br>";
// echo "observacoesInternas: " . $observacoesInternas = isset($_POST['observacoesInternas'])?$_POST['observacoesInternas']:""; echo "<br>";


// Dados da instalação
echo "quantidade: " . $quantidade = isset($_POST['quantidade'])?$_POST['quantidade']:""; echo "<br>";
echo "largura: " . $largura = isset($_POST['largura'])?$_POST['largura']:""; echo "<br>";
echo "altura: " . $altura = isset($_POST['altura'])?$_POST['altura']:""; echo "<br>";
echo "rolo: " . $rolo = isset($_POST['rolo'])?$_POST['rolo']:""; echo "<br>";

// m2 = ((Altura + Rolo) * Largura) * Quantidade





//Modelo de dados
$bodyData = [
    "contato" => [
        "id" => "<integer>",
        "tipoPessoa" => "J",
        "numeroDocumento" => "<string>"
    ],
    "data" => "<date>",
    "dataPrevista" => "<date>",
    "dataSaida" => "<date>",
    "itens" => [
        [
            "quantidade" => "<float>",
            "valor" => "<float>",
            "descricao" => "<string>",
            "codigo" => "<string>",
            "unidade" => "<string>",
            "desconto" => "<float>",
            "aliquotaIPI" => "<float>",
            "descricaoDetalhada" => "<string>",
            "produto" => [
                "id" => "<integer>"
            ],
            "comissao" => [
                "base" => "<float>",
                "aliquota" => "<float>",
                "valor" => "<float>"
            ]
        ],
        [
            "quantidade" => "<float>",
            "valor" => "<float>",
            "descricao" => "<string>",
            "codigo" => "<string>",
            "unidade" => "<string>",
            "desconto" => "<float>",
            "aliquotaIPI" => "<float>",
            "descricaoDetalhada" => "<string>",
            "produto" => [
                "id" => "<integer>"
            ],
            "comissao" => [
                "base" => "<float>",
                "aliquota" => "<float>",
                "valor" => "<float>"
            ]
        ]
    ],
    "parcelas" => [
        [
            "id" => "<integer>",
            "dataVencimento" => "<date>",
            "valor" => "<float>",
            "formaPagamento" => [
                "id" => "<integer>"
            ],
            "observacoes" => "<string>"
        ],
        [
            "id" => "<integer>",
            "dataVencimento" => "<date>",
            "valor" => "<float>",
            "formaPagamento" => [
                "id" => "<integer>"
            ],
            "observacoes" => "<string>"
        ]
    ],
    "numero" => "<integer>",
    "numeroLoja" => "<string>",
    "loja" => [
        "id" => "<integer>"
    ],
    "numeroPedidoCompra" => "<string>",
    "outrasDespesas" => "<float>",
    "observacoes" => "<string>",
    "observacoesInternas" => "<string>",
    "desconto" => [
        "valor" => "<float>",
        "unidade" => "REAL"
    ],
    "categoria" => [
        "id" => "<integer>"
    ],
    "tributacao" => [
        "totalICMS" => "<float>",
        "totalIPI" => "<float>"
    ],
    "transporte" => [
        "fretePorConta" => 1,
        "frete" => "<float>",
        "quantidadeVolumes" => "<integer>",
        "pesoBruto" => "<float>",
        "prazoEntrega" => "<integer>",
        "contato" => [
            "nome" => "<string>",
            "id" => "<integer>"
        ],
        "etiqueta" => [
            "nome" => "<string>",
            "endereco" => "<string>",
            "numero" => "<string>",
            "complemento" => "<string>",
            "municipio" => "<string>",
            "uf" => "<string>",
            "cep" => "<string>",
            "bairro" => "<string>",
            "nomePais" => "<string>"
        ],
        "volumes" => [
            [
                "id" => "<integer>",
                "servico" => "<string>",
                "codigoRastreamento" => "<string>"
            ],
            [
                "id" => "<integer>",
                "servico" => "<string>",
                "codigoRastreamento" => "<string>"
            ]
        ]
    ],
    "vendedor" => [
        "id" => "<integer>"
    ],
    "intermediador" => [
        "cnpj" => "<string>",
        "nomeUsuario" => "<string>"
    ],
    "taxas" => [
        "taxaComissao" => "<float>",
        "custoFrete" => "<float>",
        "valorBase" => "<float>"
    ]
];

?>
<?php
echo isset($_POST['cliente'])?$_POST['cliente']."<br>":"";
echo isset($_POST['documento'])?$_POST['documento']."<br>":"";
echo isset($_POST['tipoPessoa'])?$_POST['tipoPessoa']."<br>":"";
echo isset($_POST['endereco'])?$_POST['endereco']."<br>":"";
echo isset($_POST['numero'])?$_POST['numero']."<br>":"";
echo isset($_POST['bairro'])?$_POST['bairro']."<br>":"";
echo isset($_POST['municipio'])?$_POST['municipio']."<br>":"";
echo isset($_POST['estado'])?$_POST['estado']."<br>":"";
echo isset($_POST['tabelaPreco'])?$_POST['tabelaPreco']."<br>":"";
echo isset($_POST['tel'])?$_POST['tel']."<br>":"";
echo isset($_POST['cel'])?$_POST['cel']."<br>":"";
echo isset($_POST['email'])?$_POST['email']."<br>":"";
echo isset($_POST['condicaoPagamento'])?$_POST['condicaoPagamento']."<br>":"";
// telefone
// celular
// email
// quantidade
// largura
// altura
// rolo
// enderecoServico
// numeroServico
// bairroServico
// estadoServico
// observacoes
// observacoesInternas


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
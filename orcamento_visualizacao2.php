<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        h1 {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #007bff;
        }

        h5 {
            margin: 5px 0;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
        }

        .totals {
            margin: 20px 0;
            text-align: right;
        }

        .totals h4 {
            margin: 0;
            color: #007bff;
        }

        .note {
            font-size: 0.8em;
            color: #666;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Espaço para o logotipo -->
        <div class="logo">
            <img src="caminho/para/seu-logotipo.png" alt="Logotipo da Empresa">
        </div>

        <h1>Orçamento</h1>

        <!-- Dados do cliente e orçamento -->
        <div class="row mb-1">
            <div class="col-md-6">
                <h5>Cliente: <strong>Nome de Exemplo</strong></h5>
            </div>
            <div class="col-md-6 text-end">
                <h5>Data: <strong>20/10/2024</strong></h5>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-8">
                <h5>Endereço: <strong>Endereço de Exemplo, 296</strong></h5>
            </div>
            <div class="col-md-4 text-end">
                <h5>Bairro: <strong>Bairro Exemplo</strong></h5>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <h5>Município: <strong>Exemplo</strong></h5>
            </div>
            <div class="col-md-6 text-end">
                <h5>Estado: <strong>RJ</strong></h5>
            </div>
        </div>

        <!-- Número do orçamento -->
        <div class="row bg-light p-2">
            <div class="col-md-12 text-center">
                <h5>Número do Orçamento: <strong>20242010129</strong></h5>
            </div>
        </div>

        <!-- Tabela de dados do orçamento -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Quantidade</th>
                    <th>Largura (m)</th>
                    <th>Altura (m)</th>
                    <th>Rolo (m)</th>
                    <th>m²</th>
                    <th>Peso Total (kg)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1,42</td>
                    <td>2,20</td>
                    <td>0,50</td>
                    <td>3,83</td>
                    <td>46,01</td>
                </tr>
            </tbody>
        </table>

        <!-- Tabela de produtos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Und</th>
                    <th>Qtd</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>3</td>
                    <td>Perfil Fechado Meia Cana #24</td>
                    <td>m²</td>
                    <td>3,83</td>
                    <td>R$ 170,00</td>
                    <td>R$ 651,78</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Guia 50 x 30</td>
                    <td>ml</td>
                    <td>4,50</td>
                    <td>R$ 64,00</td>
                    <td>R$ 288,00</td>
                </tr>
                <tr>
                    <td>200</td>
                    <td>Motor AC 200</td>
                    <td>Und</td>
                    <td>1,00</td>
                    <td>R$ 900,00</td>
                    <td>R$ 900,00</td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>Eixo Tubo 114,3</td>
                    <td>ml</td>
                    <td>1,42</td>
                    <td>R$ 100,00</td>
                    <td>R$ 142,00</td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>Soleira em T Reforçada</td>
                    <td>ml</td>
                    <td>1,42</td>
                    <td>R$ 100,00</td>
                    <td>R$ 142,00</td>
                </tr>
                <tr>
                    <td>2002</td>
                    <td>Borracha para soleira</td>
                    <td>ml</td>
                    <td>1,42</td>
                    <td>R$ 7,00</td>
                    <td>R$ 9,94</td>
                </tr>
            </tbody>
        </table>

        <!-- Subtotal, desconto e total -->
        <div class="row totals">
            <div class="col-md-12">
                <p><strong>SUBTOTAL:</strong> R$ 3.633,72</p>
                <p><strong>DESCONTO:</strong> 15,00%</p>
                <h4><strong>TOTAL:</strong> R$ 4.178,78</h4>
            </div>
        </div>

        <!-- Aviso adicional -->
        <p class="note">
            ESTE ORÇAMENTO PODERÁ TER VARIAÇÃO PARA MAIS OU PARA MENOS EM SEU VALOR FINAL, POIS APÓS APROVAÇÃO, UM DOS PROFISSIONAIS DA INVICTOS PORTAS IRÁ ATÉ SUA OBRA FAZER A CONFERÊNCIA DAS MEDIDAS, PARA QUE SUA PORTA DE ENROLAR SEJA FABRICADA NA MEDIDA EXATA.
        </p>

        <!-- Informações da empresa -->
        <div class="footer">
            <p><strong>C S SILVA PORTAS AUTOMATICAS LTDA</strong></p>
            <p>RUA CEARÁ, 310, FAZENDA SOBRADINHO, MAGÉ/RJ, CEP: 25.932-145</p>
            <p>Tel: (21) 97200-1200 | (21) 99827-2006</p>
            <p>Email: admin@invictosportas.com.br</p>
            <p>Instagram: @invictosportasautomaticas</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

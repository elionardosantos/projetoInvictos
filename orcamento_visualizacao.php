<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Início</title>
    <style>
        body {
            margin: 5px;
        }
        @media print {
            body {
                /* Para impressão em cores exatas */
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <?php
        require('controller/login_checker.php');
    ?>
    <div class="py-2 px-5 mb-4 d-print-none">
        <a href="" class="btn btn-primary" onclick="window.close()">Voltar</a>
        <a href="" class="btn btn-primary">Editar</a>
        <a href="" class="btn btn-primary" onclick="window.print()">Imprimir</a>
    </div>
    <div class="">
        <!-- Área do cabeçalho -->
        <div class="row align-items-center">
            <!-- Dados do cliente -->
            <div class="col-8">
                <div class="row">
                    <div class="col">Cliente: <strong>Nome do cliente</strong></div>
                </div>
                <div class="row">
                    <div class="col">Endereço: <strong>Endereço do cliente</strong></div>
                </div>
                <div class="row">
                    <div class="col">Bairro: <strong>Bairro de Exemplo</strong></div>
                    <div class="col-4">Número: <strong>1234</strong></div>
                </div>
                <div class="row">
                    <div class="col-8">Município: <strong>Município do Cliente</strong></div>
                    <div class="col-4">Estado: <strong>RJ</strong></div>
                </div>
                <div class="row">
                    <div class="col">Data: <strong>21/10/2024</strong></div>
                </div>
            </div>

            <!-- Logo -->
            <div class="col-4 text-end">
                <img class="logo img-fluid" src="assets/img/logo.png" alt="Logo">
            </div>
        </div>

        <!-- Número do orçamento -->
        <div class="row mt-3 mx-0 bg-dark text-white">
            <div class="col text-center fs-5">
                Número do orçamento: <strong>123456</strong>
            </div>
        </div>
        
        <!-- Tabela de dados do orçamento -->
        <table class="table table-sm table-bordered mt-3 text-center">
            <thead class="table-dark">
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
        <table class="table table-bordered table-sm text-center mt-3 mb-1">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Material</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
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
                    <td>Un</td>
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
        <div class="row mx-0 mt-1">
            <div class="col-7"></div>
            <div class="col-3 bg-dark text-white py-1">Subtotal:</div>
            <div class="col-2 bg-dark text-white py-1"><strong>R$2.800,00</strong></div>
        </div>
        

         <!-- Tabela de Serviços -->
         <table class="table table-bordered table-sm text-center mt-3 mb-1">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Serviço</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>3</td>
                    <td>Alçapão</td>
                    <td>Und</td>
                    <td>1</td>
                    <td>R$400,00</td>
                    <td>R$400,00</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Pintura eletrostática</td>
                    <td>m²</td>
                    <td>18,20</td>
                    <td>R$60,00</td>
                    <td>R$1.092,00</td>
                </tr>
                <tr>
                    <td>200</td>
                    <td>Mão de Obra Instalação até 100 km</td>
                    <td>Un</td>
                    <td>1,00</td>
                    <td>R$1.500,00</td>
                    <td>R$1.500,00</td>
                </tr>
            </tbody>
        </table>
        <div class="row mx-0 mt-1">
            <div class="col-7"></div>
            <div class="col-3 bg-dark text-white py-1">Subtotal:</div>
            <div class="col-2 bg-dark text-white py-1"><strong>R$2.950,00</strong></div>
        </div>
        <table class="table table-bordered mt-3 text-center table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Total sem desconto</th>
                    <th>Desconto</th>
                    <th>Total com desconto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>R$5.750,00</th>
                    <th>R$15%</th>
                    <th>R$5.420,00</th>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <p class="fs-7">
            Este orçamento poderá ter variação para mais ou para menos em seu valor final, pois após aprovação, um dos profissionais da Invictos Portas irá até o seu estabelecimento fazer a conferência das medidas, para que sua porta de enrolar seja fabricada na medida exata.
        </p>
        <p class="text-center">
            C S Silva Portas Automáticas LTDA / Rua Ceará, 310, Fazenda Sobradinho, Magé/RJ, CEP: 25.932-145
        </p>
        <p class="text-center">
            (21) 97200-1200 / (21) 99827-2006 <br>@invictosportasautomaticas / admin@invictosportas.com.br
        </p>
    </div>
</body>
</html>
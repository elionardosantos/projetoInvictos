<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Novo orçamento</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container">
        <p>
            <h2>Novo orçamento</h2>
        </p>
    </div>
    <div class="container">
        <a href="">
            <button class="btn btn-primary">Consultar CNPJ</button>

        </a>
    </div>
    <div class="container mt-4">
        <form>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cliente" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cliente" placeholder="CNPJ do Cliente">
                </div>
                <div class="col-md-6">
                    <label for="data" class="form-label">Razão Social</label>
                    <input type="text" class="form-control" id="data" placeholder="Razão social do Cliente">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="cliente" class="form-label">Cliente</label>
                    <input type="text" class="form-control" id="cliente" placeholder="Nome do Cliente">
                </div>
                <div class="col-md-4">
                    <label for="cliente" class="form-label">CPF</label>
                    <input type="number" class="form-control" id="cliente" placeholder="CPF">
                </div>
                <div class="col-md-3">
                    <label for="data" class="form-label">Data</label>
                    <input type="date" class="form-control" id="data">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" placeholder="Rua, Avenida, etc.">
                </div>
                <div class="col-md-4">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" placeholder="Número">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" placeholder="Bairro">
                </div>
                <div class="col-md-4">
                    <label for="municipio" class="form-label">Município</label>
                    <input type="text" class="form-control" id="municipio" placeholder="Município">
                </div>
                <div class="col-md-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado">
                        <option selected>Escolha...</option>
                        <option value="RJ">RJ</option>
                        <option value="SP">SP</option>
                        <option value="MG">MG</option>
                        <!-- Adicione mais opções conforme necessário -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tabela" class="form-label">Tabela</label>
                    <input type="text" class="form-control" id="tabela" value="Consumidor Final" readonly>
                </div>
                <div class="col-md-6">
                    <label for="condicao" class="form-label">Condição de Pagto</label>
                    <input type="text" class="form-control" id="condicao" value="À Vista" readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>
</html>
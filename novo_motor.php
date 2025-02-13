<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require('partials/head.php'); ?>
    <title>Novo Produto</title>
</head>
<body>
    <?php
        require('controller/login_checker.php');
        require('partials/navbar.php');

    ?>
    <div class="container my-3">
        <h2>
            Novo produto
        </h2>
    </div>
    <div class="container">
        <form action="novo_motor_process.php" method="post">
            <div class="mt-5">
                <h4>Dados do produto</h4>
            </div>
            <div class="row">
                <div class="col-lg-2 mt-2">
                    <label for="codigo_produto" class="form-label mb-0">Código</label>
                    <input class="form-control" name="codigo_produto" type="text" placeholder="No Bling" id="codigo_produto" required>
                </div>
                <div class="col-lg-4 mt-2">
                    <label for="titulo_produto" class="form-label mb-0">Título</label>
                    <input class="form-control" name="titulo_produto" type="text" placeholder="Como aparecerá no orçamento" id="titulo_produto">
                </div>
                <!-- <div class="col-lg-2 mt-2">
                    <label for="peso_produto" class="form-label mb-0">Peso</label>
                    <input class="form-control" name="peso_produto" type="text" inputmode="decimal" placeholder="Em KG" id="peso_produto" required>
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="consumo_produto" class="form-label mb-0">Consumo tipo*</label>
                    <select class="form-select" name="consumo_produto" id="consumo_produto">
                        <option value="m2">Metro quadrado</option>
                        <option value="altura">Altura</option>
                        <option value="largura">Largura</option>
                        <option value="peso">Peso</option>
                        <option value="unidade">Unidade</option>
                    </select>
                </div> -->
                <div class="col-lg-2 mt-2">
                    <label for="multiplicador_produto" class="form-label mb-0">Multiplicador</label>
                    <input value="1" class="form-control" name="multiplicador_produto" type="text" inputmode="decimal" placeholder="Fator de multiplicação" id="multiplicador_produto" required>
                </div>
            </div>
            <!-- <div class="mt-5">
                <h4>Faixa de Dimensões</h4>
            </div>
            <div class="row">
                <div class="col-lg-2 mt-2">
                    <label for="largura_minima" class="form-label mb-0">Largura mínima</label>
                    <input value="0" class="form-control" name="largura_minima" type="text" inputmode="decimal" placeholder="Largura mínima" id="largura_minima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="largura_maxima" class="form-label mb-0">Largura máxima</label>
                    <input value="100" class="form-control" name="largura_maxima" type="text" inputmode="decimal" placeholder="Largura máxima" id="largura_maxima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="altura_minima" class="form-label mb-0">Altura mínima</label>
                    <input value="0" class="form-control" name="altura_minima" type="text" inputmode="decimal" placeholder="Altura Mínima" id="altura_minima">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="altura_maxima" class="form-label mb-0">Altura máxima</label>
                    <input value="100" class="form-control" name="altura_maxima" type="text" inputmode="decimal" placeholder="Altura Máxima" id="altura_maxima">
                </div>
            </div> -->
            <div class="mt-5">
                <h4>Faixa de Peso</h4>
            </div>
            <div class="row">
                <div class="col-lg-2 mt-2">
                    <label for="peso_minimo" class="form-label mb-0">Peso mínimo</label>
                    <input class="form-control" name="peso_minimo" type="text" inputmode="decimal" placeholder="Peso mínimo" id="peso_minimo">
                </div>
                <div class="col-lg-2 mt-2">
                    <label for="peso_maximo" class="form-label mb-0">Peso máximo</label>
                    <input class="form-control" name="peso_maximo" type="text" inputmode="decimal" placeholder="Peso máximo" id="peso_maximo">
                </div>
            </div>
            
            <div class="mt-5">
                <h4>Outro</h4>
            </div>
            <div class="row">
                <div class="col-lg-2 mt-2">
                    <label for="selecionado" class="form-label mb-0">Selecionado</label>
                    <select name="selecionado" id="selecionado" class="form-select">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <input class="btn btn-primary" type="submit" value="Salvar">
                <a href="motores.php" class="btn btn-primary ms-2">Voltar</a>
            </div>
        </form>
    </div>
    <div class="container mt-4">
    </div>
</body>
</html>
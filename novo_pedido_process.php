<?php

// Dados do contato
$contatoId = isset($_POST['contatoId'])?$_POST['contatoId']:"";
$cliente = isset($_POST['cliente'])?$_POST['cliente']:"";
$documento = isset($_POST['documento'])?$_POST['documento']:"";
$tipoPessoa = isset($_POST['tipoPessoa'])?$_POST['tipoPessoa']:"";
$endereco = isset($_POST['endereco'])?$_POST['endereco']:"";
$numero = isset($_POST['numero'])?$_POST['numero']:"";
$bairro = isset($_POST['bairro'])?$_POST['bairro']:"";
$municipio = isset($_POST['municipio'])?$_POST['municipio']:"";
$estado = isset($_POST['estado'])?$_POST['estado']:"";
$tabelaPreco = isset($_POST['tabelaPreco'])?$_POST['tabelaPreco']:"";
$condicaoPagamento = isset($_POST['condicaoPagamento'])?$_POST['condicaoPagamento']:"";

// Dados de contato
$tel = isset($_POST['tel'])?$_POST['tel']:"";
$cel = isset($_POST['cel'])?$_POST['cel']:"";
$email = isset($_POST['email'])?$_POST['email']:"";

// Dados da instalação
echo "quantidade: " . $quantidade = isset($_POST['quantidade'])?floatval(str_replace(",",".",str_replace(".","",$_POST['quantidade']))):""; echo "<br>";
echo "largura: " . $largura = isset($_POST['largura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['largura']))):""; echo "<br>";
echo "altura: " . $altura = isset($_POST['altura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['altura']))):""; echo "<br>";
echo "rolo: " . $rolo = isset($_POST['rolo'])?floatval(str_replace(",",".",str_replace(".","",$_POST['rolo']))):""; echo "<br>";

// Local do serviço
$enderecoServico = isset($_POST['enderecoServico'])?$_POST['enderecoServico']:"";
$numeroServico = isset($_POST['numeroServico'])?$_POST['numeroServico']:"";
$bairroServico = isset($_POST['bairroServico'])?$_POST['bairroServico']:"";
$municipioServico = isset($_POST['municipioServico'])?$_POST['municipioServico']:"";
$estadoServico = isset($_POST['estadoServico'])?$_POST['estadoServico']:"";

// Dados adicionais
$observacoes = isset($_POST['observacoes'])?$_POST['observacoes']:"";
$observacoesInternas = isset($_POST['observacoesInternas'])?$_POST['observacoesInternas']:"";


// $m2 = (($altura + $rolo) * $largura) * $quantidade;
// $pesoPortaUnitario = ($m2 * 8) * 1.2;

echo "<hr>";
consultaContatoId($contatoId);

function consultaContatoId($contatoId){
    echo $url = "https://api.bling.com.br/Api/v3/contatos/$contatoId";

}


?>

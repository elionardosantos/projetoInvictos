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
echo "quantidade: " . $quantidade = isset($_POST['quantidade'])?floatval(str_replace(",",".",str_replace(".","",$_POST['quantidade']))):""; echo "<br>";
echo "largura: " . $largura = isset($_POST['largura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['largura']))):""; echo "<br>";
echo "altura: " . $altura = isset($_POST['altura'])?floatval(str_replace(",",".",str_replace(".","",$_POST['altura']))):""; echo "<br>";
echo "rolo: " . $rolo = isset($_POST['rolo'])?floatval(str_replace(",",".",str_replace(".","",$_POST['rolo']))):""; echo "<br>";

$m2 = (($altura + $rolo) * $largura) * $quantidade;
$pesoPortaUnitario = ($m2 * 8) * 1.2;


?>

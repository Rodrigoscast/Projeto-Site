<?php
session_start();
ini_set('default_charset', 'UTF-8');
include "../admin-page/conexao.php";

$carrinho = $_SESSION["carrinho"];
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$forma = $_POST['forma_pagamento'];

$mensagem = 'Baldochi Acessórios

Prezado(a) Baldochi,

Uma compra acaba de ser feita no seu site! Abaixo estão os detalhes da sua compra:

Produtos:

';

$totalCompra = 0;

foreach ($carrinho as $key => $value) {

    $query = "SELECT * FROM produtos WHERE idproduto = $value";
    $exec = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($exec);

    $titulo = $row['titulo'];
    $quantidade = $_POST["valor_$value"];
    $valor = $row['valor'];
    $valorAtt = 'R$ ' . number_format($valor, 2, ',', '.');

    $tot = $valor * intval($quantidade);
    $totalCompra += $tot;
    $tot = number_format($tot, 2, ',', '.');




    $mensagem .= "
    $titulo

    ID do Produto: $value
    Quantidade: $quantidade
    Valor Unitário: $valorAtt
    Total desse Produto: $tot
    ";
}

$totalCompra = number_format($totalCompra, 2, ",", ".");

$mensagem .= "
Informações do Comprador:

Nome: $nome
Endereço: $endereco
Forma de Pagamento: $forma
Total da Compra: $totalCompra";

$params=array(
'token' => '66y5msrfkeofrmv7',
'to' => '+5516993907729',
'body' => $mensagem
);
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.ultramsg.com/instance67692/messages/chat",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => http_build_query($params),
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

foreach ($carrinho as $key => $value) {
  $query = "SELECT * FROM produtos WHERE idproduto = $value";
  $exec = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($exec);
  $atual = $row['vendidos'];
  $quantidade = $_POST["valor_$value"];
  $total = $atual + $quantidade;

  $query = "UPDATE produtos SET vendidos = '$total'";
  $executa = mysqli_query($db, $query);
}

header("Location: index.php");
// unset($_SESSION["carrinho"]);
?>
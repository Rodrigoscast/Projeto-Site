<?php
ini_set('default_charset', 'UTF-8');
include("../conexao.php");
include "guardiao2.php";


if(isset($_POST['titulo']) && isset($_POST['valor']) && isset($_POST['etiqueta'])) {
    $titulo = $db->real_escape_string($_POST['titulo']);
    $etiqueta = $db->real_escape_string($_POST['etiqueta']);
    $descricao = $db->real_escape_string($_POST['descricao']);
    $valor = $db->real_escape_string($_POST['valor']);

    $valor = str_replace("R$", "", $valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", ".", $valor);

    $id = $_GET['id'];

    
    $query = "UPDATE produtos SET titulo = '$titulo', etiqueta = '$etiqueta', descricao = '$descricao', valor = '$valor'
              WHERE idproduto = $id";
    $executa_query = mysqli_query($db, $query) or die("Erro ao executar Query");
}

header("Location: ../produto.php");

?>

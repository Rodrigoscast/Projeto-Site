<?php
ini_set('default_charset', 'UTF-8');
include "../conexao.php";
include "guardiao2.php";

if (isset($_POST["novoNome"])) {
    $novoNome = $db->real_escape_string($_POST['novoNome']);
    
    // Prepare e execute a inserção no banco de dados
    $query = "INSERT INTO filtros (nome_filtro) VALUES ('$novoNome')";
    $executa = mysqli_query($db, $query) or die(mysqli_error($link));
}

header("Location: ../etiqueta.php");
?>

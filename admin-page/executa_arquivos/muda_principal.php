<?php
ini_set('default_charset', 'UTF-8');
include "guardiao2.php";
include "../conexao.php";

$img = $_GET['img'];

//Retira principal atual

$query = "UPDATE destaques SET principal = 0 WHERE principal = 1";
$executa_query = mysqli_query($db, $query);

//Adiciona nova principal

$query = "UPDATE destaques SET principal = 1 WHERE url_img = '$img'";
$executa_query = mysqli_query($db, $query);

header("Location: ../destaques.php");

?>
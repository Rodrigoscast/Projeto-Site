<?php
$hostname ="localhost";
$username ="root";
$senha ="";
$banco ="baldochi_acessorios";

$db = new mysqli($hostname, $username, $senha, $banco);

if($db->connect_errno){
    echo "Falha ao conectar: (" . $db->connect_errno. ") " . $db->connect_error;
}
mysqli_set_charset($db,"utf8");

?>
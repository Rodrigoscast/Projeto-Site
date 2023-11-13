<?php
ini_set('default_charset', 'UTF-8');
include "../admin-page/conexao.php";
include "../admin-page/executa_arquivos/guardiao.php";

if(isset($_POST['id_atual'])){
    $id = $_POST['id_atual'];
    $id = mysqli_real_escape_string($db, $id);

    $dir = "../admin-page/fotos/$id";
    $imagens = array();

    $query = "SELECT * FROM produtos WHERE idproduto = $id";
    $exec = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($exec);

    $main = $row['url_main'];

    array_push($imagens, $main);

    if (is_dir($dir)) {
        $arquivos = scandir($dir);

        foreach ($arquivos as $arquivo) {
            if($arquivo != '.' && $arquivo != '..' && $arquivo != $main){
                array_push($imagens, $arquivo);
            }
        }
    }

    // Exibe a lista de nomes de imagens
    header('Content-Type: application/json');
    echo json_encode(array_map('htmlspecialchars', $imagens));
} else {
    header('Content-Type: application/json');
    echo json_encode("Id não existe!");
}

?>
<?php
ini_set('default_charset', 'UTF-8');
include("../conexao.php");
include "guardiao2.php";

function deleteDirectory($id) {
    $dir = "../fotos/$id/";
    if (is_dir($dir)) {
        $objects = scandir($dir);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $path = $dir . "/" . $object;

                if (is_dir($path)) {
                    // Se for um diretório, chame a função recursivamente
                    deleteDirectory($path);
                } else {
                    // Se for um arquivo, exclua-o
                    unlink($path);
                }
            }
        }

        // Após excluir todos os arquivos, exclua a própria pasta
        rmdir($dir);
    }
}


if(isset($_GET['id'])) {
    $id = $db->real_escape_string($_GET['id']);
    
    $query = "DELETE FROM produtos WHERE idproduto = $id";
    $executa_query = mysqli_query($db, $query) or die("Erro ao executar Query");
    deleteDirectory($id);
}

header("Location: ../produto.php");

?>


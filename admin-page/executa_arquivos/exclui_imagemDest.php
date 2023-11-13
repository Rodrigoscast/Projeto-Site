<?php
ini_set('default_charset', 'UTF-8');
include("../conexao.php");
include "guardiao2.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $uploadDirectory = $_GET['caminho'];

    if (is_dir($uploadDirectory)) {
        $imagem = $_GET['img']; // Nome do arquivo a ser excluído

        $filePath = $uploadDirectory . $imagem;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $query = "DELETE FROM destaques WHERE url_img = '$imagem'";
                $executa = mysqli_query($db, $query);

                header("Location: ../destaques.php");
                die();
            } else {
                echo "Falha ao excluir a imagem $imagem.";
            }
        } else {
            echo "A imagem $imagem não foi encontrada.";
        }
    } else {
        echo "O diretório não existe.";
    }
}

?>
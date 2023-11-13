<?php
ini_set('default_charset', 'UTF-8');
include("../conexao.php");
include "guardiao2.php";

$idproduto = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $uploadDirectory = $_GET['caminho'];

    if (is_dir($uploadDirectory)) {
        $imagem = $_GET['img']; // Nome do arquivo a ser excluído

        $filePath = $uploadDirectory . $imagem;

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                $query = "SELECT * FROM produtos WHERE idproduto = $idproduto";
                $executa = mysqli_query($db, $query);
                $result = mysqli_fetch_assoc($executa);

                if ($result["url_main"] == "$imagem") {
                    $query2 = "UPDATE produtos SET url_main = '' WHERE idproduto = $idproduto";
                    $executas = mysqli_query($db, $query2);
                }

                header("Location: ../adicionar_imagens.php?id=$idproduto");
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
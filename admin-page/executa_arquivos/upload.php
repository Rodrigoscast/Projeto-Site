<?php
ini_set('default_charset', 'UTF-8');
include("../conexao.php");
include "guardiao2.php";

$idproduto = $_GET['id'];

$queryS = "SELECT * from produtos WHERE idproduto = $idproduto";
$executaS = mysqli_query($db, $queryS);
$resultS = mysqli_fetch_assoc($executaS);

if($resultS['url_main'] == ''){
    $status = 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDirectory = "../fotos/$idproduto/"; // Diretório onde as imagens serão salvas

    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true); // Crie o diretório se ele não existir
    }

    $uploadedImages = $_FILES['imagem'];

    foreach ($uploadedImages['name'] as $key => $imageName) {
        $tmpName = $uploadedImages['tmp_name'][$key];
        $uploadPath = $uploadDirectory . $imageName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            if ($status == 1) {
                $query = "UPDATE produtos SET url_main = '$imageName' WHERE idproduto = $idproduto";
                $executa = mysqli_query($db, $query) or die(mysqli_error($db));

                $status = 0;
            }
            header("Location: ../adicionar_imagens.php?id=$idproduto");
        } else {
            echo "Falha ao enviar a imagem $imageName<br>";
        }
    }
}
?>

?>
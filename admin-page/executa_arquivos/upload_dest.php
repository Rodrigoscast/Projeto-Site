<?php
ini_set('default_charset', 'UTF-8');
include("../conexao.php");
include "guardiao2.php";

// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';

// die();

$query_str = "SELECT COUNT(*) as contador FROM destaques";
$executa = mysqli_query($db, $query_str);
$results = mysqli_fetch_assoc($executa);

if($results['contador'] <= 0){
    $status = 1;
} else {
    $status = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(count($_FILES['imagem']['name'], 0) > 0 && $_FILES['imagem']['name']['0'] != ''){
        $uploadDirectory = "../fotos/destaques/"; // Diretório onde as imagens serão salvas

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true); // Crie o diretório se ele não existir
        }

        $uploadedImages = $_FILES['imagem'];

        foreach ($uploadedImages['name'] as $key => $imageName) {
            $tmpName = $uploadedImages['tmp_name'][$key];
            $uploadPath = $uploadDirectory . $imageName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                echo "Imagem $imageName enviada com sucesso";
            } else {
                echo "Falha ao enviar a imagem $imageName<br>";
            }
        }

        foreach ($uploadedImages['name'] as $key => $imageName) {
            $query = "INSERT INTO destaques (url_img, principal) VALUES ('$imageName', $status)";
            $executa_query = mysqli_query($db, $query) or die("Erro ao adicionar imagem ao banco");

            if($status == 1){
                $status = 0;
            }
        }
    }
}

header("Location: ../destaques.php");
?>
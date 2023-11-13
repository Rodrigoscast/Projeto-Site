<?php
ini_set('default_charset', 'UTF-8');
include "./executa_arquivos/guardiao.php";
include "topo.html";

$idproduto = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baldochi</title>
    <link rel="stylesheet" href="style_page.css">
    <link rel="stylesheet" href="topo.css">
</head>
<body>
    <div class="back">
        <div class="ignora_menu"></div>
        <div class="page_center">
            <div class="topo_pagina">
                <div>
                    <h1>Adicionar Imagens</h1>
                </div>
            </div>
            <div class="corpo_pagina">
                <div class="imagens-add">
                    <ul class="image-add">
                    <?php
                        $directory = "fotos/$idproduto/";

                        if (is_dir($directory)) {
                            $files = scandir($directory);

                            foreach ($files as $file) {
                                if ($file != "." && $file != "..") { ?>
                                    <li id="li-isolado">
                                        <img src="./fotos/<?= $idproduto ?>/<?= $file ?>" alt="">
                                        <button class="excluir"><a href="./executa_arquivos/exclui_imagem.php?caminho=<?= "../$directory" ?>&img=<?= $file ?>&id=<?= $idproduto ?>">Excluir</a></button>
                                    </li>
                                <?php }
                            }
                        } else {
                            echo "Nenhuma imagem adicionada";
                        }
                    ?>
                    </ul>
                </div>
                <h2 style="display:none;" id="titulo-2">Imagens ainda não adicionadas:</h2>
                <div class="imagens">
                    <ul class="image-preview"></ul>
                </div>
                
                <form action="./executa_arquivos/upload.php?id=<?= $idproduto ?>" method="post" enctype="multipart/form-data">
                    <div class="div-img">
                        <label for="imagem" class="custom-button">
                            <span>+</span>
                        </label>
                        <input type="file" name="imagem[]" class="input-file" id="imagem" accept="image/*" multiple>
                    </div>
                    <input type="submit" value="Enviar Imagens" class="botao">
                </form>
            </div>
        </div>
    </div>
    <script>
        const input = document.getElementById('imagem');
        const imagePreview = document.querySelector('.image-preview');

        input.addEventListener('change', (e) => {
            var titulo = document.getElementById("titulo-2");
            const files = e.target.files;
            imagePreview.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imagePreview.appendChild(img);
                }

                reader.readAsDataURL(file);
            }
            titulo.style.display = 'flex';
        });
    </script>

</body>
</html>
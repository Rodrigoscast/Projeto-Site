<?php
ini_set('default_charset', 'UTF-8');
include "./executa_arquivos/guardiao.php";
include "topo.html";
include "conexao.php";

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
                    <h1>Adicionar Imagens de Destaque</h1>
                </div>
            </div>
            <div class="corpo_pagina">
                <div class="imagens-add">
                    <ul class="image-add">
                    <?php
                        $directory = "fotos/destaques/";

                        if (is_dir($directory)) {
                            $files = scandir($directory);

                            $contador = 0;

                            foreach ($files as $file) {
                                if ($file != "." && $file != "..") { 
                                    $contador++;
                                }
                            }

                            foreach ($files as $file) {
                                if ($file != "." && $file != "..") { 

                                    $query = "SELECT * FROM destaques WHERE url_img = '$file'";
                                    $executa = mysqli_query($db, $query);
                                    $result = mysqli_fetch_assoc($executa);

                                    $status = $result['principal'];
                                    
                                    if($status == 1){ ?>
                                        <li id="li-isolado">
                                            <img src="./fotos/destaques/<?= $file ?>" alt="">
                                            <?php if($contador > 1){ ?>
                                                <button class="excluir"><a href="./executa_arquivos/exclui_imagemDest.php?caminho=<?= "../$directory" ?>&img=<?= $file ?>">Excluir</a></button>
                                            <?php } ?>
                                            <button class="botao_principal1">Principal</button>
                                        </li>
                                    <?php } else { ?>
                                        <li id="li-isolado">
                                            <img src="./fotos/destaques/<?= $file ?>" alt="">
                                            <?php if($contador > 1){ ?>
                                                <button class="excluir"><a href="./executa_arquivos/exclui_imagemDest.php?caminho=<?= "../$directory" ?>&img=<?= $file ?>">Excluir</a></button>
                                            <?php } ?>
                                            <button class="botao_principal"><a href="./executa_arquivos/muda_principal.php?img=<?= $file ?>">Selecionar</a></button>
                                        </li>
                                    <?php
                                    }
                                }
                            }
                        } else {
                            echo "O diretório não existe.";
                        }
                    ?>
                    </ul>
                </div>
                <h2 style="display:none;" id="titulo-2">Imagens ainda não adicionadas:</h2>
                <div class="imagens">
                    <ul class="image-preview"></ul>
                </div>
                
                <form action="./executa_arquivos/upload_dest.php" method="post" enctype="multipart/form-data">
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
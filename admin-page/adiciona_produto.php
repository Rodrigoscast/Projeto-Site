<?php
ini_set('default_charset', 'UTF-8');
include "./executa_arquivos/guardiao.php";
include "topo.html"
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
                    <h1>Adicionar Produto</h1>
                </div>
            </div>
            <div class="corpo_pagina">
                <form action="./executa_arquivos/adiciona_produto.php" method="post" enctype="multipart/form-data">
                    <div class="central">
                        <div class="textos">
                            <div class="adiciona_item">
                                <input type="text" name="titulo" required>
                                <label for="titulo">Título</label>
                            </div>
                            <div class="line">
                                <div class="adiciona_item">
                                    <select name="etiqueta" required>
                                        <option value="" selected disabled>Etiqueta</option>

                                        <?php 

                                        include "conexao.php";

                                        $query = "SELECT * FROM filtros order by nome_filtro";
                                        $executa = mysqli_query($db, $query);
                                        
                                        while($busca = mysqli_fetch_assoc($executa)){

                                            $id = $busca['id_filtro'];
                                            $nome = $busca['nome_filtro']

                                        ?>

                                            <option value="<?= $id ?>"><?= $nome ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="adiciona_item">
                                <input type="text" name="valor" id="valorInput" required>
                                    <label for="valor">Valor (R$)</label>
                                </div>
                            </div>
                            <div class="adiciona_item">
                                <textarea name="descricao" rows="4"></textarea>
                                <label for="descricao">Descrição</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input class="botao" type="submit" value="Cadastrar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://immobilebusiness.com.br/admin/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="https://immobilebusiness.com.br/admin/assets/js/jquery.maskMoney.js" type="text/javascript"></script>

    <script>
        $(function() {
            $("#valorInput").maskMoney({
                symbol: 'R$ ',
                showSymbol: true,
                thousands: '.',
                decimal: ',',
                symbolStay: true
            });
        })
        document.addEventListener('DOMContentLoaded', function () {
            const descricaoInput = document.querySelector('.adiciona_item textarea');
            const descricaoLabel = document.querySelector('.adiciona_item label[for="descricao"]');

            descricaoInput.addEventListener('focus', function () {
                descricaoLabel.style.top = '-5px';
            });

            descricaoInput.addEventListener('blur', function () {
                if (this.value === '') {
                    descricaoLabel.style.top = '15px';
                }
            });
        });
        // const fileInput = document.getElementById("file-input");
        // const imagePreview = document.getElementById("image-preview");

        // fileInput.addEventListener("change", function () {
        // imagePreview.innerHTML = ""; // Limpa a prévia de imagens

        // for (const file of fileInput.files) {
        //     if (file.type.startsWith("image/")) {
        //     const img = document.createElement("img");
        //     img.src = URL.createObjectURL(file);
        //     imagePreview.appendChild(img);
        //     }
        // }
        // });
    </script>


</body>
</html>
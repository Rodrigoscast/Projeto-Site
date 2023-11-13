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
                    <h1>Filtros dos Produtos</h1>
                </div>
            </div>
            <div class="corpo_pagina">
                <table id="tabela_filtro">
                    <thead>
                        <tr>
                            <th>Nome do Filtro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php 
                         include "conexao.php";
                         $query = "SELECT * FROM filtros ORDER BY nome_filtro";
                         $executa_query = mysqli_query($db, $query);

                         while($busca = mysqli_fetch_assoc($executa_query)){
                            $id = $busca['id_filtro'];
                            $nome = $busca['nome_filtro'];

                            ?>
                            <tr>
                                <td contenteditable="true" onblur="editaFiltro(this, <?= $id ?>)"><?= $nome ?></td>
                                <td>
                                    <?php
                                    $query_produtos = "SELECT COUNT(*) as contador FROM produtos WHERE etiqueta = $id";
                                    $executa_queryProd = mysqli_query($db, $query_produtos);
                                    $resultado = mysqli_fetch_assoc($executa_queryProd);

                                    if($resultado["contador"] == 0){ ?>
                                        <button class="excluir" onclick="excluiFiltro(<?= $id ?>)">Excluir</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="novo-filtro">
                    <button id="adicionarFiltro" onclick="toggleFormulario()">Adicionar Filtro</button>
                    <form id="formulario" style="display: none;" method="POST" action="./executa_arquivos/adiciona_filtro.php">
                        <input type="text" id="novoNome" name="novoNome" placeholder="Nome do Novo Filtro">
                        <button id="salvarFiltro">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para editar o nome do filtro diretamente na tabela
        function editaFiltro(element, id) {
            var novoNome = element.innerText;
            // Envie o ID e o novo nome para o servidor via AJAX (usando PHP)
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    // Atualize o nome na tabela após a conclusão bem-sucedida
                    if (xmlhttp.responseText === "Sucesso") {
                        // A atualização foi bem-sucedida
                        console.log("Nome atualizado com sucesso.");
                    } else {
                        // Houve um erro na atualização
                        console.log("Erro na atualização do nome.");
                        // Restaure o valor original na célula
                        element.innerText = xmlhttp.responseText;
                    }
                }
            };
            xmlhttp.open("POST", "./executa_arquivos/atualiza_filtro.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("id=" + id + "&novo_nome=" + novoNome);
        }

        // Função para excluir um filtro
        function excluiFiltro(id) {
            if (confirm("Tem certeza de que deseja excluir este filtro?")) {
                // Envie a solicitação de exclusão para o servidor via AJAX
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        if (xmlhttp.responseText === "Sucesso") {
                            // Remova a linha da tabela após a exclusão bem-sucedida
                            var row = document.querySelector("tr[data-id='" + id + "']");
                            row.remove();
                            
                        } else {
                            // Exiba uma mensagem de erro em caso de falha
                            console.log("Erro na exclusão do filtro.");
                        }
                    }
                };
                xmlhttp.open("POST", "./executa_arquivos/atualiza_filtro.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("id=" + id + "&action=excluir");
            }
            // Atualize a página
            location.reload();
        }

        // Função para alternar a visibilidade do formulário e do botão "Adicionar Filtro"
    function toggleFormulario() {
        var formulario = document.getElementById("formulario");
        var botaoAdicionar = document.getElementById("adicionarFiltro");
        if (formulario.style.display === "none") {
            formulario.style.display = "block";
            botaoAdicionar.style.display = "none";
        } else {
            formulario.style.display = "none";
            botaoAdicionar.style.display = "block";
        }
    }
    
    </script>
</body>
</html>
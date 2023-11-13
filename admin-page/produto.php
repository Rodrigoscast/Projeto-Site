<?php
ini_set('default_charset', 'UTF-8');
include "topo.html";
include "executa_arquivos/guardiao.php";
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
    <div class="separador">
        <div class="ignora_menu"></div>
        <div class="div-central">
            <div class="search-container">
                <div class="topo_produtos">
                    <div></div>
                    <div>
                        <h1>Busca de Produtos</h1>
                    </div>
                    <div><button class="botao"><a href="adiciona_produto.php">Adicionar Produto</a></button></div>
                </div>
                <div class="filters">
                    <form action="produto.php" method="POST">
                        
                        <div class="adiciona_item">
                            <h2>Selecione o filtro:</h2>
                            <select name="etiqueta">
                                <option value="Todos" selected>Todos</option>

                                <?php 

                                include "conexao.php";

                                $query = "SELECT * FROM filtros order by nome_filtro";
                                $executa = mysqli_query($db, $query);
                                
                                while($busca = mysqli_fetch_assoc($executa)){

                                    $id = $busca['id_filtro'];
                                    $nome = $busca['nome_filtro'];

                                ?>

                                    <option value="<?= $id ?>"><?= $nome ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <input class="botao" value="Consultar" type="submit">
                        </div>
                    </form>
                </div>
            </div>
            <?php if(isset($_POST['etiqueta'])){  ?>
                <div id="resultados">
                    <h2>Resultados da Pesquisa</h2>
                    <div class="iframe-container">
                        <?php 
                        $key = $_POST['etiqueta']; 
                        if ($key != "Todos") {
                            $query = "SELECT * FROM produtos
                                    LEFT JOIN filtros ON produtos.etiqueta = filtros.id_filtro
                                    WHERE etiqueta = $key ORDER BY titulo";
                        } else {
                            $query = "SELECT * FROM produtos LEFT JOIN filtros ON produtos.etiqueta = filtros.id_filtro ORDER BY titulo ";
                        }

                        // echo $query;

                        $executa_query = mysqli_query($db, $query);
                        $result = mysqli_num_rows($executa_query);
                        if($result > 0) { ?>
                            <table class="tabela-produtos">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Valor</th>
                                        <th>Etiqueta</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $executa_query2 = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($executa_query2)) {
                                        $id = htmlspecialchars($row["idproduto"]);
                                        $produto = htmlspecialchars($row['titulo']);
                                        $valor = htmlspecialchars($row['valor']);
                                        $descricao = htmlspecialchars($row['descricao']);
                                        $etiqueta = htmlspecialchars($row['nome_filtro']);

                                        $valor = 'R$ ' . number_format($valor, 2, ',', '.');
                                        
                                        ?>
                                        <tr>
                                            <td><?= $produto ?></td>
                                            <td><?= $valor ?></td>
                                            <td><?= $etiqueta ?></td>
                                            <td>
                                                <button class='editar-button'><a href="./edita_produto.php?id=<?= $id ?>">Editar</a></button>
                                                <button class='adicionar-imagens'><a href="./adicionar_imagens.php?id=<?= $id ?>">Adicionar Imagens</a></button>
                                                <button class='excluir'><a href="./executa_arquivos/exclui_produto.php?id=<?= $id ?>">Excluir</a></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <h3>Nenhum resultado encontrado!</h3>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
<?php
session_start();
ini_set('default_charset', 'UTF-8');
include "../admin-page/conexao.php";

$carrinho = $_SESSION["carrinho"];

// print_r($carrinho);

$total = 0;

if(isset($_GET['remove_id'])){
    $remove_id = $_GET['remove_id'];
    if(in_array($remove_id, $carrinho)){
        foreach($carrinho as $key => $value){
            if($value == $remove_id){
                unset($_SESSION["carrinho"][$key]);
            }
        }
    }
    ?>
        <script type="text/javascript">
            window.location.href = "carrinho.php";
        </script>
    <?php
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="carrinho.css">
    <script>
        function atualizarTotal(idProduto, valorUnitario) {
            var quantidadeInput = document.getElementById('quantidade_' + idProduto);
            var totalCell = document.getElementById('total_' + idProduto);
            var inputHidden = document.getElementById('valor_' + idProduto);
            var totalValor = document.getElementById('total');

            var quantidade = parseInt(quantidadeInput.value);
            var novoTotal = quantidade * valorUnitario;
            totalCell.textContent = 'R$ ' + novoTotal.toFixed(2).replace('.', ',');
            inputHidden.value = quantidade;

            var totalGeral = 0
            <?php 
            foreach ($carrinho as $key => $value) {
                ?>
                var elemento = document.getElementById('total_<?= $value ?>');
                elemento = parseFloat(elemento.textContent.replace('R$ ', '').replace(',', '.'));
                totalGeral = totalGeral + elemento
                <?php
            }            
            ?>
            var totalX = parseFloat(totalGeral); // Obtém o valor do elemento DOM
            totalValor.textContent = 'R$ ' + (totalX).toFixed(2).replace('.', ','); // Atualiza o elemento DOM
        }
        function formatarTelefone(input) {
            // Remove todos os caracteres não numéricos do valor atual
            var unformattedValue = input.value.replace(/\D/g, '');

            // Verifique se o valor tem 11 dígitos (incluindo o DDD)
            if (unformattedValue.length === 11) {
                // Formate o número como (DD) DDDDD-DDDD
                var formattedValue = `(${unformattedValue.slice(0, 2)}) ${unformattedValue.slice(2, 7)}-${unformattedValue.slice(7)}`;
                input.value = formattedValue;
            } else {
                // Se o valor não tem 11 dígitos, exiba-o como está
                input.value = unformattedValue;
            }
        }
    </script>
</head>
<body>
    <header>
        <div id="header-primary">
            <h1 id="header-h1" onclick="location.href='index.php'">Baldochi <p>acessórios</p></h1>
        </div>
    </header>
    <h1 class="titulo-car">Carrinho de Compras</h1>
    <main>
        <table>
            <tr class="titulos-th">
                <td>Produto</td>
                <td>Preço</td>
                <td>Quantidade</td>
                <td>Total</td>
            </tr>
            <?php
                foreach ($carrinho as $key => $value) {
                    $query = "SELECT * FROM produtos WHERE idproduto = $value";
                    $executa_query = mysqli_query($db, $query);
                    while( $row = mysqli_fetch_assoc($executa_query) ){
                        $nome = $row['titulo'];
                        $valor = $row['valor'];
                        $total = $total + $valor;
                        $valorAtt = 'R$ ' . number_format($valor, 2, ',', '.');
                ?>
                    <tr class="titulos">
                        <td><?= $nome ?></td>
                        <td><?= $valor ?></td>
                        <td><input type="number" value="1" id="quantidade_<?= $value ?>" onchange="atualizarTotal(<?= $value ?>, <?= $valor ?>)"></td>
                        <td class="total-table"><p id="total_<?= $value ?>"><?= $valorAtt ?></p><button onclick="location.href=`?remove_id=${<?= $value ?>}`">x</button></td>
                    </tr>
                <?php } } ?>
        </table>
        <div class="total">
            Total: <span id="total"><?php $total = 'R$ ' . number_format($total, 2, ',', '.'); echo $total; ?></span>
        </div>
        <h1 class="continua-buy"><a href="index.php">Continuar Comprando!</a></h1>
        <button class="checkout-button" onclick="abre_formulario()">Finalizar Compra</button>
        <div id="modal-back">
            <div id="modal-cadastro">
                <h1 class="titulo-bar">Formulário de Pedido</h1>
                <form action="processar_pedido.php" method="POST">
                    <?php
                        foreach ($carrinho as $key => $value) {
                            ?>
                            <input type="hidden" name="valor_<?= $value ?>" id="valor_<?= $value ?>" value="1">
                            <?php
                        }
                    ?>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="endereco">Endereço Completo:</label>
                    <textarea id="endereco" name="endereco" rows="1" required></textarea>
                    <label for="whatsapp">Número de WhatsApp (com DDD):</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="Exemplo: (11) 98765-4321" oninput="formatarTelefone(this)" required>
                    <small>Informe o número de WhatsApp no formato: (DDD) DDDDD-DDDD.</small>
                    <label for="forma_pagamento">Forma de Pagamento:</label>
                    <select id="forma_pagamento" name="forma_pagamento">
                        <option value="credito">Cartão de Crédito</option>
                        <option value="debito">Cartão de Débito</option>
                        <option value="boleto">Pix</option>
                        <option value="transferencia">Transferência Bancária</option>
                        <option value="dinheiro">Dinheiro</option>
                    </select>
                    <input type="submit" value="Enviar Pedido">
                </form>
            </div>
        </div>
    </main>
    <script>
        function abre_formulario(){
            var modal = document.getElementById('modal-cadastro');
            var modalback = document.getElementById('modal-back');
            modal.style.display = 'block';
            modalback.style.display = 'block';
        }
    </script>
</body>
</html>


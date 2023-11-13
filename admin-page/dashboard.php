<?php
ini_set('default_charset', 'UTF-8');
include "executa_arquivos/guardiao.php";
include "topo.html";
include "conexao.php";

$productTypeData = [];

$query = "SELECT COUNT(*) as contador FROM produtos";
$executa = mysqli_query($db, $query);
$result = mysqli_fetch_assoc($executa);

$totalProducts = $result['contador'];

$query = "SELECT * FROM filtros";
$executa = mysqli_query($db, $query);
while($result = mysqli_fetch_assoc($executa)){

    $id_filtro = $result['id_filtro'];
    $nome_filtro = $result['nome_filtro'];

    $query2 = "SELECT COUNT(*) as contador2 FROM produtos WHERE etiqueta = $id_filtro";
    $executa2 = mysqli_query($db, $query2);
    $result2 = mysqli_fetch_assoc($executa2);

    $contagem = $result2['contador2'];

    if($contagem > 0){
        $trash = ["label" => $nome_filtro, "value" => $contagem];
        array_push($productTypeData, $trash);
    }

}

$topProductsData = [];

$query3 = "SELECT * FROM produtos";
$executa3 = mysqli_query($db, $query3);
while($result3 = mysqli_fetch_assoc($executa3)){

    $titulo = $result3['titulo'];
    $vendidos = $result3['vendidos'];

    if($vendidos > 0){
        $trash = ["label" => $titulo, "value" => $vendidos];
        array_push($topProductsData, $trash);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style_page.css">
    <link rel="stylesheet" href="topo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .card {
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 18px;
            margin: 0;
        }

        p {
            font-size: 36px;
            font-weight: bold;
        }

    </style>
</head>
<body>


    <div class="back">
        <div class="ignora_menu"></div>
        <div class="container">
            <div class="card">
                <h2>Produtos Cadastrados</h2>
                <p id="total-products"><?= $totalProducts ?></p>
            </div>
            <div class="card">
                <h2>Tipo de Produtos Cadastrados</h2>
                <canvas id="product-type-chart" width="200" height="200"></canvas>
            </div>
            <div class="card">
                <h2>Produtos Mais Vendidos</h2>
                <canvas id="top-products-chart" width="200" height="200"></canvas>
            </div>
        </div>
    </div>
    <script>

        // Obtenha os elementos do DOM
        const totalProductsElement = document.getElementById("total-products");
        const productTypeChart = document.getElementById("product-type-chart").getContext("2d");
        const topProductsChart = document.getElementById("top-products-chart").getContext("2d");

        // Crie o gráfico de pizza para o tipo de produtos
        const productTypeData = <?php echo json_encode($productTypeData); ?>;
        new Chart(productTypeChart, {
            type: "pie",
            data: {
                labels: productTypeData.map(item => item.label),
                datasets: [{
                    data: productTypeData.map(item => item.value),
                    backgroundColor: ["#FF5733", "#33FF57", "#5733FF", "#FF336D", "#33A3FF"],
                }],
            },
        });

        // Crie o gráfico de pizza para os produtos mais vendidos
        const topProductsData = <?php echo json_encode($topProductsData); ?>;
        new Chart(topProductsChart, {
            type: "pie",
            data: {
                labels: topProductsData.map(item => item.label),
                datasets: [{
                    data: topProductsData.map(item => item.value),
                    backgroundColor: ["#FF5733", "#33FF57", "#5733FF", "#FF336D", "#33A3FF"],
                }],
            },
        });

    </script>
</body>
</html>

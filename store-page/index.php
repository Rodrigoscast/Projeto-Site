<?php
ini_set('default_charset', 'UTF-8');
include "../admin-page/conexao.php";
session_start();

if(!isset($_SESSION["carrinho"])){
  $_SESSION["carrinho"] = [];
}

$produtos = $_SESSION["carrinho"];

$produtosJson = json_encode($produtos);

$query_fundo = "SELECT * FROM destaques WHERE principal = 1";
$executa_fundo = mysqli_query($db, $query_fundo);
$result = mysqli_fetch_assoc($executa_fundo);

$url = $result['url_img'];

$imagens = [];

array_push($imagens, $url);

$x = 0;

$query = "SELECT * FROM destaques WHERE principal = 0";
$executa = mysqli_query($db, $query);
while( $row = mysqli_fetch_assoc($executa)) {
  $url_img = $row["url_img"];

  array_push($imagens, $url_img);
} 

if(isset($_GET['id'])){
  $id = $_GET['id'];
  if(!in_array($id, $produtos)){
    array_push($_SESSION["carrinho"], $id);
  }
  ?>
    <script type="text/javascript">
      window.location.href = "index.php#<?= $id ?>";
    </script>
  <?php
}

if(isset($_GET['remove_id'])){
  $remove_id = $_GET['remove_id'];
  if(in_array($remove_id, $produtos)){
    foreach($produtos as $key => $value){
      if($value == $remove_id){
        unset($_SESSION["carrinho"][$key]);
      }
    }
  }
  ?>
    <script type="text/javascript">
      window.location.href = "index.php#<?= $remove_id ?>";
    </script>
  <?php
}

$contador = 0;

foreach($produtos as $key => $value){
  $contador++;  
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Baldochi</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script type="text/javascript">

    function produtoJaNoCarrinho(id) {
      var produtosJson = <?php echo $produtosJson; ?>;
      resposta = false
      for(i = 0; i < produtosJson.length; i++){
        if(produtosJson[i] == id){
          resposta = true
        }
      }
      return resposta
    }

    var fotosAtt = [];
    var id_atual = null;
    var x = 0;

    function pega_lista(data){
      fotosAtt = data;
      if(fotosAtt.length == 1){
        let botoes = document.getElementById('passa_imagem');
        botoes.style.display = 'none';
      } else {
        let botoes = document.getElementById('passa_imagem');
        botoes.style.display = 'flex';
        x = 0
      }
    }

    // Função para abrir a modal com os detalhes do produto
    function openProductModal(id, url, titulo, valor, descricao) {
      const modal = document.querySelector('.product-modal');
      const imgElement = modal.querySelector('img');
      const nomeElement = modal.querySelector('h1');
      const descricaoElement = modal.querySelector('.descricao-p');
      const valorElement = modal.querySelector('.price');
      const idproduto = modal.querySelector('.idproduto');
      const button = document.getElementById('buy-button');
      const buttonFrase = document.getElementById('text-buy');

      if (produtoJaNoCarrinho(id)) {
        buttonFrase.textContent = 'Remover';
        button.classList.remove('buy-button');
        button.classList.add('produto-adicionado');
        button.href = `?remove_id=${id}`;
      } else {
        buttonFrase.textContent = 'Adicionar';
        button.classList.remove('produto-adicionado');
        button.classList.add('buy-button');
        button.href = `?id=${id}`;
      }

      imgElement.src = '../admin-page/fotos/' + id + '/' + url;
      nomeElement.textContent = titulo;
      descricaoElement.textContent = descricao;
      valorElement.textContent = valor;
      idproduto.textContent = id;
      id_atual = id;

      modal.style.display = 'block';

      $.ajax({
        type: 'POST',
        url: 'busca_imagens.php',
        data: {'id_atual': id},
        success: function(data){
          pega_lista(data);
        },
        error: function(error){
          console.error("Erro na solicitação AJAX: " + error);
        }
      });

    }

    

    // Adicione eventos de clique aos produtos clicáveis
    function clica_produto(id){
      const produto = document.getElementById(id);

      const url = produto.querySelector('img').getAttribute('src').split('/').pop();
      const titulo = produto.querySelector('.titulo').textContent;
      const valor = produto.querySelector('.valor').textContent;
      const descricao = produto.querySelector('.descricao').textContent;

      openProductModal(id, url, titulo, valor, descricao);
    }

    // Função para fechar a modal
    function closeProductModal() {
      const modal = document.querySelector('.product-modal');
      modal.style.display = 'none';
    }


  </script>
</head>

<body>
  <header id="header">
    <div id="header-primary">
      <div id="box-search">
        <!-- <div class="search-box">
          <input type="text" class="search-text" placeholder="Pesquisar">
          <a href="#" class="search-bottom">
            <img src="svg/search-svgrepo-com.svg" alt="Lupa" height="20" width="20" id="image-bottom">
          </a>
        </div> -->
      </div>
      <h1 id="header-h1">Baldochi <p>acessórios</p></h1>
      <div class="div-carrinho"><button id="cart-button" onclick="location.href='carrinho.php'"><ion-icon name="cart-outline"></ion-icon><span id="numero-car"><?= $contador ?></span></button></div>
    </div>
    <nav id="nav-header">

      <?php
      $query = "SELECT * FROM filtros";
      $executa_query = mysqli_query($db, $query);
  
        while ($row = mysqli_fetch_assoc($executa_query)) {
          $nome = $row["nome_filtro"];
          $id = $row['id_filtro'];

          $tamanho = mysqli_num_rows(mysqli_query($db, "SELECT * FROM produtos WHERE etiqueta = $id"));

          if ($tamanho > 0) {
            echo "<a href='#$nome'>$nome</a>";
          }
        }
      ?>
    </nav>
  </header>
  <main>
    <div class="carousel-container">
      <?php 
      $alt = 1;
      foreach($imagens as $img){ ?>
        <div class="carousel-slide">
          <img src="../admin-page/fotos/destaques/<?= $img ?>" alt="Imagem <?= $alt ?>">
        </div>
        <?php 
        $alt++;
      } 
     ?>
     <div class="botoes">
        <ion-icon id="prevButton" name="chevron-back-outline"></ion-icon>
        <ion-icon id="nextButton" name="chevron-forward-outline"></ion-icon>
      </div>
    </div>
    
    

    <section id="store">
      <?php
      $query = "SELECT * FROM filtros";
      $executa_query = mysqli_query($db, $query);
      $tamanho = mysqli_num_rows($executa_query);
      while ($row = mysqli_fetch_assoc($executa_query)) {
        $nome = $row["nome_filtro"];
        $id = $row["id_filtro"];

        $tamanho = mysqli_num_rows(mysqli_query($db, "SELECT * FROM produtos WHERE etiqueta = $id"));

        if ($tamanho > 0) {
          echo "<h1 id='$nome'>$nome</h1>";
          ?>
          <div class="products">

            <?php

            $executa = mysqli_query($db,"SELECT * FROM produtos WHERE etiqueta = $id"); 
            while($results = mysqli_fetch_array($executa)) { 

              $id = $results["idproduto"];
              $url = $results["url_main"];
              $titulo = $results["titulo"];
              $valor = $results['valor'];
              $descricao = $results['descricao'];

              $valor = 'R$ ' . number_format($valor, 2, ',', '.');

              echo "<div style='height: 40vh;'>";
                echo "<div id='$id' class='product-1' onclick='clica_produto($id)'>";
                  echo "<div class='div-produto'><img src='../admin-page/fotos/$id/$url' alt='' class='photo'></div>";
                  echo "<div class='product-description'>";
                    echo "<p class='titulo'>$titulo</p>";
                    echo "<p class='valor'>$valor</p>";
                    echo "<p class='descricao' style='display: none;'>$descricao</p>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            }
          echo "</div>";
        }
      }
      ?>

    </section>
    <div class="product-modal">
      <div id="div_fecha">
        <button onclick="closeProductModal()" class="botao_fecha">x</button>
      </div>
      <div class="fotos-container">
        <div class="fotos-slide">
          <img src="#" alt="Hollow">
        </div>
        <div class="passa_imagem" id="passa_imagem">
          <ion-icon id="prev" name="chevron-back-outline"></ion-icon>
          <ion-icon id="next" name="chevron-forward-outline"></ion-icon>
        </div>
      </div>
      <h1 class="titulo2"></h1>
      <p class="idproduto" style="display: none;"></p>
      <h3 id="descricao-button">Descrição</h3>
      <div id="descricao-popup" class="hidden">
        <p class="descricao-p">Esta é a descrição do Produto</p>
      </div>
      <p class="price"></p>
      <button style="background-color: #fff;"><a href="#" id="buy-button" class="buy-button"><ion-icon name="cart-outline" class="tira-fundo"></ion-icon><span class="tira-fundo" id="text-buy">Adicionar</span></a></button>
    </div>
  </main>
  <script type="text/javascript"> 
    //Lógica para alterar os slides principais da página
    let slideIndex = 0;
    const slides = document.querySelectorAll('.carousel-slide');

    function showSlide(n) {
      if (n < 0) {
        slideIndex = slides.length - 1;
      } else if (n >= slides.length) {
        slideIndex = 0;
      }

      for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
      }
      slides[slideIndex].style.display = 'block';
    }

    function nextSlide() {
      slideIndex++;
      showSlide(slideIndex);
    }

    function prevSlide() {
      slideIndex--;
      showSlide(slideIndex);
    }

    showSlide(slideIndex);

    // Adicione eventos de clique para os botões "Próximo" e "Anterior"
    document.getElementById('nextButton').addEventListener('click', nextSlide);
    document.getElementById('prevButton').addEventListener('click', prevSlide);

    //Passar imagem dos produtos
    var modal = document.querySelector('.product-modal');
    var imgElement = modal.querySelector('img');

    function showFoto(){
      let url = fotosAtt[x];
      imgElement.src = '../admin-page/fotos/' + id_atual + '/' + url;
    }

    function next(){
      if(x >= fotosAtt.length-1){
        x = 0
      } else {
        x++
      }
      showFoto()
    }

    function prev(){
      if(x <= 0){
        x = fotosAtt.length-1
      } else {
        x--
      }
      showFoto()
    }

    document.getElementById('next').addEventListener('click', next);
    document.getElementById('prev').addEventListener('click', prev);

  </script>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
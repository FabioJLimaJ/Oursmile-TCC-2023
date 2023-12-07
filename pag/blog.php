<?php
  session_start();
  if(isset($_SESSION['nivel'])){
    $nivel = $_SESSION['nivel'];
  }else{
    $nivel = '1';
  }
  include_once('../php/conecta.php');
  //////////// PAGINAÇÃO ///////////

  // captura os valores da url
  $capture_get = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_URL);

  //variaveis de tratamento
  $pg = ($capture_get == '' ? 1 : $capture_get);

  // limite de exibição por página
  $limit = 9;
  $start = ($pg * $limit) - $limit;
  
  // CONSULTA TABELA USUÁRIO
  $usuario = $conn->prepare("SELECT id, nm_nome FROM tb_usuario");
  $usuario->execute();
  $exibir_user = $usuario->fetch(PDO::FETCH_ASSOC);

  // CONSULTAR CATEGORIAS DO BLOG
  $categoria = "SELECT id, nm_categoria FROM tb_categoria";
  $exibir_categoria = $conn->prepare($categoria);
  $exibir_categoria->execute();

  // CASO EXISTA ARTIGO
  if(isset($_GET['artigo'])){
  $id_categoria = $_GET['artigo'];
  $stmt_exibir = $conn->prepare("SELECT * FROM tb_blog WHERE id_categoria = '$id_categoria' ORDER BY data_criacao DESC LIMIT $start, $limit");
  $stmt_exibir->execute();
  $lines = $stmt_exibir->rowCount();
  $post = "Categoria: ";
  }
  //CASO EXISTA PESQUISA
  elseif (!empty($_GET['busca'])) {
  $nome = "%" . $_GET['busca'] . "%";
  $pesquisa = "SELECT * FROM tb_blog WHERE nm_postagem LIKE :nome ORDER BY nm_postagem DESC LIMIT $start, $limit";
  $stmt_exibir = $conn->prepare($pesquisa);
  $stmt_exibir->bindParam(':nome', $nome, PDO::PARAM_STR);
  $stmt_exibir->execute();
  $post = "Resultados para: ".$_GET['busca'];
  $lines = $stmt_exibir->rowCount();
  }else{
  // CONSULTAR POSTAGENS NO BLOG
  $stmt_exibir = $conn->prepare("SELECT * FROM tb_blog ORDER BY data_criacao DESC LIMIT $start, $limit");
  $stmt_exibir->execute();
  $lines = $stmt_exibir->rowCount();
  $post = "Publicações recentes";
  }
  ?>

  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">

    <link rel="stylesheet" href="../css/blog.css">
    <script src="https://kit.fontawesome.com/eac31603cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,200&display=swap" rel="stylesheet">
    <!-- font pesquisar -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- font icon -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <title>Blog Oursmile</title>
    <style>
      /* Font */
@import url('https://fonts.googleapis.com/css?family=Quicksand:400,700');




.main{
  max-width: 1200px;
  margin: 0 auto;
}

h1 {
    font-size: 24px;
    font-weight: 400;
    text-align: center;
}

img {
  height: auto;
  max-width: 100%;
  vertical-align: middle;
}



.cards {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  margin: 0;
  padding: 0;
}

.cards_item {
  display: flex;
  padding: 1rem;
}

@media (min-width: 40rem) {
  .cards_item {
    width: 50%;
  }
}

@media (min-width: 56rem) {
  .cards_item {
    width: 33.3333%;
  }
}

.card {
  background-color: white;
  border-radius: 0.25rem;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.card_content {
  padding: 1rem;

}

.card_title {

  font-size: 1.1rem;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: capitalize;
  margin: 0px;
}

.card_text {

  font-size: 0.875rem;
  line-height: 1.5;
  margin-bottom: 1.25rem;    
  font-weight: 400;
}
.made_by{
  font-weight: 400;
  font-size: 13px;
  margin-top: 35px;
  text-align: center;
}
.buttonA{
  display: inline-block;
  border-radius: 4px;
  background-color:#22B900;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 14px;
  padding: 16px;
  width: 140px;
  transition: all 0.3s;
  cursor: pointer;

 }
 .buttonA:hover{
    background-color:#1C9601;
 }
 .buttonF{

  border-radius: 4px;
  background-color:#22B900;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 14px;
  padding: 10px;
  width: 140px;
  transition: all 0.3s;
  cursor: pointer;

 }
    </style>
  </head>
  <body style="background-color:#F3F5F6;">
    <!-- NAV DO SITE -->
    <?php
include("navbarsS.php");
?>

<br><br><br><br>
<nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#3DB0F6;">
  <div class="container-fluid">


  <?php
    if($nivel > '1'){
    ?>
    <!-- BOTÕES ADM -->
    <div class="button-nav">
      <!-- BOTÃO PARA ABRIR MODAL-->
      <div class="button-adm">


       

        <button id="myBtnPub" class="buttonA">

Adicionar publicação
</button>
      </div>
    </div>
    <?php
    }
    ?>&nbsp;


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
      <li class="nav-item">
        
      <div class="dropdown">
  <button type="button" class="buttonF dropdown-toggle" data-bs-toggle="dropdown">
   Categoria
  </button>
  <ul class="dropdown-menu">   
  <li><a class="dropdown-item" href="blog.php">Publicações recentes</a></li>
      <?php
      while($categoria = $exibir_categoria->fetch(PDO::FETCH_ASSOC)){
  ?>  

    <li><a class="dropdown-item" href="#" onclick="location.href='blog.php?artigo=<?php echo $categoria['id'];?>'"><?php echo $categoria['nm_categoria'];?></a></li>

  <?php
      }    
  ?>
      </ul>
    </div>
    </ul>
    

    <form class="example" action="">
    <div class="input-group mb-3">
  <input type="text" name="busca" id="busca" class="form-control" placeholder="Pesquisar publicações" aria-label="Recipient's username" aria-describedby="basic-addon2">
  <div class="input-group-append">
    <button class="input-group-text" id="basic-addon2" type="submit" onclick="searchData()"><span class="material-symbols-outlined">
search
</span></button>
  </div>
</div>

    </form>
 
    </div>
  </div>
</nav>


    <!-- EXIBIR BUSCA NA URL -->
    <script>
      var search = document.getElementById('busca');

      function searchData() {
        window.location = 'blog.php?search=' + search.value;
      }
    </script>

    <!-- MODAL ADICIONAR, JQUERY E AJAX -->

    <?php
    include_once('../modal/adicionarPub.php');
    ?>
    
    <div class="main">

  <ul class="cards">

<!-- SECTION BLOG -->
   
      <?php
        $lines = $stmt_exibir->rowCount();
        if($lines > 0){
        while($row_pesquisa = $stmt_exibir->fetch(PDO::FETCH_ASSOC)){
        extract($row_pesquisa);
      ?>

    <li class="cards_item">
      <div class="card">
        <div class="card_image" ><img src="<?php echo $ds_img ?>"style="height:15rem; width:25rem;"></div>
        <div class="card_content">
          <h2 class="card_title"><?php echo $nm_postagem ?></h2>


         
<br><br>
          <center><button class="buttonPerfil" onclick="window.location.href='view.php?id=<?php echo $row_pesquisa['id_post']; ?>'">Saiba mais</button></center>
          <br>
         <p class="nDentista"><img src="../img/dentechave.png" alt="" style="width:2rem;margin-top:1rem;"> <nobr style="position:relative; top:0.5rem;"><?php echo $row_pesquisa['nm_autor']?></nobr>
         <nobr class="date" style="position:relative; top:0.6rem;"><?php date_default_timezone_set('America/Sao_Paulo');echo date(' d / m / y ', strtotime($dt_data)); ?></nobr>
        </p>
         <?php
     $publicacao_id = $row_pesquisa['id_post'];
     // Verifique se a publicação já está nos favoritos do usuário
     $favoritada = false;
     $query = "SELECT * FROM tb_favorito WHERE user_id = :usuario_id AND pub_id = :publicacao_id";
     $stmt2 = $conn->prepare($query);
     $stmt2->bindParam(':usuario_id', $_SESSION['id_user']);
     $stmt2->bindParam(':publicacao_id', $publicacao_id);
     $stmt2->execute();
     if ($stmt2->rowCount() > 0) {
       $favoritada = true;
     }
     ?>
                  <?php
                  if(isset($_SESSION['id_user'])){
                  // Exiba o botão de favoritar
                  $botao = '<label class="containerS" style="display:flex; justify-content:start;">
                  <input type="checkbox">
                  <svg class="save-regular" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"></path></svg>
                  <svg class="save-solid" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"></path></svg>
                 </label>';
                 
                 $botaoAtivo = '<label class="containerS" style="display:flex; justify-content:start;">
                 <input type="checkbox" checked>
                 <svg class="save-regular" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"></path></svg>
                 <svg class="save-solid" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"></path></svg>
                 </label>';
                  if ($favoritada){
              
                    // <!-- Exiba o botão de desfavoritar -->
                     
                      echo "<button style='display:flex; justify-content:end;float:right;'class='button-fav' method = 'Unlike' data-post ='$publicacao_id' type='submit'> $botaoAtivo</button>";
                  } else {
          
      echo  "<button style='display:flex; justify-content:end;float:right;' class='button-fav' method = 'Like' data-post ='$publicacao_id'>$botao</button>";

      }}
     ?>
    
      
       <?php

if($_SESSION['nivel'] == 2){
?>
<button class="edits"  onclick="window.location.href='edit.php?id=<?php echo $id_post?>'">
<b class="material-symbols-outlined">
edit
    </b>
</button>

<button class="edits" onclick="window.location.href='../php/excluirPub.php?id=<?php echo $id_post?>'">
<b class="material-symbols-outlined">
delete

    </b>
</button>
<?php
}else{
?>

<?php
}?>
        </div>
        
      </div>
    </li>
   

    


  <!-- FECHAR WHILE EXIBIÇÃO -->
      <?php
    }    
     }else{
     echo "Sem resultados!";
    }
        ?>

</ul>
</div>
<br>
<!-- PAGINAÇÃO DAS PUBLICAÇÕES -->
<?php
// Função para gerar o link de paginação
function generatePageLink($page) {
    $baseURL = 'blog.php';
    $params = array();

    if (isset($_GET['artigo'])) {
        $params['artigo'] = $_GET['artigo'];
    } elseif (!empty($_GET['busca'])) {
        $params['busca'] = $_GET['busca'];
    }

    $params['pg'] = $page;
    $queryString = http_build_query($params);

    return $baseURL . '?' . $queryString;
}

echo "<div class='center'>";
echo "<ul id='paginacao'>";

// Consulta para contar o número total de resultados de acordo com o filtro
$stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM tb_blog");

if (isset($_GET['artigo'])) {
    // Adicione aqui a lógica para contar os resultados com base no filtro de artigo
    $stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM tb_blog WHERE id_categoria = :id_categoria");
    $stmt_total->bindParam(':id_categoria', $_GET['artigo'], PDO::PARAM_INT);
} elseif (!empty($_GET['busca'])) {
    // Adicione aqui a lógica para contar os resultados com base no filtro de busca
    $stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM tb_blog WHERE nm_postagem LIKE :busca");
    $stmt_total->bindParam(':busca',$nome, PDO::PARAM_STR);
}

$stmt_total->execute();
$total_results = $stmt_total->fetchColumn();
$total_pages = ceil($total_results / $limit);

$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;

if ($pg < 1) {
    $pg = 1;
} elseif ($pg > $total_pages) {
    $pg = $total_pages;
}

if ($total_results > 0) {
    // Verifica a navegação da página anterior
    $previousPage = $pg - 1;

    if ($previousPage >= 1) {
        echo "<li class='paginacao'><a href='" . generatePageLink($previousPage) . "'>&laquo</a></li>";
    }

    // Gere os links para as páginas
    for ($i = max(1, $pg - 5); $i <= min($total_pages, $pg + 5); $i++) {
        // Página atual estará colorida
      if ($i >= 1) {
        if ($pg == $i) {
          $active = "style='box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;'";
          }else{
            $active = "";
          }
        }
        echo "<li class='paginacao' {$active}><a href='" . generatePageLink($i) . "'>$i</a></li>";
    }

    // Verifica a navegação da próxima página
    $nextPage = $pg + 1;

    if ($nextPage <= $total_pages) {
        echo "<li class='paginacao'><a href='" . generatePageLink($nextPage) . "'>&raquo</a></li>";
    }
} 
echo "</ul></div>";
?>

<?php include("footer.html");?>

<!-- SCRIPT PARA ENVIAR FAVORITO-->
<script>
    $(document).ready(function ($) {
        $(".button-fav").click(function (e) {
            e.preventDefault();
            const director_id = $(this).attr('data-post'); // Get the parameter director_id from the button
            const method = $(this).attr('method'); // Get the parameter method from the button
            if (method === "Like") {
                $(this).attr('method', 'Unlike'); // Change the div method attribute to Unlike
                
                $(this).html('<label class="containerS" style="display:flex; justify-content:end;"><input type="checkbox" checked " id="'+director_id+'"><svg class="save-regular" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"></path></svg><svg class="save-solid" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"></path></svg></label>').toggleClass('button mybtn'); // Replace the image with the liked button
            
              }else{
                $(this).attr('method', 'Like');
                $(this).html('<label class="containerS" style="display:flex; justify-content:end;"><input type="checkbox" id="'+director_id+'"><svg class="save-regular" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"></path></svg><svg class="save-solid" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"></path></svg></label>').toggleClass('mybtn button');
            }
            $.ajax({
                url: '../php/favPost.php', // Call favs.php to update the database
                type: 'GET',
                data: {director_id: director_id, method: method},
                cache: false,
                success: function (data) {
                }
            });
        });
    });

    var modalPub = document.getElementById("myModalPub");

// var botão
var btnPub = document.getElementById("myBtnPub");

var salvar = document.getElementById("salvarPub");

// <span> para fechar modal
var spanPub = document.getElementsByClassName("closePub")[0];

// button cancelar
var btnClosePub = document.getElementsByClassName("close-btnPub")[0];

// ação clique no botão para abrir modal
btnPub.onclick = function() {
  modalPub.style.display = "block";
}

// x para fechar modal
spanPub.onclick = function() {
  modal.style.display = "none";
}

// botão cancelar
btnClosePub.onclick = function() {
  modalPub.style.display = "none";
}
</script>

</body>
</html>
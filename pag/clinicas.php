 <?php
session_start();
    include('../php/conecta.php');
    if (!isset($_SESSION['id_user'])) {
    header('location: ../index.php');
    }else{
    $usuario = $_SESSION['id_user'];
    $nivel = $_SESSION['nivel'];
    $user_id = $conn->prepare("SELECT * FROM tb_usuario WHERE id = '$usuario'");
    $user_id-> execute();
    $user_id = $user_id->fetch();
    $nome = $user_id['nm_nome'];
   
    
    //////////// PAGINAÇÃO ///////////

  // captura os valores da url
  $capture_get = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_URL);

    //variaveis de tratamento
   $pg = ($capture_get == '' ? 1 : $capture_get);

    // limite de exibição por página
    $limit = 10;
    $start = ($pg * $limit) - $limit;
    
    //CASO EXISTA PESQUISA
    if (!empty($_GET['busca'])) {
    $nome = "%" . $_GET['busca'] . "%";
    $pesquisa = "SELECT * FROM tb_clinica WHERE nm_clinica LIKE :nome ORDER BY nm_clinica DESC LIMIT $start, $limit";
    $stmt_exibir = $conn->prepare($pesquisa);
    $stmt_exibir->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt_exibir->execute();
    $post = "Resultados para: ".$_GET['busca'];
    $lines = $stmt_exibir->rowCount();
    }elseif(isset($_GET['filtro_tratamento'])){
    $filtro = $_GET['filtro_tratamento'];
    $query =  "SELECT * FROM tb_clinica JOIN tb_tratamentos ON tb_clinica.id = tb_tratamentos.id_clinica WHERE nm_tratamento = :nome_tratamento";
    $stmt_exibir = $conn->prepare($query);
    $stmt_exibir->bindParam(':nome_tratamento', $filtro);
    $stmt_exibir->execute();
    $lines = $stmt_exibir->rowCount();
    }else{
    // CONSULTAR POSTAGENS NO BLOG
    $stmt_exibir = $conn->prepare("SELECT * FROM tb_clinica ORDER BY data_criacao DESC LIMIT $start, $limit");
    $stmt_exibir->execute();
    $lines = $stmt_exibir->rowCount();
    $post = "Publicações recentes";
    }

    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/sobre-nosso-site.css">
    <link rel="stylesheet" href="../css/clinica.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&family=Roboto:ital,wght@0,400;1,900&family=Signika&family=Ubuntu&display=swap" rel="stylesheet">

    <title>Clínicas</title>
    <style>
      


*{
  padding: 0;
  margin: 0;
  text-decoration: none;
  list-style: none;
}

.group {
  display: flex;
  line-height: 28px;
  align-items: center;
  position: relative;
  max-width: 190px;
}

.input{
  height: 40px;
  line-height: 28px;
  padding: 0 1rem;
  width: 100%;

  border: 2px solid transparent;
  border-radius: 8px;
  outline: none;
  background-color:;
  color: #0d0c22;
  box-shadow: 0 0 5px  #276bff;
  transition: .3s ease;
}
.paginacao {
    display: inline-block;

}

.paginacao a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin-top: 0.5px;
    background-color:#ffff;
} 

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 20rem; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  position:relative;
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.bS {
width:6rem;
padding:0.5rem;
  border: 0;
  border-radius: 100px;
  background-color: #2ba8fb;
  color: #ffffff;
  font-weight: Bold;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  cursor:pointer;
}

.bS:hover {
  background-color: #6fc5ff;
  box-shadow: 0 0 20px #6fc5ff50;
  transform: scale(1.1);
}

.bS:active {
  background-color: #3d94cf;
  transition: all 0.25s;
  -webkit-transition: all 0.25s;
  box-shadow: none;
  transform: scale(0.98);
}
    </style>
</head>
<script src="../js/modais.js"></script>
<script src="../js/jquery-3.6.4.js"></script>
<script>
       var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<body style="background-color:#F3F5F6;">

<?php include("navbarsS.php");?>
   
<br><br>
<br>
        <!-- EXIBIR BUSCA NA URL -->
    <script>
      var search = document.getElementById('busca');

      function searchData() {
        window.location = 'clinicas.php?search=' + search.value;
      }
    </script>
<br><br>
 
   <!-- FILTROS -->

   <!-- FILTRO DOS TRATAMENTOS -->
   &nbsp;
 



   

 <div style="display:inline-block">
 <form action="">
 <input type="text" name="busca" id="busca" placeholder="Pesquisar" autocomplete="off" onkeyup="pesquisar()" class="input" style="width:20rem">

  </form>


  <form action="" method="GET">
    &nbsp;
<select name="filtro_tratamento" id="filtro_tratamento" style="width:15rem">
  <option disabled selected>Filtrar por tratamento</option>

  <option value="Ortodontia">Ortodontia (aparelho)</option>
  <option value="Implantes">Implantes </option>
  <option value="Próteses">Próteses </option>
  <option value="Endodontia (canal)">Endodontia (canal) </option>
  <option value="Implantodontia">Implantodontia </option>
  <option value="Odontopediatria">Odontopediatria </option>
  <option value="Periodontia">Periodontia </option>




</select>

<button type="submit" class="buttono">Filtrar</button>
   </form>


    </div>


   <div id="myModal" class="modal">
<!-- Modal content -->
<div class="modal-content">
  <span class="close">&times;</span>
  <h6 style="font-size:1.5rem;">Deseja sair </h6><br>
  <button onclick="location.href='../php/sair.php'" class="bS">Sair</button>
</div>
</div>


<script src="../js/modalSenha.js"></script>



<div class="wrapper">


  <div class="team">
<!-- EXIBIR CLINICAS -->
<?php
    if($lines > 0){
    while($row = $stmt_exibir->fetch(PDO::FETCH_ASSOC)){
    extract($row);
?>




    <div class="team_member">
   <!-- <b class="dot"></b> -->
   <p class="subTitulos"><img src="../img/dentechave.png" alt="" style="width:2rem;">&nbsp;
   <?php echo $nm_dentista;?></p><br>
   <hr class="border-light m-0"><br>
   <img src="<?php echo $ds_img?>" alt="Imagem relacionada a clínica" style="width:10rem; height:10rem">
<br><br>
     <p class="titulos"><?php echo $nm_clinica;?></p> 

      
      <p class="subTitulos"><?php echo $nm_endereco;?></p>
<br>
   

<hr class="border-light m-0"><br>
   
    <button onclick="window.location.href='pagClinica.php?id=<?php echo $row['id']?>'" class="buttonPerfil">
  <span>Saiba mais</span>
</button>

 <?php
 $botao = '<label class="containerS" style="display:flex; justify-content:end;">
 <input type="checkbox">
 <svg class="save-regular" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"></path></svg>
 <svg class="save-solid" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"></path></svg>
</label>';

$botaoAtivo = '<label class="containerS" style="display:flex; justify-content:end;">
<input type="checkbox" checked>
<svg class="save-regular" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"></path></svg>
<svg class="save-solid" xmlns="http://www.w3.org/2000/svg" height="1rem" viewBox="0 0 384 512"><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"></path></svg>
</label>';

     $clinica_id = $id;
     // Verifique se a publicação já está nos favoritos do usuário
     $favoritada = false;
     $query = "SELECT * FROM tb_favorito WHERE user_id = :usuario_id AND clinica_id = :clinica_id";
     $stmt2 = $conn->prepare($query);
     $stmt2->bindParam(':usuario_id', $_SESSION['id_user']);
     $stmt2->bindParam(':clinica_id', $clinica_id);
     $stmt2->execute();
     if ($stmt2->rowCount() > 0) {
       $favoritada = true;
     }

    if(isset($_SESSION['id_user'])){
      // Exiba o botão de favoritar
        if ($favoritada){
                    // <!-- Exiba o botão de desfavoritar -->
                      echo "<button class='button-fav' method = 'Unlike' data-post ='$clinica_id' type='submit' style='display:flex; justify-content:end; margin-left:0.5rem;'>
                      
              $botaoAtivo

                      </button>";
                  } else {
          
                    echo  "<button class='button-fav' method = 'Like' data-post ='$clinica_id' style='display:flex; justify-content:end; margin-left:0.5rem;'>
                    
                    $botao


                    </button>";

                  }}
                  ?>


<br>
<?php

if($_SESSION['nivel'] == 2){
?>
<button class="edits"  onclick="window.location.href='editClinica.php?id=<?php echo $row['id'];?>'">
<b class="material-symbols-outlined">
edit
    </b>
</button>

<button class="edits" onclick="window.location.href='../php/excluirClinica.php?id=<?php echo $row['id']; ?>'">
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
    
  <?php 
  }}else{
    echo "Sem resultados!";
  }
  
  ?>

    </div>
 </div>
  
</div>


<!-- PAGINAÇÃO DAS PUBLICAÇÕES -->
<center>
<?php
// Função para gerar o link de paginação
function generatePageLink($page) {
    $baseURL = 'clinicas.php';
    $params = array();

    if (!empty($_GET['busca'])) {
      $params['busca'] = $_GET['busca'];
    }elseif(isset($_GET['filtro_tratamento'])){
      $params['filtro_tratamento'] = $_GET['filtro_tratamento'];
    }

    $params['pg'] = $page;
    $queryString = http_build_query($params);

    return $baseURL . '?' . $queryString;
}

echo "<div class='center'>";
echo "<ul id='paginacao'>";

// Consulta para contar o número total de resultados de acordo com o filtro
$stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM tb_clinica");
if (!empty($_GET['busca'])) {
  // Adicione aqui a lógica para contar os resultados com base no filtro de busca
  $stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM tb_clinica WHERE nm_clinica LIKE :busca");
  $stmt_total->bindParam(':busca',$nome, PDO::PARAM_STR);
}elseif(isset($_GET['filtro_tratamento'])){
  $stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM tb_clinica JOIN tb_tratamentos ON tb_clinica.id = tb_tratamentos.id_clinica WHERE nm_tratamento = :nome_tratamento");
  $stmt_total->bindParam(':nome_tratamento', $_GET['filtro_tratamento'], PDO::PARAM_INT);
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
          $active = "style='background-color: white; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; margin:auto;'";
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
</center><br>
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
                  url: '../php/favPostClinica.php', // Call favs.php to update the database
                  type: 'GET',
                  data: {director_id: director_id, method: method},
                  cache: false,
                  success: function (data){
                  }
              });
          });
      });
  </script>
  
  <footer id="newsletter">
    <div class="container">
      <div class="row">
       
        <div class="col-lg-6 offset-lg-3" style="opacity:0">
          <form id="search" action="#" method="GET">
            <div class="row">
              <div class="col-lg-6 col-sm-6">
                <fieldset>
                  <input type="address" name="address" class="email" placeholder="Email Address..." autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-6 col-sm-6">
                <fieldset>
                  <button type="submit" class="main-button">Subscribe Now <i class="fa fa-angle-right"></i></button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>Contact Us</h4>
            <p>Rio de Janeiro - RJ, 22795-008, Brazil</p>
            <p><a href="#">010-020-0340</a></p>
            <p><a href="#">info@company.co</a></p>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>About Us</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Testimonials</a></li>
              <li><a href="#">Pricing</a></li>
            </ul>
            <ul>
              <li><a href="#">About</a></li>
              <li><a href="#">Testimonials</a></li>
              <li><a href="#">Pricing</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="#">Free Apps</a></li>
              <li><a href="#">App Engine</a></li>
              <li><a href="#">Programming</a></li>
              <li><a href="#">Development</a></li>
              <li><a href="#">App News</a></li>
            </ul>
            <ul>
              <li><a href="#">App Dev Team</a></li>
              <li><a href="#">Digital Web</a></li>
              <li><a href="#">Normal Apps</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>SocialVision</h4>
            <div class="logo">
           <img src="../img/logoBrancoEquipe.png">
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
          </div>
        </div>
      
      </div>
    </div>

</footer>

</body>
</html>
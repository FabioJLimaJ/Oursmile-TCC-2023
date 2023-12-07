<?php
session_start();
    include('../php/conecta.php');
    if (!isset($_SESSION['id_user'])) {
    header('location: ../index.php');
    }else{
    $usuario = $_SESSION['id_user'];

    //////////// PAGINAÇÃO ///////////

     // captura os valores da url
    $capture_get = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_URL);

    //variaveis de tratamento
   $pg = ($capture_get == '' ? 1 : $capture_get);

    // limite de exibição por página
    $limit = 10;
    $start = ($pg * $limit) - $limit;
    $nivel = '3';
    
    //CASO EXISTA PESQUISA
    if (!empty($_GET['busca'])) {
    $nome = "%" . $_GET['busca'] . "%";
    $usuario = "SELECT * FROM tb_usuario WHERE id_nivel = :nivel AND nm_nome LIKE :nome ORDER BY nm_nome DESC LIMIT $start, $limit";
    $stmt_exibir = $conn->prepare($usuario);
    $stmt_exibir->bindParam(':nivel', $nivel, PDO::PARAM_STR);
    $stmt_exibir->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt_exibir->execute();
    $post = "Resultados para: ".$_GET['busca'];
    $lines = $stmt_exibir->rowCount();
    }else{
    // CONSULTAR POSTAGENS NO BLOG
    $stmt_exibir = $conn->prepare("SELECT * FROM tb_usuario WHERE id_nivel = :nivel ORDER BY nm_nome DESC LIMIT $start, $limit");
    $stmt_exibir->bindParam(':nivel', $nivel, PDO::PARAM_STR);
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
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/sobre-nosso-site.css">
    <link rel="stylesheet" href="../css/clinica.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Clínicas</title>
    <style>
#map{
  height: 25rem;
  max-width:40rem;
  border-color:#279989;
  border-style:solid;
  border-radius:1rem;

}
#horaEntrada,#horaSaida::placeholder {
    font: 0.9rem arial;
}
#horaEntrada,#horaSaida{
   width:7rem;
   height:2.2rem;
}


    </style>
</head>
<script src="../js/modais.js"></script>
<script src="../js/jquery-3.6.4.js"></script>

<body>
<nav class="nav">
	<img class="nav__collapser" src="https://raw.githubusercontent.com/JamminCoder/grid_navbar/master/menu.svg" alt="Collapse">
	<img src="../img/logo.png" alt="" id="logotipo">

	<!-- Put your collapsing content in here -->
	<div class="nav__collapsable">
		<a href="#">Home</a>
		<a href="#">Blog</a>
		<a href="#">Clínicas</a>

    <?php

if($_SESSION['nivel'] == 2){
?>
<button onclick="window.location.href='addClinica.php'">Adicionar +</button>
<?php
}else{
?>

<?php
}?>

		<div class="nav__cta">

		</div>
	</div>

</nav>
    <!-- nav do site -->
<br>
<br>
    <script>
        const toggleMenuOpen = () => document.body.classList.toggle("open");
    </script>
    <nav class="navbar" style="display:none;">
      <div class="navbar-overlay" onclick="toggleMenuOpen()"></div>

      <button type="button" class="navbar-burger" onclick="toggleMenuOpen()">
        <span class="material-icons">menu</span>
      </button>
      <img src="../img/logotipo.png" alt="" id="logo">
      <nav class="navbar-menu">

        <button type="button">Home</button>
        <button type="button">Blog</button>
        <div class="dropdown">
            
            <span>Configurações▼</span>
            <div class="dropdown-content">
            <?php 
                   if (!isset($_SESSION['email'])) {
                      ?>
                      <a href="pag/cadastrar.php">Logar</a>
                      <?php 
                  }else{?>
                  <a href="#login"><?php echo $nome;?></a><br><br>
                  <?php
                      }
                      ?>
               <a href="#contact" id="myBtn">Sair</a>
            </div>
          </div> 
        <button type="button" class="active">Clínicas</button>
       
     
      </nav>
    </nav>

        <!-- EXIBIR BUSCA NA URL -->
    <script>
      var search = document.getElementById('busca');

      function searchData() {
        window.location = 'clinicas.php?search=' + search.value;
      }
    </script>

    <div class="input-group">
   
    <form action="">
  <div class="container-input">
  <input type="text" name="busca" id="busca" placeholder="Pesquisar" autocomplete="off" onkeyup="pesquisar()" class="input">
  <svg type="submit" class="invite-btn" onclick="searchData()" fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
    <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
    </svg>
</div>
</div>
   </form>


</div>
    
<style>
  /* Google Fonts Import Link */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

.nav-links{
  display: flex;
  align-items: center;
  background: #fff;
  padding: 20px 15px;
  border-radius: 12px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.2);
}
.nav-links li{
  list-style: none;
  margin: 0 12px;
}
.nav-links li a{
  position: relative;
  color: #333;
  font-size: 20px;
  font-weight: 500;
  padding: 6px 0;
  text-decoration: none;
}
.nav-links li a:before{
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  height: 3px;
  width: 0%;
  background: #34efdf;
  border-radius: 12px;
  transition: all 0.4s ease;
}
.nav-links li a:hover:before{
  width: 100%;
}
.nav-links li.center a:before{
  left: 50%;
  transform: translateX(-50%);
}
.nav-links li.upward a:before{
  width: 100%;
  bottom: -5px;
  opacity: 0;
}
.nav-links li.upward a:hover:before{
  bottom: 0px;
  opacity: 1;
}
.nav-links li.forward a:before{
  width: 100%;
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.4s ease;
}
.nav-links li.forward a:hover:before{
  transform: scaleX(1);
  transform-origin: left;
}
</style>

<ul class="nav-links">
    <li><a href="clinicas.php">Clínicas</a></li>
    <li class="center"><a href="profissionais.php">Profissionais</a></li>
  </ul>


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
   <img src="<?php echo $ds_foto?>" alt="Imagem relacionada a clínica" width="100%">
<br>
     <p class="titulos"><?php echo $nm_nome;?></p><br>
      
      
      <p class="subTitulos"><?php echo $nm_sobrenome;?></p>
<br>
   


   
    <button onclick="window.location.href='pagClinica.php?id=<?php echo $row['id']?>'" class="buttonClinica">
  <span>Saiba mais</span>
</button>

 <br><br>
 
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
          $active = "style='background-color: #14c4f4;'";
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

</body>
</html>
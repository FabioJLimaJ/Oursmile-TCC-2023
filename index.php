
<?php
session_start();
    include('php/conecta.php');
    if (!isset($_SESSION['id_user'])) {
    $nivel = '1';
    }else{
    $usuario = $_SESSION['id_user'];
    $nivel = $_SESSION['nivel'];
    $stmt = $conn->prepare("SELECT * FROM tb_usuario WHERE id = '$usuario'");
    $stmt-> execute();
    $stmt = $stmt->fetch();
    $nome = $nivel;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

  <head>

    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <title>Oursmile</title>

    <!-- Bootstrap core CSS -->
    <link href="index/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!--

TemplateMo 570 Chain App Dev

https://templatemo.com/tm-570-chain-app-dev

-->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="index/assets/css/templatemo-chain-app-dev.css">
    <link rel="stylesheet" href="index/assets/css/animated.css">
    <link rel="stylesheet" href="index/assets/css/owl.css">


    <style>
      /* The Modal (background) */
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

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="" class="logo">
              <img src="img/logoHorizontal.png" style="width:14rem;" id="logo">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">

              <li class="scroll-to-section"><a href="pag/blog.php">Blog</a></li>
              <?php
              if (!isset($_SESSION['id_user'])) {
?>
              <li class="scroll-to-section"><a href="pag/cadastrar.php">Clínicas</a></li>
              <?php
}else{
?>
    <li class="scroll-to-section"><a href="pag/clinicas.php">Clínicas</a></li>
<?php
}
?>  
              <?php
if (!isset($_SESSION['id_user'])) {
?>


<?php
}else{
?>
    <li class="scroll-to-section"><a href="ProfileTemplate/index.php">Perfil</a></li>
<?php
}
?>  


<?php
if($nivel == 2){
?>
<li class="scroll-to-section"><a href="pag/listar_usuarioAdm.php">Gerenciar</a></li>
<?php
}else{
  ?>
  
  <?php
  }?>
                <?php
if (!isset($_SESSION['id_user'])) {
?>
    <li class="scroll-to-section"><a href="pag/cadastrar-se.php">Entrar</a></li>

<?php
}else{
?>

    <li class="scroll-to-section"><a id="myBtn">Sair</a></li>
<?php
}
?>
<li class="scroll-to-section" style="display:none;"><a href=""></a></li>
            </ul>        
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
  
  <div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close">&times;</span>
  <h6>Deseja sair </h6><br>
  <button onclick="location.href='php/sair.php'" class="bS">Sair</button>
</div>

</div>

  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                  <div class="col-lg-10">
                    <h2>Produzir um sorriso <br> é multiplicar a  felicidade</h2>
                  
                  </div>
                  <div class="col-lg-12">
                    <div class="white-button first-button scroll-to-section">
                      <a href="#pricing">Saiba mais</a>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                <img src="img/13053.jpg" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<br>


  <div id="pricing" class="pricing-tables">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
        </div>
        <div class="col-lg-4">
          <div class="pricing-item-regular">
            
            <h4>Tudo sobre doenças bucais</h4>
            <div class="icon">
              <img src="img/dente-de-ouro.png" alt="">
            </div>
            <ul>
              <li>Saiba os perigos das doenças bucais</li>


            </ul>
            <div class="border-button">
              <a href="pag/blog.php">Saiba mais</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="pricing-item-pro">
            
            <h4>Encontre clínicas</h4>
            <div class="icon">
              <img src="img/dd.png" alt="">
            </div>
            <ul>
              <li>Encontre clínicas e suas localizações</li>


            </ul>
            <div class="border-button">

            <?php
if (!isset($_SESSION['id_user'])) {
?>
    <a href="pag/cadastrar-se.php">Saiba mais</a>

<?php
}else{
?>
    <a href="pag/clinicas.php">Saiba mais</a>
<?php
}
?>

            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="pricing-item-regular">
            
            <h4>Quem somos</h4>
            <div class="icon">
              <img src="img/3d.png" alt="">
            </div>
            <ul>
<li>Saiba sobre a equipe que fez o site</li>              
            </ul>
            <div class="border-button">
              <a href="sobreNós/index.html">Saiba mais</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 

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
            <h4>Nosso contato</h4>
            <p>São Paulo - Brazil</p>
            <p><a href="#">010-020-0340</a></p>
            <p><a href="#">oursmile.com</a></p>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>Sobre nós</h4>
            <ul>
              <li><a href="http://localhost:8080/Oursmile-TCC/sobreN%C3%B3s/index.html">Missão</a></li>
              <li><a href="http://localhost:8080/Oursmile-TCC/sobreN%C3%B3s/index.html">Valores</a></li>
              <li><a href="http://localhost:8080/Oursmile-TCC/sobreN%C3%B3s/index.html">Objetivo</a></li>
            </ul>
          
          </div>
        </div>
        <div class="col-lg-3">
          <div class="footer-widget">
            <h4>Outros links</h4>
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
           <img src="img/logoBrancoEquipe.png">
            </div>
            <p>Visando atender sempre a uma causa pertinente de maneira eficiente, inovadora e transparente.</p>
          </div>
        </div>
      
      </div>
    </div>

</footer>


  <!-- Scripts -->
  <script src="index/vendor/jquery/jquery.min.js"></script>
  <script src="index/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="index/assets/js/owl-carousel.js"></script>
  <script src="index/assets/js/animation.js"></script>
  <script src="index/assets/js/imagesloaded.js"></script>
  <script src="index/assets/js/popup.js"></script>
  <script src="index/assets/js/custom.js"></script>

  <script>

    const target = document.querySelector("#logo");
    function animeScroll(){
const windowTop = window.pageYOffset;


    if((windowTop) > 145){
target.src = "img/logo.png";
target.style.width = "5rem";
    }else{
        target.src = "img/logoHorizontal.png";
        target.style.width = "14rem";
    }
    }
    window.addEventListener('scroll', function(){
        animeScroll();
    });


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
</body>
</html>
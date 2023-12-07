<?php

session_start();

require "../php/conecta.php";
    $id_clinica = $_GET['id'];

    include('../php/conecta.php');
    if (!isset($_SESSION['id_user'])) {
    header('location: ../index.php');
    }else{
    // CONSULTA TABELA CLINICA
    $exibir_clinica = $conn->prepare("SELECT * FROM tb_clinica WHERE id = '$id_clinica'");
    $exibir_clinica->execute();
    $exibir = $exibir_clinica->fetch(PDO::FETCH_ASSOC);
    extract($exibir);

    //CONSULTA TABELA USUÁRIO
    // $exibir_user = $conn->prepare("SELECT id, nm_nome, nm_local FROM tb_usuario WHERE id = :user");
    // $exibir_user->bindParam(':user', $usuario);
    // $exibir_user->execute();
    // $user = $exibir_user->fetch(PDO::FETCH_ASSOC);
    // $nm_nome = $user['nm_nome'];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/clinica.css">
    <link rel="stylesheet" href="../css/modal-senha.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- ICONE ESTRELA -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Clínica - <?php echo $nm_clinica?></title>
    <style>
      
#map {
  height: 30rem;
  width: 36rem;
margin:auto;
}
.loader, .loader:before, .loader:after {
  border-radius: 50%;
  width: 2.5em;
  height: 2.5em;
  animation-fill-mode: both;
  animation: bblFadInOut 1.8s infinite ease-in-out;
  color:#3cb0fd;
display: flex;


}
.loader {
  color:#3cb0fd;
  font-size: 7px;
  position: relative;
  text-indent: -9999em;
  transform: translateZ(0);
  animation-delay: -0.16s;
  top:35vh;

}
.loader:before,
.loader:after {
  content: '';
  position: absolute;
  top: 0;
}
.loader:before {
  left: -3.5em;
  animation-delay: -0.32s;
}
.loader:after {
  left: 3.5em;
}

@keyframes bblFadInOut {
  0%, 80%, 100% { box-shadow: 0 2.5em 0 -1.3em }
  40% { box-shadow: 0 2.5em 0 0 }
}
.material-symbols-outlined{
  user-select:none;
}

    </style>
</head>
<body>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly&language=pt&region=br" defer></script>
    <!-- nav do site -->
<?php include("navbarsS.php");?>
 <br><br><br><br>

 
  <input type="hidden" value="<?php echo $stmt['id']?>" id="id">
  <input type="hidden" id="valor-two" onkeyup="initMap()" value="<?php echo $nm_endereco;?>">
  <input type="hidden" id="valor" onkeyup="initMap()"  value="<?php echo $stmt['nm_local']?>">

 

<style>
 body{
  background-color: rgba(0, 140, 255, 0.145);
 }
 /* ===== Scrollbar CSS ===== */
  /* Firefox */
  .info {
    scrollbar-width: auto;
    scrollbar-color:#3DB0F6 #ffffff;
  }

  /* Chrome, Edge, and Safari */
  .info::-webkit-scrollbar {
    width: 16px;
  }

  .info::-webkit-scrollbar-track {
    background: #ffffff;
  }

  .info::-webkit-scrollbar-thumb {
    background-color:#3DB0F6;
    border-radius: 10px;
    border: 3px solid #ffffff;
  }
  .input {
  
  max-width: 220px;
  height: 45px;
  padding: 12px;
  border-radius: 12px;
  border: 1.5px solid lightgrey;
  outline: none;
  transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
  box-shadow: 0px 0px 20px -18px;
}

.input:hover {
  border: 2px solid lightgrey;
  box-shadow: 0px 0px 20px -17px;
}

.input:active {
  transform: scale(0.95);
}

.input:focus {
  border: 2px solid grey;
}
.rating-container {
    text-align: center;
}

.stars {
    font-size: 30px;
    cursor: pointer;
}

.stars .star {
    color: #ccc;
    display: inline-block;
    margin-right: 5px;
}

.stars .star:hover,
.stars .star.active {
    color: #ffcc00;
}

      </style>
   
<style>
  /* Criar as variaveis com as cores */
:root {
    --amarelo: #ffcc00;
    --cinza: #cccccc;
}

/* Não exibir o input radio */
.estrelas input[type=radio] {
    display: none;
}

/* Criar as estrelas preenchidas de amarelo*/
.estrelas label i.opcao.fa:before {
    content: '\f005';
    color: var(--amarelo);
}

/* Atribuir o cinza nas estrelas, quando selecionar a estrela retirar o cinza*/
.estrelas input[type=radio]:checked~label i.fa:before {
    color: var(--cinza);
}

/* Personalizar a estrela preenchida */
.estrela-preenchida {
    color: var(--amarelo);
}

/* Personalizar a estrela vazia */
.estrela-vazia{
    color: var(--cinza);
} 
</style>
  

<!-- Trigger/Open The Modal -->
<?php

if($nivel > '1'){
?>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">adicionar Tratamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     
    <form action="../php/adicionarTratamento.php" method="POST" >
    <input type="hidden" name="id_clinic" value="<?php echo $id_clinica?>">
    <input type="text" name="nome_tratamento" placeholder="Nome do tratamento">
    <button type="submit" name="adicionar">Adicionar</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
    
      </div>
    </div>
  </div>
</div>
<?php
}
?>
<!-- The Modal -->
<div id="myModal2" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close2">&times;</span>
   
  </div>
</div>
</div>

  </div>
  <div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <p id="respo"></p>
  <span class="close">&times;</span>
  <p>Adicione um novo endereço</p><br>
  <input type="hidden" id="id" value="<?php echo $stmt['id']?>">
  <input placeholder="Adicione um endereço aqui" type="text"class="input" id="endereco" value="<?php echo $stmt['nm_local'];?>"> 
  <button class="edits" style="display:flex; float:right;" id="editos">
<b class="material-symbols-outlined">
edit
</b>
</button>
</div>
</div>

<br>





<div style="display:flex; justify-content:center;">
<div class="card">
<div class="info">
<p class="title"><h2><?php echo $nm_clinica;?></h2></p>
</div>
<div class="header">  <img src="<?php echo $ds_img?>" alt="Imagem relacionada a clínica" style="width:20rem; height:20rem;"></div>
<div class="info">
  <p class="title">Informações</p>

  <div class="infoN">
  <span class="product-catagory"><span class="material-symbols-outlined" style="position:relative; top:0.3rem;">call</span> Telefone:
        <?php echo $nr_telefone;?><br><br>
        
        <span class="material-symbols-outlined" style="position:relative; top:0.3rem;">mail</span> Gmail: 
        <?php echo $exibir['nm_email'];?></span>
</div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<div class="infoNN">
<span class="product-catagory">
<span class="material-symbols-outlined" style="position:relative; top:0.3rem;">schedule</span> Abertura:
				<?php echo $hr_abri;?><br><br>
        
        <span class="material-symbols-outlined" style="position:relative; top:0.3rem;">schedule</span> Fechamento:
        <?php echo $hr_fecha;?></span>
</div> 
<br><br><hr class="border-light m-0">


<!-- EXIBIR TRATAMENTOS DA CLÍNICAS -->
<p class="title">Tratamentos</p><br>
<?php 

$tratamento = $conn->prepare("SELECT * FROM tb_tratamentos WHERE id_clinica = :id");
$tratamento->bindParam(':id', $id_clinica);
$tratamento->execute();
$lines = $tratamento->rowCount();

while($exibir_tratamento = $tratamento->fetch(PDO::FETCH_ASSOC)){
  extract($exibir_tratamento);
?>

<?php echo $exibir_tratamento['nm_tratamento']."<br>";?>

<?php
}
?>


<div class="info">
<p class="title">Dentista</p>

<br>
<img src="../img/dentechave.png" alt="" style="width:2rem;">&nbsp;
   <?php echo $nm_dentista;?>
</div>  

</div>
<div id="map"><span class="loader"></span></div>
<div class="info">
<span class="product-catagory">
   <?php echo $nm_endereco;?>
</span>
</div>  
<div class="info">
<button class="edits" id="myBtn">
<b class="material-symbols-outlined">
edit_location_alt
</b>
</button>

</div>
<hr class="border-light m-0">

<div class="info" style="overflow-x:auto; height:20rem;">


<form method="POST" id="avaliar_clinica">

<div class="estrelas">
    <input type="hidden" name="autor" value="<?php echo $nm_nome?>">
    <input type="hidden" name="id_clinica" value="<?php echo $id_clinica?>">
    <!-- Carrega o formulário definindo nenhuma estrela selecionada -->
    <input type="radio" name="estrela" id="vazio" value="" checked>

    <!-- Opção para selecionar 1 estrela -->
    <label for="estrela_um"><i class="opcao fa"></i></label>
    <input type="radio" name="estrela" id="estrela_um" id="vazio" value="1">

    <!-- Opção para selecionar 2 estrela -->
    <label for="estrela_dois"><i class="opcao fa"></i></label>
    <input type="radio" name="estrela" id="estrela_dois" id="vazio" value="2">

    <!-- Opção para selecionar 3 estrela -->
    <label for="estrela_tres"><i class="opcao fa"></i></label>
    <input type="radio" name="estrela" id="estrela_tres" id="vazio" value="3">

    <!-- Opção para selecionar 4 estrela -->
    <label for="estrela_quatro"><i class="opcao fa"></i></label>
    <input type="radio" name="estrela" id="estrela_quatro" id="vazio" value="4">

    <!-- Opção para selecionar 5 estrela -->
    <label for="estrela_cinco"><i class="opcao fa"></i></label>
    <input type="radio" name="estrela" id="estrela_cinco" id="vazio" value="5"><br><br>

    <!-- Campo para enviar a mensagem -->
    <input name="mensagem" placeholder="Digite o seu comentário..." class="input"><br><br>

    <!-- Botão para enviar os dados do formulário -->
    <input type="submit" value="Avaliar" class="buttonPerfil"><br><br>

</div>

</form>

<p id="mensagem"></p>
<h4>Avaliações</h4>
<?php
    // Recuperar as avaliações do banco de dados
    $query_avaliacoes = "SELECT * FROM tb_avaliacao WHERE id_clinica = '$id_clinica' ORDER BY id DESC ";
  
    // Preparar a QUERY
    $result_avaliacoes = $conn->prepare($query_avaliacoes);

    // Executar a QUERY
    $result_avaliacoes->execute();
    $lines = $result_avaliacoes->rowCount();
    if($lines > 0){
    // Percorrer a lista de registros recuperada do banco de dados
    while ($row_avaliacao = $result_avaliacoes->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row_avaliacao);

        // Extrair o array para imprimir pelo nome do elemento do array
        extract($row_avaliacao);
      
        // Criar o for para percorrer as 5 estrelas
        for ($i = 1; $i <= 5; $i++) {

            // Acessa o IF quando a quantidade de estrelas selecionadas é menor a quantidade de estrela percorrida e imprime a estrela preenchida
            if ($i <= $vl_nota) {
                echo '<i class="estrela-preenchida fa-solid fa-star"></i>';
            } else {
                echo '<i class="estrela-vazia fa-solid fa-star"></i>';
            }
        }

        echo "<p>$nm_autor: $ds_mensagem</p><br>";
    }}else{
      echo "<p>Sem avaliações no momento</p>";
    }
    ?>
</div>  
<div class="footer">
  
  <p class="tag"><?php echo $nm_endereco;?></p>
  
  <?php

if($nivel > '1'){
?>
<!-- Button trigger modal -->
<button type="button" class="buttonPerfil"data-bs-toggle="modal" data-bs-target="#exampleModal" style="width:15rem">Adicionar tratamento</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">adicionar Tratamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     
    <form action="../php/adicionarTratamento.php" method="POST" >
    <input type="hidden" name="id_clinic" value="<?php echo $id_clinica?>">
    <input type="text" name="nome_tratamento" placeholder="Nome do tratamento">
    <button type="submit" name="adicionar">Adicionar</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
    
      </div>
    </div>
  </div>
</div>
<?php
}
?>



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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</footer>
<script src="../js/modalSenha.js"></script>
<!-- ajax para enviar dados para o php -->


<script>

  $(document).ready(function () {
    $('#avaliar_clinica').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);

      $.ajax({
        url: '../php/avaliarClinica.php', // Arquivo PHP para processar os dados
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response); // Exibe a resposta do servidor
          $('#mensagem').html(response); // exibe resposta no html
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
  
</script>

<script>
    $(document).ready(function(){

    $("#editos").click(function(){
      var id = $("#id").val();
      var endereco = $("#endereco").val();


  $.ajax({
    url: "../php/editarLoc.php",
    type: "POST",
    data: "id="+id+"&endereco="+endereco,
    dataType: "html"

}).done(function(resposta) {
   $("#respo").html(resposta);
   innerHTMl = '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
 

}).fail(function(jqXHR, textStatus ) {
    console.log("Request failed: " + textStatus);


}).always(function() {

});
});
});

var lat;
var lon;
function getLocation(){
  if(!navigator.geolocation)
    return null;
    navigator.geolocation.getCurrentPosition((pos)=>{
      lat = pos.coords.latitude;
      lon = pos.coords.longitude;
      initMap();
    });
  }


function initMap() {
  const uluru = {lat: lat, lng: lon};
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 16,
    center: uluru,
  });
  const directionsService = new google.maps.DirectionsService();
  const directionsRenderer = new google.maps.DirectionsRenderer({
    draggable: true,
    map,
    panel: document.getElementById("panel"),
  });


  directionsRenderer.addListener("directions_changed", () => {
    const directions = directionsRenderer.getDirections();

    if (directions) {
      computeTotalDistance(directions);
    }
  });
var jonas = document.getElementById("valor-two").value;
var bot = document.getElementById("valor").value;
  displayRoute(
    bot,
    jonas,
    directionsService,
    directionsRenderer
  );

  const maker = new google.maps.Marker({
    position: bot,
    map: map,
  });

  getLocation();
}



function displayRoute(origin, destination, service, display) {
  service
    .route({
      origin: origin,
      destination: destination,

      travelMode: google.maps.TravelMode.DRIVING,
      avoidTolls: true,
    })
    .then((result) => {
      display.setDirections(result);
    })
    .catch((e) => {

    });
}

function computeTotalDistance(result) {
  let total = 0;
  const myroute = result.routes[0];

  if (!myroute) {
    return;
  }

  for (let i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }

  total = total / 1000;
  document.getElementById("total").innerHTML = total + " km";
}

window.initMap = initMap;
  </script>
</body>
</html>
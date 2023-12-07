<?php
session_start();
    include('../php/conecta.php');
    if (!isset($_SESSION['id_user'])) {
    $nome = "Login";
    }else{
    $usuario = $_SESSION['id_user'];

    $stmt = $conn->prepare("SELECT * FROM tb_usuario WHERE id = '$usuario'");
    $stmt-> execute();
    $stmt = $stmt->fetch();
    $nome = $stmt['nm_nome'];
    }
    $id = $_GET['id'];
    $clini = $conn->prepare("SELECT * FROM tb_clinica WHERE id ='$id'");
    $clini->execute();
    $clini = $clini->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title><?php echo $clini['nm_clinica']?></title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cadastrar.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" type="image/x-icon" href="../img/logo.png">
	<script src="../js/jquery-3.6.4.js"></script>
      <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  outline: none;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

.containerS{
  max-width: 800px;
  background: #fff;
  width: 800px;
  padding: 25px 40px 10px 40px;
  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}
.containerS .text{
  text-align: center;
  font-size: 41px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  background:black;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.containerS #hellyel{
  padding: 30px 0 0 0;
}
.containerS #hellyel .form-row{
  display: flex;
  margin: 32px 0;
}
#hellyel .form-row .input-data{
  width: 100%;
  height: 40px;
  margin: 0 20px;
  position: relative;
}
#hellyel .form-row .textarea{
  height: 70px;
}
.input-data input,
.textarea textarea{
  display: block;
  width: 100%;
  height: 100%;
  border: none;
  font-size: 17px;
  border-bottom: 2px solid rgba(0,0,0, 0.12);
}
.input-data input:focus ~ label, .textarea textarea:focus ~ label,
.input-data input:valid ~ label, .textarea textarea:valid ~ label{
  transform: translateY(-20px);
  font-size: 14px;
  color: #3498db;
}
.textarea textarea{
  resize: none;
  padding-top: 10px;
}
.input-data label{
  position: absolute;
  pointer-events: none;
  bottom: 10px;
  font-size: 16px;
  transition: all 0.3s ease;
}
.textarea label{
  width: 100%;
  bottom: 40px;
  background: #fff;
}
.input-data .underline{
  position: absolute;
  bottom: 0;
  height: 2px;
  width: 100%;
}
.input-data .underline:before{
  position: absolute;
  content: "";
  height: 2px;
  width: 100%;
  background: #3498db;
  transform: scaleX(0);
  transform-origin: center;
  transition: transform 0.3s ease;
}
.input-data input:focus ~ .underline:before,
.input-data input:valid ~ .underline:before,
.textarea textarea:focus ~ .underline:before,
.textarea textarea:valid ~ .underline:before{
  transform: scale(1);
}
.submit-btn .input-data{
  overflow: hidden;
  height: 45px!important;
  width: 25%!important;
}
.submit-btn .input-data .inner{
  height: 100%;
  width: 300%;
  position: absolute;
  left: -100%;
  background: -webkit-linear-gradient(right, #56d8e4, #9f01ea, #56d8e4, #9f01ea);
  transition: all 0.4s;
}
.submit-btn .input-data:hover .inner{
  left: 0;
}
.submit-btn .input-data input{
  background: none;
  border: none;
  color: #fff;
  font-size: 17px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  position: relative;
  z-index: 2;
}
@media (max-width: 700px) {
  .containerS .text{
    font-size: 30px;
  }
  .containerS form{
    padding: 10px 0 0 0;
  }
  .containerS form .form-row{
    display: block;
  }
  form .form-row .input-data{
    margin: 35px 0!important;
  }
  .submit-btn .input-data{
    width: 40%!important;
  }
}

.danger{
    background-color:#ec0202;
    padding:1rem;
    color:#fff;
}
.success{
    background-color:#19d302;
    padding:1rem;
    color:#fff;
}
br{
  user-select:none;
}
/* Import Google Font - Poppins */


.content ul{
  display: flex;
  flex-wrap: wrap;
  padding: 7px;

  border-radius: 5px;
  border: 1px solid #a6a6a6;
}
.content ul  li{
  color: #333;
  margin: 4px 3px;
  list-style: none;

  background: #F2F2F2;
  padding:0.2rem;

}
.content ul li i{
  cursor: pointer;
}
.content ul input{
  border: none;
  outline: none;

}





      </style>
</head>
<body>
	<?php include("navbarsS.php");?>
	<br><br><br><br><br>  
	<main>
		

    <div class="containerS">
      <div class="text">
         Editar informações
      </div>
      <p id="respo"></p>
      <div id="hellyel">
        
         <div class="form-row">
            <div class="input-data">
               <input type="text" required  id="clinica" value="<?php echo $clini['nm_clinica'];?>">
               <div class="underline"></div>
               <label for="">Nome da clínica:</label>
               <input type="hidden"id="id" value="<?php echo $clini['id'];?> ">
            </div>
            <div class="input-data">
               <input type="numbero" required  id="cro" value="<?php echo $clini['nr_cro'];?>">
               <div class="underline"></div>
               <label for="">Cro:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="text" required id="nomeDentista" value="<?php echo $clini['nm_dentista'];?>">
               <div class="underline"></div>
               <label for="">Nome do(a) dentista:</label>
            </div>
            <div class="input-data">
               <input type="text" required id="telefone" value="<?php echo $clini['nr_telefone'];?>" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
               <div class="underline"></div>
               <label for="">Telefone:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="text" required id="endereco" value="<?php echo $clini['nm_endereco'];?>">
               <div class="underline"></div>
               <label for="">Endereço:</label>
            </div>
            <div class="input-data">
               <input type="text" required id="zap" value="<?php echo $clini['nr_zap'];?>" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
               <div class="underline"></div>
               <label for="">Whatsapp:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="time" required id="horaEntrada" value="<?php echo $clini['hr_abri'];?>">
               <div class="underline"></div>
               <label for="">Abertura:</label>
            </div>
            <div class="input-data">
               <input type="time" required id="horaSaida" value="<?php echo $clini['hr_fecha'];?>">
               <div class="underline"></div>
               <label for="">Fechamento:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="text" required id="email" value="<?php echo $clini['nm_email'];?>">
               <div class="underline"></div>
               <label for="">Email:</label>
            </div>
            <div class="input-data">
               <input type="text" required id="tratamentos"  value="<?php echo $clini['nm_tratamentos'];?>">
               <div class="underline"></div>
               <label for="">Tratamentos:</label>
    
            </div>
            
         </div>

         <div class="form-row">
         <div class="input-data textarea">
         <button type="button" id="cadastrar" onclick=" window.location.href = '../php/editarClinica.php?id=<?php echo $clini['id'];?>">Salvar alterações</button>

            
</div>
      </div>

	</main>
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
<script>
  $(document).ready(function(){
    $("#cadastrar").click(function(){
      var id = $("#id").val();
      var clinica = $("#clinica").val();
      var cro = $("#cro").val();
      var nomeDentista = $("#nomeDentista").val();
      var telefone = $("#telefone").val();
      var endereco = $("#endereco").val();
      var zap = $("#zap").val();
      var hrAbre = $("#horaEntrada").val();
      var hrFecha = $("#horaSaida").val();
      var email = $("#email").val();
      var trat = $("#tratamentos").val();

  $.ajax({
    url: "../php/editarClinica.php",
    type: "POST",
    data: "id="+id+"&clinica="+clinica+"&cro="+cro+"&nomeDentista="+nomeDentista+"&telefone="+telefone+"&endereco="+endereco+"&zap="+zap+"&horarioA="+hrAbre+"&horarioF="+hrFecha+"&email="+email+"&tratamentos="+trat,
    dataType: "html"

}).done(function(resposta) {
   $("#respo").html(resposta);

 

}).fail(function(jqXHR, textStatus ) {
    console.log("Request failed: " + textStatus);
    window.location.href = "addClinica.php";

}).always(function() {

});
});


});
function mask(o, f) {
  setTimeout(function() {
    var v = mphone(o.value);
    if (v != o.value) {
      o.value = v;
    }
  }, 1);
}

function mphone(v) {
  var r = v.replace(/\D/g, "");
  r = r.replace(/^0/, "");
  if (r.length > 10) {
    r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
  } else if (r.length > 5) {
    r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
  } else if (r.length > 2) {
    r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
  } else {
    r = r.replace(/^(\d*)/, "($1");
  }
  return r;
}
</script>

</body>
</html>

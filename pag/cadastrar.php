<?php
session_start();
if (isset($_SESSION['id_user'])) {
  header('location:../index.php');
}else{
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Cadastrar-se</title>

<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cadastrar.css">

	<link href="../index/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="../index/assets/css/templatemo-chain-app-dev.css">
    <link rel="stylesheet" href="../index/assets/css/animated.css">
    <link rel="stylesheet" href="../index/assets/css/owl.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="../js/jquery-3.6.4.js"></script>
	<script>


 $(document).ready(function(){
    $("#cadastrar").click(function(){
    	let botao = document.querySelector("#cadastrar");
		var aviso = document.querySelector("#aviso");
    	botao.innerHTML = ' <i class="fa fa-refresh fa-spin"></i>';
  $.ajax({
    url: "../php/cadastrar-dados.php",
    type: "POST",
    data: "nome="+$("#nome").val()+"&sobrenome="+$("#sobrenome").val()+"&email="+$("#email").val()+"&senha="+$("#senha").val()+"&nivel="+$("#nivel").val()+"&endereco="+$("#endereco").val(),
    dataType: "html"

}).done(function(resposta) {

   
   setTimeout(() => {
   aviso.innerHTML = resposta;
   botao.innerHTML = "Cadastrar";
}, "2000");


}).fail(function(jqXHR, textStatus ) {
    console.log("Request failed: " + textStatus);
      botao.innerHTML = "Erro de cadastro!";

}).always(function() {

});
});

});

function remove(){
		var buttonX = document.querySelector(".error__close");
		var aviso = document.querySelector(".error");
		aviso.style.display =  "none";
	}
    window.addEventListener('click', function(){
        remove();
    });

	function myFunction() {
		document.getElementById("myDropdown").classList.toggle("show");
	  }
	  
	  // Close the dropdown if the user clicks outside of it
	  window.onclick = function(event) {
		if (!event.target.matches('.dropbtn')) {
		  var dropdowns = document.getElementsByClassName("dropdown-content");
		  var i;
		  for (i = 0; i < dropdowns.length; i++) {
			var openDropdown = dropdowns[i];
			if (openDropdown.classList.contains('show')) {
			  openDropdown.classList.remove('show');
			}
		  }
		}
	  }


	  </script>
	  <style>
      body{
        background-color:#F3F5F6;
      }
		.error {
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  width: 320px;
  padding: 12px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: start;
  background: #EF665B;
  border-radius: 8px;
  box-shadow: 0px 0px 5px -3px #111;
}

.error__icon {
  width: 20px;
  height: 20px;
  transform: translateY(-2px);
  margin-right: 8px;
  display:block;
}

.error__icon path {
  fill: #fff;
}

.error__title {
  font-weight: 500;
  font-size: 14px;
  color: #fff;
}

.error__close {
  width: 20px;
  height: 20px;
  cursor: pointer;
  margin-left: auto;
}

.error__close path {
  fill: #fff;
}
	  </style>
</head>
<body>
	<?php include("navLogin.php");?><br><br><br><br><br><br><br><br><br>
	<main>
	<div class="containerForm">
		<div class="text">
<center>
			<a href="../index.php"><img src="../img/logoHorizontal.png" alt="logo" style="width:35rem;"></a></center>
		</div>

		<form>
			<p id="aviso"></p>
		   <div class="form-row">
			
			  <div class="input-data">
				 <input type="text" required id="nome">
				 <div class="underline"></div>
				 <label for="">Nome:</label>
			  </div>
			  <div class="input-data">
				 <input type="text" required id="sobrenome">
				 <div class="underline"></div>
				 <label for="">Sobrenome:</label>
			  </div>
		   </div>

		   <div class="form-row">
			  <div class="input-data">
				 <input type="text" required id="email">
				 <div class="underline"></div>
				 <label for="">Email:</label>
				 <a href="login.php" id="log" style="font-size:0.8rem; text-decoration:underline;">Ja tenho login</a>
			  </div>
			  
			  <div class="input-data">
				 <input type="password" required id="senha">

				 <div class="underline"></div>
				 <label for="">Senha:</label>
			  </div>
			  <div class="input-data">
				 <input type="text" required id="endereco">

				 <div class="underline"></div>
				 <label for="">Endereço:</label>
			  </div>
		   </div>
		   
			<input type="number" id="nivel" style="display:none;" value="1">
			
			  <div class="form-row submit-btn">
				 <div class="input-data">
					<div class="inner"></div>
					<button type="button" id="cadastrar">Cadastrar</button><br>
				 </div>
			  </div>
		</form>
		</div>

	</main>
	<br><br><br>		<br><br><br>	<br><br><br>
<?php include("footer.html");?>
</body>
</html>
<?php }?>
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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="../js/jquery-3.6.4.js"></script>

	<script>
 $(document).ready(function(){
    $("#cadastrar").click(function(){
    	let botao = document.querySelector("#cadastrar");
    	botao.innerHTML = ' <i class="fa fa-refresh fa-spin"></i>';
  $.ajax({
    url: "../php/cadastrar-dadosDentista.php",
    type: "POST",
    data: "nome="+$("#nome").val()+"&sobrenome="+$("#sobrenome").val()+"&email="+$("#email").val()+"&cpf_dentista="+$("#cpf_dentista").val()+"&senha="+$("#senha").val()+"&nivel="+$("#nivel").val()+"&cro_dentista="+$("#cro_dentista").val(),
    dataType: "html"

}).done(function(resposta) {
   window.location.href = "../index.php";
   
   setTimeout(() => {
   botao.innerHTML = "Cadastrado com sucesso!";
}, "2000");


}).fail(function(jqXHR, textStatus ) {
    console.log("Request failed: " + textStatus);
      botao.innerHTML = "Erro de cadastro!";

}).always(function() {

});
});

});

	


	  </script>
</head>
<body>
	<p id="resp"></p>
	<?php include("navLogin.php");?>
	<br><br><br><br><br><br><br>
	<section>
		
	<div class="containerForm">
		<div class="text">

			<a href="../index.php"><img src="../img/logoHorizontal.png" alt=""></a>
		</div>

		<form>
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
			  
			  <div class="input-data">
				 <input type="text" required id="email">
				 <div class="underline"></div>
				 <label for="">Email:</label>
			  </div>
		   </div>

		   <div class="form-row">
			  <div class="input-data">
				 <input type="number" id="cpf_dentista" maxlength="11" required>
				 <div class="underline"></div>
				 <label for="">CPF:</label>
				 <a href="login.php" id="log">Ja tenho login</a>
			  </div>
			  
			  <div class="input-data">
				 <input type="password" required id="senha">

				 <div class="underline"></div>
				 <label for="">Senha:</label>
			  </div>

			  <div class="input-data">
				 <input type="text" required id="cro_dentista">
				 <div class="underline"></div>
				 <label for="">CRO:</label>
			  </div>

		   </div>
		   
			<input type="number" id="nivel" style="display:none;" value="4">
			
			  <div class="form-row submit-btn">
				 <div class="input-data">
					<div class="inner"></div>
					<button type="button" id="cadastrar">Cadastrar</button><br>
				 </div>
			  </div>
		</form>
		</div>

	</section>


	<?php include("footer.html");?>
</body>
</html>
<?php }?>
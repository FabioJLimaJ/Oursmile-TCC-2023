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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Cadastrar clínica</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cadastrar.css">

  <link rel="icon" type="image/x-icon" href="../img/logo.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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


.danger{
    background-color:#ec0202;
    padding:1rem;
    color:#fff;
}
.error{
  
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  width: 320px;
  padding: 12px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: start;
  background: #47C300 ;
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

      </style>
</head>
<body>
	
	<?php include ("navbarsS.php");?><br><br><br><br><br><br>
	<section>
		

    <div class="containerForm">
      <div class="text">
         Adicione sua clínica
      </div>
      <p id="respo"></p>
      <form id="formulario" enctype="multipart/form-data">
      <input type="file" name="fotoClinica" id="fotoClinica">
      <p id="resposta"></p>
         <div class="form-row">

            <div class="input-data">
               <input type="text"  id="clinica" required name="clinica">
               <div class="underline"></div>
               <label for="">Nome da clínica:</label>
            </div>
            <div class="input-data">
               <input type="numbero" required  id="cro" name="cro">
               <div class="underline"></div>
               <label for="">Cro:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="text" required id="nomeDentista" name="nomeDentista">
               <div class="underline"></div>
               <label for="">Nome do(a) dentista:</label>
            </div>
            <div class="input-data">
            <input type="text" id="telefone" name="telefone" required onkeypress="mask(this, mphone);" onblur="mask(this, mphone);"/>
               <div class="underline"></div>
               <label for="">Telefone:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="text" required id="endereco" name="endereco">
               <div class="underline"></div>
               <label for="">Endereço:</label>
            </div>
            <div class="input-data">
               <input type="text" required id="zap" name="zap" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
               <div class="underline"></div>
               <label for="">Whatsapp:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="time" required id="horaEntrada" name="horaEntrada">
               <div class="underline"></div>
               <label for="">Abertura:</label>
            </div>
            <div class="input-data">
               <input type="time" required id="horaSaida" name="horaSaida">
               <div class="underline"></div>
               <label for="">Fechamento:</label>
            </div>
         </div>
         <div class="form-row">
            <div class="input-data">
               <input type="text" required id="email" name="email">
               <div class="underline"></div>
               <label for="">Email:</label>
            </div>
            <div class="input-data">
               <input type="text" required id="tratamentos" name="tratamentos">
               <div class="underline"></div>
               <label for="">Tratamentos:</label>
    
            </div>
            
         </div>

         <div class="form-row">
         <div class="input-data textarea">
         <button type="submit" id="cadastrar">Cadastrar</button>

            
      </form>
      
      </div>

	</section>
<?php include("footer.html");?>
<script>
// ajax para enviar dados para o php 

  $(document).ready(function () {
    $('#formulario').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);

      $.ajax({
        url: '../php/addClinicas.php', // Arquivo PHP para processar os dados
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response); // Exibe a resposta do servidor
          $('#resposta').html(response); // exibe resposta no html
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
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

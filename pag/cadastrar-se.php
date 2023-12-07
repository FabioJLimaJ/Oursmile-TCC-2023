<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
.card {
  max-width: 320px;
  border-width: 1px;
  border-color: rgba(219, 234, 254, 1);
  border-radius: 1rem;
  background-color: rgba(255, 255, 255, 1);
  padding: 2rem;
margin:auto;
box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}

.header {
  display: flex;
  align-items: center;
  grid-gap: 1rem;
  gap: 1rem;
}

.icon {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 9999px;
  background-color: rgba(96, 165, 250, 1);
  padding: 0.5rem;
  color: rgba(255, 255, 255, 1);
}

.icon svg {
  height: 1rem;
  width: 1rem;
}

.alert {
  font-weight: 600;
  color: rgba(107, 114, 128, 1);
}

.message {
  margin-top: 1rem;
  color: rgba(107, 114, 128, 1);
}

.actions {
  margin-top: 1.5rem;
}

.actions a {
  text-decoration: none;
}

.mark-as-read, .read {
  display: inline-block;
  border-radius: 0.5rem;
  width: 100%;
  padding: 0.75rem 1.25rem;
  text-align: center;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 600;
}

.read {
  background-color: rgba(59, 130, 246, 1);
  color: rgba(255, 255, 255, 1);
}

.mark-as-read {
  margin-top: 0.5rem;
  background-color: rgba(249, 250, 251, 1);
  color: rgba(107, 114, 128, 1);
  transition: all .15s ease;
}

.mark-as-read:hover {
  background-color: rgb(230, 231, 233);
}

 .buttonPerfil{

  border-radius: 4px;
  background-color:#3db0f6;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 14px;
  padding: 16px;

  transition: all 0.3s;
  cursor: pointer;

 }
 .buttonPerfil:hover{
    background-color:#4c8cf0;
 }

    </style>
</head>
<body>
   


<?php include("navLogin.php");?>



<br><br><br><br><br><br><br><br>

<div class="card">

  <p class="message">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam ea quo unde
    vel adipisci blanditiis voluptates eum. Nam, cum minima?
  </p>

  <div class="actions"><center>
  <button onclick="window.location='cadastrar.php'" class="buttonPerfil">Cadastrar-se como usuário</button><br><br>
<button onclick="window.location='cadastroDentista.php'" class="buttonPerfil">Cadastrar-se como dentista</button>
   </center>
  </div>
</div>

<?php include("footer.html");?>


</body>
</html>
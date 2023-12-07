<?php
session_start();
// VISUALIZAÇÕES DA PAGINA
include_once("../php/conecta.php");

$id_usuario = $_SESSION['id_user']; // ID do usuário na sessão
$id_publicacao = $_GET['id']; // ID da publicação está sendo passado via GET

$ip = $_SERVER['REMOTE_ADDR'];
$navegador = $_SERVER['HTTP_USER_AGENT'];


// Verificar se o usuário já visualizou essa publicação
$stmt = $conn->prepare("SELECT * FROM tb_acesso WHERE id_post = :id_publicacao AND id_usuario = :id_usuario");
$stmt->bindParam(':id_publicacao', $id_publicacao);
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    // Se o usuário ainda não visualizou, registrar a visualização
    $inserir = $conn->prepare("INSERT INTO tb_acesso (dt_acesso, ds_navegador, ip, id_post, id_usuario) VALUES (NOW(), :navegador, :ip, :id_publicacao, :id_usuario)");
    $inserir->bindValue(':navegador', $navegador);
    $inserir->bindValue(':ip', $ip);
    $inserir->bindParam(':id_publicacao', $id_publicacao);
    $inserir->bindParam(':id_usuario', $id_usuario);
    $inserir->execute();
}

// EXIBIR PUB
$blog_pub = $conn->prepare("SELECT * FROM tb_blog WHERE id_post = :id");
$blog_pub->bindParam(':id', $id_publicacao);
$blog_pub->execute();
$lines = $blog_pub->rowCount();  
$publi = $blog_pub->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="img/logo.png">
  <link rel="stylesheet" href="../css/view-blog.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- FONTE POPINS -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,200;1,300&display=swap" rel="stylesheet">
  <!-- ICON -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <title>Publicação - <?php echo $publi['nm_postagem']?></title>
</head>

<body style="background-color:#DBEEFF">
  <!-- NAV DO SITE -->
  <?php
include("navbarsS.php");
?>
<br><br><br><br>
<br><br>


  <!-- <div class="header">
    <div class="progress-container">
      <div class="progress-bar" id="myBar"></div>
    </div>
  </div> -->

  <?php
  if($lines === 0){
    echo "Desculpe, mas essa página não existe!"."<br>";
    echo "<a href='blog.php' class='back-blog'>Voltar para o blog</a>";
  }else{
  extract($publi);
  ?>
  <div style="display:flex;justify-content:center;">
<div class="card">

<div class="info">
  <p class="title"><?php echo $nm_postagem; ?></p>
  <p style="font-size:1rem;"><?php echo $ds_conteudo; ?></p>
</div>
<div class="dateActor">
        Por <?php echo $nm_autor ?>, publicado em <?php date_default_timezone_set('America/Sao_Paulo');

         echo date('d/m/Y', strtotime($dt_data)); ?>
      </div><br>
<div class="footer">


  <div class="visu-post">
    <i class="fi fi-rr-eye" >
      <?php
// Obter a quantidade total de visualizações para exibição
$stmt = $conn->prepare("SELECT COUNT(*) AS total_visualizacoes FROM tb_acesso WHERE id_post = :id_publicacao");
$stmt->bindParam(':id_publicacao', $id_publicacao);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

$total_visualizacoes = $resultado['total_visualizacoes'];

echo "$total_visualizacoes";


      ?>

    </i>
  </div>

  <?php
}
?>


  </p>
  <div class="share">
       
        <a class="share" id="copiarBotao" style="cursor:pointer;"><i class="fi fi-sr-share" style="position:relative;top:0.2rem;"></i> Compartilhe este conhecimento</a>
      </div>
</div>
</div>
</div>

 
  <script>
        // Função para copiar a URL da página atual
        function copiarURL() {
            // Obtém a URL da página atual
            var url = window.location.href;

            // Cria um elemento de input para armazenar a URL
            var input = document.createElement('input');
            input.value = url;

            // Adiciona o elemento de input à página
            document.body.appendChild(input);

            // Seleciona o conteúdo do input
            input.select();

            // Copia o conteúdo selecionado para a área de transferência
            document.execCommand('copy');

            // Remove o elemento de input da página
            document.body.removeChild(input);

            // Feedback para o usuário
            swal('URL copiada: '+url);
        }

        // Associa a função ao evento de clique do botão
        document.getElementById('copiarBotao').addEventListener('click', copiarURL);
    </script>

<script src="../js/scroll.js"></script>
<?php include("footer.html");?>
</main>
</body>

</body>
</html>
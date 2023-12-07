<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="img/logo oursmile.png">
  <link rel="stylesheet" href="css/blog.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/modal.css">
  <link rel="stylesheet" href="dist/ui/trumbowyg.min.css">
  <!-- Font Google -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <title>Oursmile</title>
</head>

<body>
  <!-- NAV DO SITE -->
  <nav id='menu'>
    <input type='checkbox' id='responsive-menu' onclick='updatemenu()'><label></label>
    <ul>
      <li><a href='#'>Sobre nós</a></li>
      <li><a href='#'>Clínicas e profissionais</a></li>
      <li><a href='blog.php'>Blog</a></li>
      <li><a href='index.html'>Home</a></li>
    </ul>
  </nav>

  <!-- BOTÕES ADM -->
  <div class="button-nav">
    <!-- BOTÃO PARA ABRIR MODAL-->
    <div class="button-adm">
      <button id="myBtn">+ Adicionar publicação</button>
    </div>

    <div class="button-adm">
      <button>Selecionar postagem</button>
    </div>
  </div>

  <div class="title">
    <h1>Blog Oursmile</h1>
  </div>

  <!-- MODAL PARA ADICIONAR PUBLICAÇÃO -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>Nova publicação</h2>
      </div>
      <div class="modal-body">
        <form id="postagemInfo" method="post" enctype="multipart/form-data">
          
          <input type="hidden" name="data" id="data" value="<?php $hoje = date('d/m/Y');?>">
          <div class="input-file">
            <label for="imgPub">Insira a imagem de destaque</label>
            <input type="file" class="file" id="previewImg" name="previewImg">
          </div>

          <div class="input-text">
            <label for="autor" class="form-label">Autor/fonte:</label>
            <input type="text" class="form-control" id="autor" name="autor" placeholder="Insira o título da postagem">
          </div>

          <div class="input-text">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Insira o título da postagem">
          </div>

          <div class="input-text">
            <label for="desc" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="desc" name="desc" placeholder="Insira um breve texto sobre o assunto">
          </div>  
        

          <div class="input-text">
            <label for="trumbowyg-editor">Conteúdo da postagem</label>
            <textarea class="trumbowyg-editor" name="conteudo" id="trumbowyg-editor" rows="5" placeholder="Escreva aqui o conteúdo da publicação"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn" type="submit" name="salvarPub" id="salvarPub">Publicar</button>
      </div>
      </form>
    </div>
  </div>
  <div id="subtitile"> Posts recentes</div>
  <!-- EXIBIR DADOS DO BANCO DE DADOS -->
  <?php
  include('php/conecta.php');
  $stmt = $conn->prepare("SELECT * FROM tb_blog");
  $stmt->execute();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  ?>
    <!-- CARD DA POSTAGEM -->
    <section>
      <div class="card">
        <div class="img-file">
        <img src="<?php echo $row['ds_img'];?>" class="card-img" alt="">
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $row['nm_postagem']; ?></h5>
          <p class="card-text"><?php echo $row['nm_desc']; ?></p>
          <div class="button-edit">
            <button><a onclick="window.location.href='view.php?id=<?php echo $row['id']; ?>'" class="btn btn-primary">Saiba mais</a></button>
            <button><a onclick="window.location.href='edit.php?id=<?php echo $row['id']; ?>'" id="edit">Edit</a></button>
            <button type="button" class="btn btn-danger"><a class="btn-remove" href="excluirPub.php?id=<?php echo $row['id']; ?>">X</a></button>
          </div>
        </div>
      </div>
      </div>
    </section>

  <?php
  }
  ?>

  <script src="js/modal.js"></script>
  <!-- TRUMBOWYG -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="dist/trumbowyg.min.js"></script>

  <script>
    $('#trumbowyg-editor').trumbowyg({
      btns: [
        ['undo', 'redo'], // Only supported in Blink browsers
        ['formatting'],
        ['strong', 'em', 'del'],
        ['superscript', 'subscript'],
        ['link'],
        ['insertImage'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
        ['unorderedList', 'orderedList'],
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen']
      ],
      autogrow: true
    });
  </script>

  <!-- ajax para enviar dados para o php -->
  <script>
    $(document).ready(function() {
      $('#postagemInfo').submit(function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário
        var form_data = new FormData(this);

        $.ajax({
          url: 'php/infoBlog.php', // Arquivo PHP para processar os dados
          type: 'POST',
          data: form_data,
          contentType: false,
          processData: false,
          success: function(response) {
            console.log(response); // Exibe a resposta do servidor
            location.reload(); // Recarrega a página
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);

          }
        });
      });
    });
  </script>
  </body>
</html>

<!-- $('#myModal').modal('hide'); // Fechar o modal após o envio dos dados -->
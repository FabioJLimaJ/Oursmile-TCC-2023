<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/logo oursmile.png">
    <link rel="stylesheet" href="../css/edit.css">

    <link rel="stylesheet" href="../dist/ui/trumbowyg.min.css">
    <!-- FONTE POPINS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,200;1,300&display=swap" rel="stylesheet">
    <title>Oursmile</title>
</head>

<body style="background-color:#F3F5F6;">
    <!-- NAV DO SITE -->
  <?php
  include('navbars.php');
  ?>
<br><br><br><br><br>
    <?php
    include('../php/conecta.php');

    //Exibir
    $id = $_GET['id'];
    $blog_pub = $conn->prepare("SELECT * FROM tb_blog WHERE id_post ='$id'");
    $blog_pub->execute();
    $publi = $blog_pub->fetch(PDO::FETCH_ASSOC);
    
    $query = $conn->query("SELECT * FROM tb_categoria ORDER BY nm_categoria ASC");  
    $registros = $query->fetchAll(PDO::FETCH_ASSOC);

    $categoria = $conn->prepare("SELECT * FROM tb_categoria");
    $categoria->execute();
    $exibir_atual = $categoria->fetch(PDO::FETCH_ASSOC);
    ?>

  <section class="edit-pub">
    
    <div class="tittle"><h1 class="title-edit">Editar publicação</h1></div><br>
          <form id="editPost" action="../php/editar.php?id=<?php echo $publi['id_post'];?>" method="post" enctype="multipart/form-data">
          <div class="input-file">
          <img class="imagem" />
            <label for="previewImg">Altere a imagem</label>
            <img src="<?php echo $publi['ds_img'];?>" id="imagem-p" class="imagem-p" style="width: 100%;">
            <input type="file" class="file" id="previewImg" name="previewImg" accept="image/*">
          </div>
     <div class="input-group">     
          <div class="input-text">
            <label for="autor" class="form-label">Autor/fonte:</label>
            <input type="text" class="form-control" id="autor" name="autor" value="<?php echo $publi['nm_autor'];?>"placeholder="Insira o título da postagem">
          </div>

            <div class="input-text">
              <label for="titulo" class="form-label">Insira o titulo</label>
              <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Insira o título da postagem" value="<?php echo $publi['nm_postagem'];?>">
            </div>

            <div class="input-text">
              <label for="desc" class="form-label">Descrição:</label>
              <input type="text" class="form-control" id="desc" name="desc" placeholder="Insira um breve texto sobre o assunto" value="<?php echo $publi['nm_desc'];?>">
            </div>

            <div class="input-text">
              <label for="topico" class="form-label">Tópico:</label>
              <select id="categoria" name="categoria">
            <option selected disabled><?php echo $exibir_atual['nm_categoria'];?></option>
              <?php
              foreach($registros as $option){
              ?>
              
              <option value="<?php echo $option['id'];?>"><?php echo $option['nm_categoria'];?></option>

              <?php
              }
              ?>
          </select>
            </div>

       </div>

            <div class="input-text">
              <label for="trumbowyg-editor">Conteúdo da postagem</label>
              <textarea class="trumbowyg-editor" name="conteudo" id="trumbowyg-editor" rows="5" placeholder="Escreva aqui o conteúdo da publicação" value=""><?php echo $publi['ds_conteudo'];?></textarea>
            </div>

            <div class="button-edit">
                <button class="button btn-send">Salvar</button>
                <button class="button btn-cancelar"><a href="blog.php">Cancelar</a></button>
            </div>

      </form>
    </div>
  </section>

<script src="../js/validar.js"></script>
<!-- TRUMBOWYG -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="../dist/trumbowyg.min.js"></script>

    <script>
      $('#trumbowyg-editor').trumbowyg({
        btns: [
          ['viewHTML'],
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
    </main>
    
</body>

</body>
</html>
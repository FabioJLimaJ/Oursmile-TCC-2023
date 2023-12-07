<!-- MODAL PARA ADICIONAR PUBLICAÇÃO -->

<div id="myModalPub" class="modalPub">
  <div class="modal-contentPub">
    <div class="modal-headerPub">
      <span class="closePub">&times;</span>
      <h2>Nova publicação</h2>
    </div>
    <div class="modal-bodyPub">
      <form id="postagemInfo" method="post" enctype="multipart/form-data">
        <div class="input-file"><br> 
          <img class="imagem" />
          <label for="previewImg" class="buttonPerfil"style="width:20rem;">Insira a imagem de destaque</label>
          <input type="file" class="file" id="previewImg" name="previewImg" accept="image/png, image/jpeg" style="display:none;">
          <img src="" alt="" id="imagem-p" class="imagem-p" style="width:10rem;">
        </div><br>
        <hr class="border-light m-0"><br>
        <center>
        <div class="input-group">


          <div class="input-text">
            <label for="autor" class="form-label">Autor/fonte:</label>
            <input type="text" class="form-control" id="autor" name="autor" value="<?php echo $exibir_user['nm_nome'];?>" placeholder="Insira o nome do autor">
          </div>
&nbsp;&nbsp;
          <div class="input-text">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Insira o título da postagem">
          </div>
          &nbsp;&nbsp;
          <div class="input-text">
            <label for="desc" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="desc" name="desc"
              placeholder="Insira um breve texto sobre o assunto">
          </div>
          &nbsp;&nbsp;
          <div class="input-text"  style="position:relative; top:0.5rem;">
            <label for="categoria">Tópico</label>
            <select id="categoria" name="categoria" class="form-select">
            <option selected disabled>Selecione o tópico</option>
              <?php
              $query = $conn->query("SELECT * FROM tb_categoria ORDER BY nm_categoria ASC");  
              $registros = $query->fetchAll(PDO::FETCH_ASSOC);
              foreach($registros as $option){
              ?>
              
              <option value="<?php echo $option['id'];?>"><?php echo $option['nm_categoria'];?></option>

              <?php
              }
              ?>
          </select>
          </div>
         
        </div> </center>
<br>
        <hr class="border-light m-0">
<br>
        <div class="input-text trumbow">
          <label for="trumbowyg-editor">Conteúdo da postagem</label>
          <textarea class="trumbowyg-editor" name="conteudo" id="trumbowyg-editor" rows="5"
            placeholder="Escreva aqui o conteúdo da publicação"></textarea>
        </div><br><hr class="border-light m-0">
<br>
        <div class="modal-footerPub">
          <button class="button btn-send" type="submit" name="savePub" id="savePub">Publicar</button>
        </div>
      </form>
    </div>
    <p id="resposta"></p><br>
  </div>
</div>


<script src="../js/validar.js"></script>
<!-- JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<!-- LINK EDITOR -->
<script src="../dist/trumbowyg.min.js"></script>
<!-- LINK MODAL -->
<script src="../js/modalSenha.js"></script>

<!-- TRUMBOWYH EDITOR -->
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
      ['removeformat']  

    ],
    autogrow: true
  });
</script>


<!-- ajax para enviar dados para o php -->
<script>
  $(document).ready(function () {
    $('#postagemInfo').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);

      $.ajax({
        url: '../php/infoBlog.php', // Arquivo PHP para processar os dados
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

</script>
<!-- The Modal -->
<div id="myModal2" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close2">&times;</span>
  <p>Alterar dados</p>
  <div class="modal-body">
    <div class="input-group">
    <form id="editarDados" method="POST" enctype="multipart/form-data">

        <label for="nome">Nome</label>
      <div class="input-text">
          <input type="text" name="nome" id="nome" placeholder="Nome" value="<?php echo $nm_nome?>">
      </div>

      <label for="sobrenome">Sobrenome</label>
      <div class="input-text">
          <input type="text" name="sobrenome" id="sobrenome" placeholder="Sobrenome" value="<?php echo $nm_sobrenome?>">
      </div>

      <label for="email">Email</label>
      <div class="input-text">
        <input type="text" name="email" id="email" placeholder="Alterar email" value="<?php echo $nm_email?>">
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button id="alterar" type="submit">Alterar</button>

  </form>
  <button class="close-btn">Cancelar</button>
</div>
  <p id="resultado"></p>
</div>
</div>
 
<!-- LINK MODAL -->
<script src="../js/modalSenha.js"></script>

<!-- JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<!-- JQUERY PARA ALTERAR SENHA -->
<script>
  $(document).ready(function () {
    $('#editarDados').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);
      $.ajax({
        url: '../php/edit-user.php?id=<?php echo $stmt['id'];?>', // Arquivo PHP para processar os dados
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response); // Exibe a resposta do servidor
          $('#resultado').html(response); // exibe resposta no html
          
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>
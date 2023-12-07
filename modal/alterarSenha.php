<!-- The Modal -->
<div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close">&times;</span>
  <p>Alterar senha</p>
  <div class="modal-body">
    <div class="input-group">
      <div class="input-text">
        <input type="hidden">
        <form id="editarSenha" method="POST">
          <input type="password" name="senha" id="senha" placeholder="Nova senha"  maxlength="8">
      </div>
      <div class="input-text">
        <input type="password" name="senhaconfirm" id="senhaconfirm" placeholder="Confirme a senha"  maxlength="8">
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button id="alterar" type="submit">Alterar</button>

  </form>
  <button class="close-btn">Cancelar</button>
</div>
  <p id="result"></p>
</div>
</div>
 
<!-- LINK MODAL -->
<script src="../js/modalSenha.js"></script>

<!-- JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<!-- JQUERY PARA ALTERAR SENHA -->
<script>
  $(document).ready(function () {
    $('#editarSenha').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);
      $.ajax({
        url: '../php/editarSenha.php?id=<?php echo $stmt['id'];?>', // Arquivo PHP para processar os dados
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response); // Exibe a resposta do servidor
          $('#result').html(response); // exibe resposta no html
          
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>
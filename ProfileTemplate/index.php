<?php
session_start();
include('../php/conecta.php');
if (!isset($_SESSION['id_user'])) {
  header("location: ../index.php");
} else{
  $user = $_SESSION['id_user'];
  $usuario = $conn->prepare("SELECT * FROM tb_usuario WHERE id = '$user'");
  $usuario->execute();
  $usuario = $usuario->fetch();
  extract($usuario);


  $clinica = $conn->prepare("SELECT * FROM tb_clinica");
  $clinica->execute();
  $clinica_exibir = $clinica->fetch();
}

?>
<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - <?php echo $nm_nome;?></title>
    <link rel="icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/perfil.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .buttonPerfil{
  display: inline-block;
  border-radius: 4px;
  background-color:#3db0f6;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 14px;
  padding: 16px;
  width: 130px;
  transition: all 0.3s;
  cursor: pointer;
  margin: 5px;
 }
 .buttonPerfil:hover{
    background-color:#4c8cf0;
 }
</style>
</head>

<body>
    
<?php include("../pag/navbarsS.php")?>

<br><br><br><br><br>

    <div class="container light-style flex-grow-1 container-p-y">
       
        <div class="card overflow-hidden" style="box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">Geral</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Editar senha</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Clínicas salvas</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-social-links">Posts salvos</a>
                           
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                        <form id="enviarFoto" enctype="multipart/form-data">
                            <div class="card-body media align-items-center">

                                <img src="<?php echo $ds_foto;?>" alt="Imagem do usuário" class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Alterar foto de perfil
                                        <input type="file" class="account-settings-fileinput" name="fotoPerfil" id="fotoPerfil">
                                    </label> &nbsp;
                                    <button type="submit" class="buttonPerfil" id="atualizar">Atualizar</button>
                         </form>


                                <button type="button" class="buttonPerfil" onclick="location.href='../pag/addClinica.php'" style="width:10rem;">Adicionar clínica</button>
                                    <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">

                                <p id="resposta"></p>

                                <p id="resultado"></p>
                                    <form id="editarDados" method="POST" enctype="multipart/form-data">
                                    <label class="form-label">Nome:</label>
                                    <input type="text" name="nome" id="nome" class="form-control mb-1" value="<?php echo $nm_nome;?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Sobrenome:</label>
                                    <input type="text" name="sobrenome" id="sobrenome" class="form-control" value="<?php echo $nm_sobrenome;?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" name="email" id="email" class="form-control mb-1" value="<?php echo $nm_email;?>"><br>
                                    <button type="submit" class="buttonPerfil" id="alterar">Alterar dados</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                <form id="editarSenha" method="POST">
                                    <label class="form-label" >Nova senha:</label>
                                    <input type="password" class="form-control" name="senha" id="senha" maxlength="8">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirme a senha:</label>
                                    <input type="password" class="form-control" name="senhaconfirm" id="senhaconfirm" maxlength="8" ><br>

                                    <p id="result"></p>

                                    <button type="submit" class="buttonPerfil" id="alterar">Alterar senha</button>
                                </form>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Clínicas salvas</label>
                                    <hr class="border-light m-0">
                                </div>

   
    <?php
    // Consulta para buscar as publicações favoritadas pelo usuário
    $query = "SELECT * FROM tb_clinica JOIN tb_favorito ON tb_clinica.id = tb_favorito.clinica_id WHERE tb_favorito.user_id = :usuario_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_id', $_SESSION['id_user']);
    $stmt->execute();
    $lines = $stmt->rowCount();
    if($lines>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    ?>

   <div style="display:inline-block;">
   <div class="cardC"> 
  <div class="header"> 
    <div class="image">
    <img src="<?php echo $row['ds_img'];?>" alt="Imagem relacionada a clínica">
      </div> 
      <div class="content">
         <span class="title"><?php echo $row['nm_clinica'];?></span> 
       
         </div> 
         <div class="actions"><center>
            <button class="buttonPerfil" type="button" onclick="location.href= '../pag/pagClinica.php?id=<?php echo $clinica_exibir['id']; ?>'">Saiba mais</button> 
</center>
            </div> 
            </div> 
            </div>     
<br>
</div>
 
 
&nbsp;&nbsp;&nbsp;
<?php
    }
  }else{
    echo "Sem clínicas favoritadas!";
  }
?>
                          
                            </div>
                            <hr class="border-light m-0">
                            
                        </div>
                        <div class="tab-pane fade" id="account-social-links">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                <label class="form-label">Posts salvos</label>
                                <hr class="border-light m-0">
<br>
                                <?php
    // Consulta para buscar as publicações favoritadas pelo usuário
    $query = "SELECT * FROM tb_blog JOIN tb_favorito ON tb_blog.id_post = tb_favorito.pub_id WHERE tb_favorito.user_id = :usuario_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_id', $_SESSION['id_user']);
    $stmt->execute();
    $lines = $stmt->rowCount();
    if($lines>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    ?>

   <div style="display:inline-block;">
   <div class="cardC"> 
  <div class="header"> 
    <div class="image">
    <img src="<?php echo $row['ds_img'];?>" alt="imagem relacionada a postagem">
      </div> 
      <div class="content">
         <span class="title"><?php echo $row['nm_postagem']; ?></span> 
       
         </div> 
         <div class="actions"><center>
            <button class="buttonPerfil" type="button" onclick="location.href= '../pag/blog.php?id=<?php echo $clinica_exibir['id']; ?>'">Saiba mais</button> 
</center>
            </div> 
            </div> 
            </div>     
<br>
</div>
 
 
&nbsp;&nbsp;&nbsp;
<?php
    }
  }else{
    echo "Sem clínicas favoritadas!";
  }
?>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-connections">
                            <div class="card-body">
                                <button type="button" class="btn btn-twitter">Connect to
                                    <strong>Twitter</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <h5 class="mb-2">
                                    <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i
                                            class="ion ion-md-close"></i> Remove</a>
                                    <i class="ion ion-logo-google text-google"></i>
                                    You are connected to Google:
                                </h5>
                                <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                    data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-facebook">Connect to
                                    <strong>Facebook</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-instagram">Connect to
                                    <strong>Instagram</strong></button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-notifications">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Activity</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone comments on my article</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone answers on my forum
                                            thread</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone follows me</span>
                                    </label>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Application</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">News and announcements</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly product updates</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly blog digest</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
  
  <?php include("../pag/footer.html");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <!-- alterar nome, sobrenome, email -->
    <script>
  $(document).ready(function () {
    $('#editarDados').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);
      $.ajax({

        url: '../php/edit-user.php?id=<?php echo $usuario['id'];?>', // Arquivo PHP para processar os dados


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

  $(document).ready(function () {
    $('#enviarFoto').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);

      $.ajax({

        url: '../php/fotoPerfil.php?id=<?php echo $usuario['id']?>', // Arquivo PHP para processar os dados


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

  $(document).ready(function () {
    $('#editarSenha').submit(function (event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      var form_data = new FormData(this);
      $.ajax({

        url: '../php/editarSenha.php?id=<?php echo $usuario['id'];?>', // Arquivo PHP para processar os dados

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
</body>

</html>
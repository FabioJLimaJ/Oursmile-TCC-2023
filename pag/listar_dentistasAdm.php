<?php
session_start();
include('../php/conecta.php');
$nivel = $_SESSION['nivel'];

if ($nivel != 2) {
  $_SESSION['msg'] = "Você não tem permissão de acessar essa página!";
  header("location: ../index.php");
} else {

// CONSULTA TABELA DENTISTA
$validacao = '3';
$stmt = $conn->prepare("SELECT id, nm_nome, nm_sobrenome, nm_email, nr_cro, nr_cpf, id_nivel FROM tb_usuario WHERE id_nivel = '$validacao'");
$stmt->execute();
?>

  <!DOCTYPE HTML>
  <html lang="pt-br">

  <head>
    <title>Gerenciar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/eac31603cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/navbar.css">
  </head>
  <style>
    .hidden {
      display: none;
    }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script>
    //pegar dados modal editar
    $(function() {
      $('#modalEditar').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var nivel = button.data('nivel')
        var nome = button.data('nome')
        var modal = $(this)

        // aplicar valor ao id
        modal.find('.modal-title').text('Alterar cargo do usuário: ' + nome)
        modal.find('#select').text(nivel)
        modal.find('#id').val(id)
        modal.find('#cargo_usuario').val(nivel)
      });
    });

    $(function() {
      $('#modalApagar').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var nome = button.data('nome')
        var modal = $(this)

        // aplicar valor ao id
        modal.find('.modal-title').text('Excluir usuário ' + nome)
        modal.find('#id').val(id)
        modal.find('#nome_usuario').val(nome)
      });
    });
  </script>



  <body>
    <!-- NAV DO SITE -->
    <nav class="nav">
      <img class="nav__collapser" src="https://raw.githubusercontent.com/JamminCoder/grid_navbar/master/menu.svg" alt="Collapse">
      <img src="../img/logo.png" alt="" id="logotipo">

      <!-- Put your collapsing content in here -->
      <div class="nav__collapsable">
        <a href="../index.php">Home</a>
        <a href="blog.php">Blog</a>
        <a href="clinicas.php">Clínicas</a>

        <?php
        if (!isset($_SESSION['id_user'])) {
        ?>

          <a href="pag/cadastrar.php">Entrar</a>
        <?php
        } else {
        ?>
          <a href="../ProfileTemplate/index.php">Meu perfil</a>
          <a href="pag/listar_usuarioAdm.php">Gerenciar</a>
          <a href="#contact" onclick="window.location='php/sair.php'">Sair</a>
        <?php
        }
        ?>
        <div class="nav__cta">
        </div>
      </div>

    </nav>
    <div class="wrapper d-flex align-items-stretch">
      <?php
      include('sidebar-adm.html');
      ?>

      <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
        <div class="tudo">

          <div class="box-container">
            <div class="container">
              <div class="row mt-4">
                <div class="col-lg-12">
                  <div>
                    <h4>Listar Dentistas</h4>
                    <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdicionar">+ Adicionar usuário </button> -->
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-lg-12">

                  <!-- Modal adicionar usuário -->
                  <div class="modal fade" id="modalAdicionar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Adicionar novo usuário</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">


                          <label for="selectDivs">Selecione o cargo do usuário</label>
                          <select id="selectDivs">
                            <option selected disabled>Selecione</option>
                            <option value="div1">Usuário</option>
                            <option value="div3">Dentista</option>
                          </select>

                          <!-- FORMULARIO USUÁRIO COMUM/ADMINISTRADOR -->
                          <div id="div1" class="hidden">

                            <form method="POST" id="formUsuario" enctype="multipart/form-data" action="../php/add-userAdm.php">
                              <input type="hidden" name="nivel_usuario" id="nivel_usuario" value="1">
                              <div class="form-group">
                                <label for="imagem">Imagem do usuário</label>
                                <input type="file" class="form-control-file" id="imagem_usuario" name="imagem_usuario">
                              </div>

                              <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Nome do usuário">
                              </div>

                              <div class="form-group">
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome_usuario" name="sobrenome_usuario" placeholder="Sobrenome do usuário">
                              </div>

                              <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email_usuario" name="email_usuario" aria-describedby="emailHelp" placeholder="Insira o email">
                              </div>

                              <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Senha do usuário">
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" id="comum" name="nivel">
                                <label class="form-check-label" for="comum">
                                  Comum
                                </label>
                                <br>
                                <input class="form-check-input" type="radio" value="2" id="nivel" name="nivel">
                                <label class="form-check-label" for="nivel">
                                  Administrador
                                </label>
                              </div>
                              <button type="submit" name="cadastrar" class="btn btn-success">Cadastrar</button>
                            </form>
                          </div>
                            <!-- FORMULÁRIO PARA DENTISTA -->
                          <div id="div3" class="hidden">
                            
                            <form method="POST" id="formDentista" enctype="multipart/form-data" action="../php/add-dentAdm.php">
                              <input type="hidden" name="nivel_dentista" id="nivel_dentista" value="3">

                              <div class="form-group">
                                <label for="imagem">Imagem do usuário</label>
                                <input type="file" class="form-control-file" id="imagem_dentista" name="imagem_dentista">
                              </div>

                              <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome_dentista" name="nome_dentista" placeholder="Nome do usuário">
                              </div>

                              <div class="form-group">
                                <label for="sobrenome">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome_dentista" name="sobrenome_dentista" placeholder="Sobrenome do usuário">
                              </div>

                              <div class="form-group">
                                <label for="CRO">CRO</label>
                                <input type="text" class="form-control" id="cro_dentista" name="cro_dentista" placeholder="Insira o CRO">
                              </div>

                              <div class="form-group">
                                <label for="cpf_usuario">CPF</label>
                                <input type="text" class="form-control" id="cpf_usuario" name="cpf_usuario" placeholder="CPF do dentista">
                              </div>

                              <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email_dentista" name="email_dentista" aria-describedby="emailHelp" placeholder="Insira o email">
                              </div>

                              <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha_dentista" name="senha_dentista" placeholder="Senha do usuário">
                              </div>

                              <button type="submit" name="cadastrar" class="btn btn-success">Cadastrar</button>
                            </form>
                          </div>
                        </div>
                        <!-- <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          </div> -->

                      </div>
                    </div>
                  </div>

                  <table class="table">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Dentista</th>
                        <th scope="col">Sobrenome</th>
                        <th scope="col">CRO</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Ações</th>
                      </tr>
                    </thead>
                    <!-- LISTAR USUÁRIOS CADASTRADOS -->

                    <tbody>
                      <?php
                      while ($listar_usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($listar_usuario);

                        echo "<tr>";
                        echo "<td>" . $id . "</td>";
                        echo "<td>" . $nm_nome . "</td>";
                        echo "<td>" . $nm_sobrenome . "</td>";
                        echo "<td>" . $nr_cro . "</td>";
                        echo "<td>" . $nr_cpf . "</td>";
                      ?>
                        <td>


                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditar" data-id='<?php echo $id ?>' data-nivel='<?php echo $id_nivel ?>' data-nome='<?php echo $nm_nome ?>'>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                              <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z" />
                            </svg>
                          </button>

                          <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#modalApagar" data-id='<?php echo $id ?>' data-nome='<?php echo $nm_nome ?>'>
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                              <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                            </svg>
                          </button>

                        </td>
                        </tr>


                        <!-- FECHAR WHILE DA LISTAGEM -->
                      <?php
                      }
                      ?>

                      <!-- Modal Editar Cargo -->
                      <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Alterar cargo do usuário </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                              <form action="../php/alterarCargo.php" method="POST">
                                <input type="hidden" id="id" name="id">
                                <select class="form-select" aria-label="select example" name="cargo_usuario" id="cargo_usuario">
                                  <option disabled selected id="select">Alterar</option>
                                  <option value="1">Usuário comum</option>
                                  <option value="2">Administrador</option>
                                  <option value="3">Dentista</option>
                                </select>

                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Salvar</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                            </form>

                          </div>
                        </div>
                      </div>

                      <!-- Modal Deletar -->
                      <div class="modal fade" id="modalApagar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Excluir usuário</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="../php/excluirUsuario.php" method="POST">
                                <p>Tem certeza que deseja excluir o usuário?</p>
                                <input type="hidden" name="id" id="id">
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-danger">Excluir</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="../js/teste.js"></script>
    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> 
  <!-- FECHAR SESSION -->
<?php
}
?>

</body>
</main>
</body>
</html>
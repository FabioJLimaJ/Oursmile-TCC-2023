<?php
  session_start();
  include('../php/conecta.php');
  $nivel = $_SESSION['nivel'];

  if ($nivel != 2) {
    $_SESSION['msg'] = "Você não tem permissão de acessar essa página!";
    header("location: ../index.php");
  }else{
    $stmt = $conn->prepare("SELECT * FROM tb_clinica");
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
$(function(){
  $('#modalDelete').on('show.bs.modal', function (event){
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var nome = button.data('nome')
    var modal = $(this)
    // aplicar valor ao id
    modal.find('.modal-title').text('Tem certeza que deseja excluir a clínica ' + nome + '?')
    modal.find('#id').val(id)
    modal.find('#nome').val(nome)

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
  }else{
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
                      <h4>Listar clínicas</h4>
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" onclick="window.location.href='clinicas.php'">+ Adicionar clínica </button>

                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-lg-12">
                  <input type="text" id="search" placeholder="Pesquisar">
    <div id="records"></div>
    <div class="pagination" id="pagination"></div>


                      <!-- Modal Deletar -->
                      <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Excluir clínica</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="../php/apagarClinica.php" method="POST">
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
                            
      <script src="../js/teste.js"></script>
      <script src="../js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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
      ['removeformat'],
      ['fullscreen']
    ],
    autogrow: true
  });
</script>

<script>
        function fetchRecords(page, search = '') {
            $.ajax({
                url: '../php/exibir/exibir-clinica.php',
                method: 'POST',
                data: { page: page, search: search },
                success: function(response) {
                    $('#records').html(response);
                }
            });
        }

        $(document).ready(function() {
            fetchRecords(1);

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).data('page');
                var search = $('#search').val();
                fetchRecords(page, search);
            });

            $('#search').keyup(function() {
                var search = $(this).val();
                fetchRecords(1, search);
            });
        });
    </script>

      <!-- FECHAR SESSION -->
    <?php
  }

    ?>

  </body>
  </main>
  </body>
  </html>
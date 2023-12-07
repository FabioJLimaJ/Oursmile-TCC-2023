<?php
session_start();
include('../php/conecta.php');
$nivel = $_SESSION['nivel'];

if ($nivel != 2) {
  $_SESSION['msg'] = "Você não tem permissão de acessar essa página!";
  header("location: ../index.php");
} else {

// CONSULTA TABELA DENTISTA
$validacao = '4';
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
      $('#modalAprovar').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var nivel = button.data('nivel')
        var nome = button.data('nome')
        var sobrenome = button.data('sobrenome')
        var cro_dentista = button.data('cro')
        var cpf = button.data('cpf')
        var modal = $(this)

        // aplicar valor ao id
        modal.find('.modal-title').text('Aprovar dentista ' + nome + sobrenome)
        modal.find('#select').text(nivel)
        modal.find('#id').val(id)
        modal.find('#nome_dentista').val(nome)
        modal.find('#sobrenome_dentista').val(sobrenome)
        modal.find('#cro_dentista').val(cro_dentista)
        modal.find('#cpf_dentista').val(cpf)
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
      <?php
        include("nav.php");
      ?>
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
                    <h4>Dentista aguardando validação</h4>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-lg-12">
                  <table class="table">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Dentista</th>
                        <th scope="col">Sobrenome</th>
                        <th scope="col">CRO</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ação</th>
                      </tr>
                    </thead>
                    <!-- LISTAR USUÁRIOS CADASTRADOS -->
                    <tbody>
                      <?php
                      while ($listar_usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($listar_usuario);

                        if ($id_nivel === '1') {
                          $id_nivel = "Usuário";
                        } elseif ($id_nivel === '2') {
                          $id_nivel = "Administrador";
                        } elseif ($id_nivel === '3') {
                          $id_nivel = "Dentista";
                        }elseif ($id_nivel === '4') {
                            $id_nivel = "Aguardando validação";
                          }
                        echo "<tr>";
                        echo "<td>" . $id . "</td>";
                        echo "<td>" . $nm_nome . "</td>";
                        echo "<td>" . $nm_sobrenome . "</td>";
                        echo "<td>" . $nr_cro . "</td>";
                        echo "<td>" . $nr_cpf . "</td>";
                        echo "<td>" . $id_nivel . "</td>";
                      ?>
                        <td>

                          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAprovar" data-id='<?php echo $id?>' data-cro='<?php echo $nr_cro?>' data-cpf  ='<?php echo $nr_cpf?>' data-nivel='<?php echo $id_nivel ?>' data-nome='<?php echo $nm_nome?> ' data-sobrenome='<?php echo $nm_sobrenome?>'>
                          Validar
                          </button>

                          <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#modalNegar" data-id='<?php echo $id_dentista ?>' data-nome='<?php echo $nm_dentista ?>'>
                          Negar  
                          </button>

                        </td>
                        </tr>


                        <!-- FECHAR WHILE DA LISTAGEM -->
                      <?php
                      }
                      ?>

                      <!-- Modal aprovar dentista -->
                      <div class="modal fade" id="modalAprovar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Aprovar dentista </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                              <form action="../php/validar-dentista.php" method="POST">
                                <input type="hidden" id="id_nivel" name="id_nivel">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                  <label for="nome">Nome do dentista</label>
                                  <input type="text" class="form-control" id="nome_dentista" placeholder="">
                                </div>

                                <div class="form-group">
                                  <label for="nome">Sobrenome</label>
                                  <input type="text" class="form-control" id="sobrenome_dentista" placeholder="">
                                </div>
                                
                                <div class="form-group">
                                  <label for="autor">CRO</label>
                                  <input type="text" class="form-control" id="cro_dentista" placeholder="">
                                </div>

                                <div class="form-group">
                                  <label for="autor">CPF</label>
                                  <input type="text" class="form-control" id="cpf_dentista" placeholder="">
                                </div>  
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Aprovar</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                            </form>

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
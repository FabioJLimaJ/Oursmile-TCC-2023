<?php

require('conecta.php');

$limit = 20;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$search = isset($_POST['search']) ? $_POST['search'] : '';

$start = ($page - 1) * $limit;

$query = "SELECT * FROM tb_usuario";
if (!empty($search)) {
    $query .= " WHERE nm_nome LIKE :search";
}

$query .= " LIMIT $start, $limit";

$stmt = $conn->prepare($query);

if (!empty($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}

$stmt->execute(); 

$output = '';

$total_records = $conn->query("SELECT COUNT(*) FROM tb_usuario")->fetchColumn();
$total_pages = ceil($total_records / $limit);

$output = '';

if ($stmt->rowCount() > 0) {
?>
<table class="table">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Sobrenome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Ações</th>
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
                        } elseif ($id_nivel === '4'){
                          $id_nivel = "Aguardando validação";
                        }
                        echo "<tr>";
                        echo "<td>" . $id . "</td>";
                        echo "<td>" . $nm_nome . "</td>";
                        echo "<td>" . $nm_sobrenome . "</td>";
                        echo "<td>" . $nm_email . "</td>";
                        echo "<td>" . $id_nivel . "</td>";
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
<?php
} else {
    $output = '<p>Nenhum registro encontrado.</p>';
}


// Barra de navegação
$output .= '<div class="pagination">';
if ($page > 1) {
    $output .= '<a href="#" data-page="' . ($page - 1) . '">Página Anterior</a>';
}

for ($i = max(1, $page - 5); $i <= min($page + 5, $total_pages); $i++) {
    $output .= '<a href="#" data-page="' . $i . '">' . $i . '</a>';
}

if ($page < $total_pages) {
    $output .= '<a href="#" data-page="' . ($page + 1) . '">Próxima Página</a>';
}
$output .= '</div>';

echo $output;

?>

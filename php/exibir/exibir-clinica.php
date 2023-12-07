<?php
include('../conecta.php');

$limit = 5;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$search = isset($_POST['search']) ? $_POST['search'] : '';

$start = ($page - 1) * $limit;

$query = "SELECT * FROM tb_clinica ";
if (!empty($search)) {
    $query .= " WHERE nm_clinica LIKE :search";
}

$query .= " LIMIT $start, $limit ";

$stmt = $conn->prepare($query);

if (!empty($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}

$stmt->execute();

$output = '';

$total_records = $conn->query("SELECT COUNT(*) FROM tb_clinica")->fetchColumn();
$total_pages = ceil($total_records / $limit);

$output = '';

if ($stmt->rowCount() > 0){
?>
    <table class="table">
                        <thead class="table-dark">
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome da clínica</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Email</th>
                            <th scope="col">Ações</th>
                          </tr>
                        </thead>
                        <!-- LISTAR USUÁRIOS CADASTRADOS -->

                        <tbody>
                      <?php
                  while ($listar_pub = $stmt->fetch(PDO::FETCH_ASSOC)){
                  extract($listar_pub);
                        echo "<tr>";
                        echo "<td>" . $id. "</td>";
                        echo "<td>" . $nm_clinica . "</td>";
                        echo "<td>" . $nm_endereco . "</td>";
                        echo "<td>" . $nm_email . "</td>";
                ?>
                <td>
                          
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="window.location.href='../pag/editClinica.php?id=<?php echo $listar_pub['id'];?>'">
      <i class="fa-solid fa-pen-to-square"></i>
      </button>

      <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-id='<?php echo $id?>' data-nome='<?php echo $nm_clinica?>' data-bs-target="#modalDelete">
      <i class="fa-solid fa-trash"></i>                                  
      </button>
                                  

                            </td>
                          </tr>
                <!-- FECHAR WHILE DA LISTAGEM -->
            <?php
    }
    }else{
        $output = '<p>Nenhum registro encontrado.</p>';
    }

    // Barra de navegação
           ?>
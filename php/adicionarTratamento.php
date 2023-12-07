<?php
require('conecta.php');

if (isset($_POST['adicionar'])) {
    $_SESSION['msg'] = '';
    $id = $_POST['id_clinic'];
    $stmt = $conn->prepare("INSERT INTO tb_tratamentos (nm_tratamento, id_clinica) VALUES (:tratamento, :clinica)");
    $stmt->execute(array(
        ':tratamento' => $_POST['nome_tratamento'],
        ':clinica' => $id
    ));
        header("location: ../pag/pagClinica.php?id=$id");
}else{
    $_SESSION['msg'] = "error";
}
?>
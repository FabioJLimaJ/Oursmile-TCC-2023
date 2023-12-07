<?php
require('conecta.php');

$id = $_POST['id'];
$nivel = $_POST['cargo_usuario'];

try{
$update = $conn->prepare("UPDATE tb_usuario SET id_nivel = :nivel WHERE id = :id");
$update->bindValue(':id', $id);
$update->bindValue(':nivel', $nivel);
$update->execute();
header("location: ../pag/listar_usuarioAdm.php");
}catch(PDOException $e){
    echo "error ".$e->getMessage();
}
?>

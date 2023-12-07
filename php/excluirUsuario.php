<?php
include('conecta.php');
$id = $_POST['id'];
try{
	$deletar = $conn->prepare("DELETE FROM tb_usuario WHERE id = '$id'");
	$deletar->execute();
	header("location: ../pag/listar_usuarioAdm.php");
	}catch(PDOException $e){
		echo "Error".$e->getMessage();
}

?>
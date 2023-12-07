<?php

include('conecta.php');
$id = $_GET['id'];
try{
	$deletar = $conn->prepare("DELETE FROM tb_clinica WHERE id = '$id'");
	$deletar->execute();
	header("location: ../pag/clinicas.php");
	}catch(PDOException $e){
		echo "Error".$e->getMessage();
}

?>
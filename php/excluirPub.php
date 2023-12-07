<?php

include('conecta.php');
$id = $_GET['id'];
try{
	$deletar = $conn->prepare("DELETE FROM tb_blog WHERE id_post = '$id'");
	$deletar->execute();
	header("location: ../pag/blog.php");
	}catch(PDOException $e){
		echo "Error".$e->getMessage();
}

?>
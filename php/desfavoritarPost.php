<?php
require("../php/conecta.php");
session_start();
if (isset($_SESSION['id_user'])) {
$publicacao_id = $_POST['publicacao_id'];

// Remover publicação do perfil do usuário
$deletar = $conn->prepare("DELETE FROM tb_favorito WHERE user_id = :user_id and pub_id = :pub_id");
$deletar->bindParam(':user_id', $_SESSION['id_user']);
$deletar->bindParam(':pub_id', $publicacao_id);
$deletar->execute();
header("location: ../pag/blog.php");
exit();
}
?>
<?php
include("conecta.php");

$id = $_GET['id'];
$arquivo = $_FILES['fotoPerfil']['tmp_name'];
$dir = '../imgPerfil/';
$_FILES['fotoPerfil']['name'] = "img" . uniqid() . $_FILES['fotoPerfil']['name'];
$file = $_FILES['fotoPerfil']['name'];
$destino = $dir . $file;
$extensao = $_FILES['fotoPerfil'];
$extensoes_permitidas = array('.jpg', '.png');

if (move_uploaded_file($arquivo, $destino)) {
    $alterar = $conn->prepare("UPDATE tb_usuario SET ds_foto = :enderecoArquivo WHERE id = :id");
    $alterar->bindValue(':enderecoArquivo', $destino);
    $alterar->bindValue(':id', $id);
    $alterar->execute();
    echo "<p style='color:green;'> Foto de perfil atualizada!</p>";
    echo '<meta http-equiv="refresh" content="0">';
}

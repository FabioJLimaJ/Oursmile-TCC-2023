<?php
require('conecta.php');

$id = $_GET['id'];
$autor = filter_input(INPUT_POST, 'autor');
$titulo = filter_input(INPUT_POST, 'titulo');
$descricao = filter_input(INPUT_POST, 'desc'); 
$conteudo = filter_input(INPUT_POST, 'conteudo');
$categoria = filter_input(INPUT_POST, 'categoria');

$arquivo = $_FILES['previewImg']['tmp_name'];
$dir = '../imgBlog/';
$_FILES['previewImg']['name'] = "img".uniqid().$_FILES['previewImg']['extension'];
$file = $_FILES['previewImg']['name'];
$destino = $dir.$file;

try{
    if(move_uploaded_file($arquivo, $destino)){
    $update = $conn->prepare("UPDATE tb_blog SET nm_postagem = :titulo, nm_desc = :descricao, ds_conteudo = :conteudo, nm_autor = :autor, ds_img = :destino, id_categoria = :id_categoria WHERE id_post = :id");
    $update->bindValue(':id', $id);
    $update->bindValue(':titulo', $titulo);
    $update->bindValue(':descricao', $descricao);
    $update->bindValue(':conteudo', $conteudo);
    $update->bindValue(':autor', $autor);
    $update->bindValue(':id_categoria', $categoria);
    $update->bindValue(':destino', $destino);
    $update->execute();
    header("location: ../pag/blog.php");
    }else{
     $update = $conn->prepare("UPDATE tb_blog SET nm_postagem = :titulo, nm_desc = :descricao, ds_conteudo = :conteudo, nm_autor = :autor, id_categoria = :id_categoria WHERE id_post = :id");
     $update->bindValue(':titulo', $titulo);    
     $update->bindValue(':descricao', $descricao);
     $update->bindValue(':conteudo', $conteudo);
     $update->bindValue(':autor', $autor);
     $update->bindValue(':id_categoria', $categoria);
     $update->bindValue(':id', $id);
     $update->execute(); 
     header("location: ../pag/blog.php");
  }
}catch(PDOException $e){
    echo "error: ".$e->getMessage();
}

?>
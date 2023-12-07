<?php
require('conecta.php');

if (isset($_POST['cadastrar'])) {
    $_SESSION['msg'] = '';
    $img = $_FILES['imagem_usuario']['name'];
    // diretorio onde o arquivo vai ser salvo
    $diretorio = '../imgPerfil/';
    // local para o banco de dados
    $local = $diretorio . $img;
    
    move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $img);
    $stmt = $conn->prepare("INSERT INTO tb_usuario (ds_foto, nm_email, nm_nome, nm_sobrenome, ds_senha, id_nivel) VALUES(:foto, :email, :nome, :sobrenome, :password, :nivel)");
    $stmt->execute(array(
        ':foto' => $local,
        ':email' => $_POST['email_usuario'],
        ':nome' => $_POST['nome_usuario'],
        ':sobrenome' => $_POST['sobrenome_usuario'],
        ':password' => $_POST['senha_usuario'],
        ':nivel' => $_POST['nivel']
    ));
    header("location: ../pag/listar_usuarioAdm.php");

}else{
    $_SESSION['msg'] = "error";
}
?>
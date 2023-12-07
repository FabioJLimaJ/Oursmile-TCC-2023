<?php
require('conecta.php');

if (isset($_POST['cadastrar'])) {
    $_SESSION['msg'] = '';
    $img = $_FILES['imagem_dentista']['name'];
    // diretorio onde o arquivo vai ser salvo
    $diretorio = '../imgPerfil/';
    // local para o banco de dados
    $local = $diretorio . $img;
    
    move_uploaded_file($_FILES['imagem_dentista']['tmp_name'], $diretorio . $img);
    $stmt = $conn->prepare("INSERT INTO tb_usuario (ds_foto, nm_email, nm_nome, nm_sobrenome, ds_senha, nr_cpf, nr_cro, id_nivel) VALUES(:foto, :email, :nome_dentista, :sobrenome, :password, :cro, :cpf, :nivel)");
    $stmt->execute(array(
        ':foto' => $local,
        ':email' => $_POST['email_dentista'],
        ':nome_dentista' => $_POST['nome_dentista'],
        ':sobrenome' => $_POST['sobrenome_dentista'],
        ':password' => $_POST['senha_dentista'],
        ':cpf' => $_POST['cpf_usuario'],
        ':cro' => $_POST['cro_dentista'],
        ':nivel' => $_POST['nivel_dentista']
    ));
        header("location: ../pag/listar_usuarioAdm.php");

}else{
    $_SESSION['msg'] = "error";
}
?>
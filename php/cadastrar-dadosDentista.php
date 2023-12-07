<?php
try {
    require('conecta.php');
    $arquivo = $_FILES['previewImg']['tmp_name'];
    $dir = '../imgBlog/';
    $_FILES['previewImg']['name'] = "img" . uniqid() . $_FILES['previewImg']['name'];
    $file = $_FILES['previewImg']['name'];
    $destino = $dir . $file;
    $extensao = $_FILES['previewImg'];
    $extensoes_permitidas = array('.jpg', '.png');
    $teste = '../imgPerfil/0/download.jpg';

    move_uploaded_file($arquivo, $destino);
    $stmt = $conn->prepare('INSERT INTO tb_usuario (ds_foto, nm_nome, nm_sobrenome, nm_email, nr_cro, ds_senha, nr_cpf, id_nivel) VALUES(:foto, :nome, :sobrenome, :email, :cro, :password, :cpf, :nivel)');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->execute(array(
        ':foto' => $teste,
        ':nome' => $_POST['nome'],
        ':sobrenome' => $_POST['sobrenome'],
        ':cro' => $_POST['cro_dentista'],
        ':cpf' => $_POST['cpf_dentista'],
        ':email' => $_POST['email'],
        ':password' => $_POST['senha'],
        ':nivel' => $_POST['nivel']
    ));

    echo "funciona";
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

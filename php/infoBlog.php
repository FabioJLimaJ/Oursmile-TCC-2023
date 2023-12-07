<?php
require('conecta.php');
// dados vindo do formulario
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (empty($dados['savePub'])) {
    $descricao = $_POST['desc'];
    $numCaracteres = strlen($descricao);
    // não deixa os inputs com espaço ser reconhecido como preenchido
    $dados = array_map('trim', $dados);
    // validar campos
    if (in_array('', $dados)) {
        echo "<p style='color: red;'> Por favor, preencha todos os campos!</p>";
    
    }else{
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y/m/d'); // Formato brasileiro para data e hora
        $arquivo = $_FILES['previewImg']['tmp_name'];
        $dir = '../imgBlog/';
        $_FILES['previewImg']['name'] = "img" . uniqid() . $_FILES['previewImg']['name'];
        $file = $_FILES['previewImg']['name'];
        $destino = $dir . $file;
        $extensao = $_FILES['previewImg'];
        $extensoes_permitidas = array('.jpg', '.png');

        if (!move_uploaded_file($arquivo, $destino)) {
            echo "<p style='color: red;'>Insira uma imagem!</p>";
        }elseif( ($extensao['type'] != 'image/png') AND ($extensao['type'] != 'image/jpeg') ){
            echo "<p style='color:red;'>Os formatos de imagem aceitos são PNG e JPEG!</p>";
        }else{
            $stmt = $conn->prepare("INSERT INTO tb_blog(ds_img, nm_postagem, nm_desc, ds_conteudo, nm_autor, dt_data, id_categoria)  VALUES(:enderecoArquivo, :titulo, :descricao, :conteudo, :autor, :dataAtual, :categoria)");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->execute(array(
                ':enderecoArquivo' => $destino,
                ':titulo' => $_POST['titulo'],
                ':descricao' => $_POST['desc'],
                ':conteudo' => $_POST['conteudo'],
                ':autor' => $_POST['autor'],
                ':categoria' => $_POST['categoria'],
                ':dataAtual' => $dataAtual
            ));
            if ($stmt->rowCount()) {
                echo '<meta http-equiv="refresh" content="1">';
                echo "<p style='color:green;'>Publicação adicionada com sucesso!</p>";
            } else {
                echo "<p style='color:red;'>Erro!</p>";
            }
        }
    }
}

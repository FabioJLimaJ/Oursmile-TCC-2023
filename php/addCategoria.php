<?php
require('conecta.php');

if (isset($_POST['cadastrar'])) {
    $_SESSION['msg'] = '';
    
    $stmt = $conn->prepare("INSERT INTO tb_categoria (nm_categoria) VALUES(:categoria)");
    $stmt->execute(array(
        ':categoria' => $_POST['nome_categoria']
    ));
        header("location: ../pag/listar_blogAdm.php");
}else{
    $_SESSION['msg'] = "error";
}
?>
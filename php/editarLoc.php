<?php
include('conecta.php');

$id = $_POST['id'];
$endereco = $_POST['endereco'];

try {
    // validar campos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $alterar = $conn->prepare("UPDATE tb_usuario SET nm_local = :endereco WHERE id = :id");
        $alterar->bindValue(':id', $id);
        $alterar->bindParam(':endereco', $endereco);

        $alterar->execute();
        $concluido = $alterar->rowCount();
        if ($concluido) {
            echo "alteração concluida";
            echo "
                <meta http-equiv='content-type' content='text/html; charset=UTF-8' />";
        } else{
            
        }
    } else {
        echo "formulario nao enviado";
    }
} catch (PDOException $e) {
    echo "Erro! " . $e->getMessage();
}

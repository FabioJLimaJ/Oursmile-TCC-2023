<?php
try {
        require('conecta.php');
        $stmt = $conn->prepare("INSERT INTO tb_usuario (nm_nome, nm_sobrenome, nm_email, ds_senha, id_nivel) VALUES(:nome, :sobrenome, :email, :senha, :nivel)");
        $stmt->execute(array(
            ':nome' => $_POST['nome'],
            ':sobrenome' => $_POST['sobrenome'],
            ':email' => $_POST['email'],
            ':senha' => $_POST['senha'],
            ':nivel' => $_POST['nivel']
        ));
       echo 'funciona';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
?>
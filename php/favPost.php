<?php
session_start();
if (isset($_SESSION['id_user'])) {
    require("conecta.php");
    
    $method = $_GET['method'];
    $user_id = $_GET['user_id'];
    $director_id = $_GET['director_id'];

    // Verifique se a publicação já está nos favoritos do usuário
    $query = "SELECT * FROM tb_favorito WHERE user_id= :usuario_id AND pub_id = :publicacao_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_id', $_SESSION['id_user']);
    $stmt->bindParam(':publicacao_id', $director_id);
    $stmt->execute();
    
    // Adicione a publicação aos favoritos do usuário
    if ($method == "Like") {
    $query = "INSERT INTO tb_favorito (user_id, pub_id) VALUES (:usuario_id, :publicacao_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_id', $_SESSION['id_user']);
    $stmt->bindParam(':publicacao_id', $director_id);
    $stmt->execute();
    }elseif ($method == "Unlike") {
    $deletar = $conn->prepare("DELETE FROM tb_favorito WHERE user_id = :user_id and pub_id = :pub_id");
    $deletar->bindParam(':user_id', $_SESSION['id_user']);
    $deletar->bindParam(':pub_id', $director_id);
    $deletar->execute();
    }
}

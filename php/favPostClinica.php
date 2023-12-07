    <?php
    session_start();
        require("conecta.php");
        $method = $_GET['method'];
        $director_id = $_GET['director_id'];

        // Verifique se a publicação já está nos favoritos do usuário
        $query = "SELECT * FROM tb_favorito WHERE user_id = :usuario_id AND clinica_id = :clinica_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':usuario_id', $_SESSION['id_user']);
        $stmt->bindParam(':clinica_id', $director_id);
        $stmt->execute();
        
        // Adicione a publicação aos favoritos do usuário
        if ($method == "Like") {
        $query = "INSERT INTO tb_favorito (user_id, clinica_id) VALUES (:usuario_id, :clinica_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':usuario_id', $_SESSION['id_user']);
        $stmt->bindParam(':clinica_id', $director_id);
        $stmt->execute();
        }elseif ($method == "Unlike") {
        $deletar = $conn->prepare("DELETE FROM tb_favorito WHERE user_id = :usuario_id AND clinica_id = :clinica_id");
        $deletar->bindParam(':usuario_id', $_SESSION['id_user']);
        $deletar->bindParam(':clinica_id', $director_id);
        $deletar->execute();
        }


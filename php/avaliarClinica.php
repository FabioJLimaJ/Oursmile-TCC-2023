<?php

session_start(); // Iniciar a sessão

// Incluir o arquivo com a conexão com o banco de dados
include_once 'conecta.php';

$id_clinica = $_POST['id_clinica'];

// Verificar se o usuário já avaliou a clínica
if (isset($_SESSION['avaliou_clinica'][$id_clinica]) && $_SESSION['avaliou_clinica'][$id_clinica]) {
    // Usuário já avaliou a clínica, exibir mensagem de erro
    echo "<p style='color: #f00;'>Você já avaliou esta clínica!</p>";
} else {
    // Definir fuso horário de São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    // Acessar o IF quando é selecionada pelo menos uma estrela
    if (!empty($_POST['estrela'])) {
        // Receber os dados do formulário
        $estrela = filter_input(INPUT_POST, 'estrela', FILTER_DEFAULT);
        $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_DEFAULT);
        $autor = filter_input(INPUT_POST, 'autor', FILTER_DEFAULT);

        // Criar a QUERY para cadastrar no banco de dados
        $query_avaliacao = "INSERT INTO tb_avaliacao (vl_nota, ds_mensagem, dt_criacao, nm_autor, id_clinica) VALUES (:nota, :mensagem, :created, :autor, :clinica)";
        $date = date("Y-m-d H:i:s");

        // Preparar a QUERY
        $cad_avaliacao = $conn->prepare($query_avaliacao);

        // Substituir os links pelos valores
        $cad_avaliacao->bindParam(':nota', $estrela, PDO::PARAM_INT);
        $cad_avaliacao->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
        $cad_avaliacao->bindParam(':autor', $autor, PDO::PARAM_STR);
        $cad_avaliacao->bindParam(':clinica', $id_clinica, PDO::PARAM_STR);
        $cad_avaliacao->bindParam(':created', $date);

        // Acessar o IF quando cadastrar corretamente
        if ($cad_avaliacao->execute()) {
            // Marcar que o usuário avaliou a clínica
            $_SESSION['avaliou_clinica'][$id_clinica] = true;

            // Criar a mensagem de sucesso
            echo "<p style='color: green;'>Avaliação cadastrada com sucesso!</p>";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            // Criar a mensagem de erro
            echo "<p style='color: #f00;'>Erro: Avaliação não cadastrada!</p>";
        }
    } else {
        // Criar a mensagem de erro
        echo "<p style='color: #f00;'>Necessário selecionar pelo menos 1 estrela.</p>";
    }
}
?>

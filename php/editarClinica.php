<?php
include('conecta.php');
$id = $_POST['id'];
$clinica = $_POST['clinica'];
$cro = $_POST['cro'];
$nomeDentista = $_POST['nomeDentista'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$zap = $_POST['zap'];
$horarioA = $_POST['horarioA'];
$horarioF = $_POST['horarioF'];
$email = $_POST['email'];
$tratamento = $_POST['tratamentos'];


try {
    // validar campos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $alterar = $conn->prepare("UPDATE tb_clinica SET nm_clinica = :clinica, nr_cro = :cro, nm_dentista = :dentista, nr_telefone = :telefone, nm_endereco = :endereco, nr_zap = :zap, hr_abri = :horaA, hr_fecha = :horaF, nm_email = :email, nm_tratamentos = :trat WHERE id = :id");
        $alterar->bindValue(':id', $id);
        $alterar->bindParam(':clinica', $clinica);
        $alterar->bindParam(':cro', $cro);
        $alterar->bindParam(':dentista', $nomeDentista);
        $alterar->bindParam(':telefone', $telefone);
        $alterar->bindParam(':endereco', $endereco);
        $alterar->bindParam(':zap', $zap);
        $alterar->bindParam(':horaA', $horarioA);
        $alterar->bindParam(':horaF', $horarioF);
        $alterar->bindParam(':email', $email);
        $alterar->bindParam(':trat', $tratamento);
        $alterar->execute();
        $concluido = $alterar->rowCount();
        if ($concluido) {
            echo "alteração concluida";
            echo "<script> window.location.href = '../pag/clinicas.php';</script>";
        } else {
        }
    } else {
        echo "formulario nao enviado";
    }
} catch (PDOException $e) {
    echo "Erro! " . $e->getMessage();
}

<?php
include_once('conecta.php');
$senha = $_POST['senha'];
$confirm = $_POST['senhaconfirm'];
$id = $_GET['id'];
// Função strlen() para calcular o número de caracteres do input
$numCaracteres = strlen($senha);
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
try {
	$dados = array_map('trim', $dados);
	// validar campos
	if (empty($_POST['senha'])) {
		echo "<p style='color: red;'>Insira uma nova senha!</p>";
}elseif (empty($_POST['senhaconfirm']))  {
		echo "<p style='color: red;'> Confirme a senha!</p>";
	}elseif ($senha != $confirm) {
		echo "<p style='color: red;'> As senhas não coincidem!</p>";
	} else {
		$alterar = $conn->prepare("UPDATE tb_usuario SET ds_senha =:senha WHERE id = :id");
		$alterar->bindParam(':senha', $senha);
		$alterar->bindValue(':id', $id);
		$alterar->execute();
		echo '<meta http-equiv="refresh" content="1">';
		echo "<p style='color:green;'> Senha alterada com sucesso!</p>";
	}
} catch (PDOException $e) {
	echo "Erro! " . $e->getMessage();
}

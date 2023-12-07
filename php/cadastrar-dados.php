<?php
require('conecta.php');

if ($_POST['nome'] == "" || $_POST['sobrenome'] == "" || $_POST['email'] == "" || $_POST['senha'] == "" || $_POST['endereco'] == "") {
        echo '  <div class="error">
        <div class="error__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z"></path></svg>
        </div>
        <div class="error__title"><strong>Erro: </strong>Campos vazios.</div>
        <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20"><path fill="#393a37" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path></svg></div>
    </div>';

    }else{

    $verifica = $conn->prepare("SELECT * FROM tb_usuario WHERE nm_email = '".$_POST['email']."'");
    $verifica-> execute();
    

    if($verifica->rowCount()>0){ 
        echo '	<div class="error">
        <div class="error__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z"></path></svg>
        </div>
        <div class="error__title"><strong>Erro: </strong>Email existente.</div>
        <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20"><path fill="#393a37" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path></svg></div>
    </div>';
    }else{
        try {
            $teste = '../imgPerfil/0/download.jpg';
                $stmt = $conn->prepare('INSERT INTO tb_usuario(ds_foto, nm_nome, nm_sobrenome, nm_email, ds_senha, nm_local, id_nivel) VALUES(:foto, :nome, :sobrenome, :email, :password, :endereco, :nivel)');
                $stmt->execute(array(
                    ':foto' => $teste,
                    ':nome' => $_POST['nome'],
                    ':sobrenome' => $_POST['sobrenome'],
                    ':email' => $_POST['email'],
                    ':password' => $_POST['senha'],
                    ':endereco' => $_POST['endereco'],
                    ':nivel' => $_POST['nivel'],
                ));

                $consulta = $conn->prepare("SELECT * FROM tb_usuario WHERE nm_email = '".$_POST['email']."' and ds_senha = '".$_POST['senha']."'" );
                $consulta-> execute();

                if($consulta->rowCount()>0){ 
                    session_start();
                    $result = $consulta->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['nivel'] = $result['id_nivel'];
                    $_SESSION['id_user'] = $result['id'];

                    
                    echo "<meta http-equiv='refresh' content='0'>";
                }
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();

        }
}
}
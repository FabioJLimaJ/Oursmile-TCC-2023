<?php
try {
        require('conecta.php');
        $arquivo = $_FILES['fotoClinica']['tmp_name'];
        $dir = '../imgClinica/';
        $_FILES['fotoClinica']['name'] = "img" . uniqid() . $_FILES['fotoClinica']['name'];
        $file = $_FILES['fotoClinica']['name'];
        $destino = $dir . $file;
        $extensao = $_FILES['fotoClinica'];
        $extensoes_permitidas = array('.jpg', '.png');

        if (!move_uploaded_file($arquivo, $destino)){
            echo "<p style='color: red;'>Insira uma imagem!</p>";
        }elseif( ($extensao['type'] != 'image/png') AND ($extensao['type'] != 'image/jpeg') ){
            echo "<p style='color:red;'>Os formatos de imagem aceitos são PNG e JPEG!</p>";
        }else{
        $stmt = $conn->prepare('INSERT INTO tb_clinica (ds_img, nm_clinica, nr_cro, nm_dentista, nr_telefone, nm_endereco, nr_zap, hr_abri, hr_fecha, nm_email, nm_tratamentos) VALUES(:fotoClinica, :clinica, :cro, :nomeDentista, :telefone, :endereco, :zap, :hrAbre, :hrFecha, :email, :tratamentos)');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->execute(array(
            ':fotoClinica' => $destino,
            ':clinica' => $_POST['clinica'],
            ':cro' => $_POST['cro'],
            ':nomeDentista' => $_POST['nomeDentista'],
            ':telefone' => $_POST['telefone'],
            ':endereco' => $_POST['endereco'],
            ':zap' => $_POST['zap'],
            ':hrAbre' => $_POST['horaEntrada'],
            ':hrFecha' => $_POST['horaSaida'],
            ':email' => $_POST['email'],
            ':tratamentos' => $_POST['tratamentos']
            
        ));
        echo  '	<div class="error">
        <div class="error__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg>        </div>
        <div class="error__title"><strong></strong>Clínica cadastrada.</div>
        <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20"><path fill=#393a37" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path></svg></div>
    </div>';

    echo '<script>window.location.href = "../pag/clinicas.php"</script>';
        
 }}catch(PDOException $e){
    echo '	<div class="error" style="background-color:#ef665b">
        <div class="error__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z"></path></svg>
        </div>
        <div class="error__title"><strong>Erro: </strong>Falha ao cadastrar clínica.</div>
        <div class="error__close"><svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20"><path fill="#393a37" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path></svg></div>
    </div>';
    }
?>
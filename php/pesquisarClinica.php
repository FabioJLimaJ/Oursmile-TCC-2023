<?php
    include('conecta.php');
    $stmt = $conn->prepare("SELECT * FROM tb_clinica where nm_clinica = '".$_POST['pesquisar']."'");
    $stmt-> execute();
   

    if($stmt->rowCount()!=0){ 
        echo "Clinica";

    }else{
    	
    }

?>
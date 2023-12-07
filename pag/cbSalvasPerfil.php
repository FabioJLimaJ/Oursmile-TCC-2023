<?php
session_start();
include('../php/conecta.php');
if (!isset($_SESSION['id_user'])) {
  header("location: ../index.php");
} else{
  $user = $_SESSION['id_user'];
  $stmt = $conn->prepare("SELECT * FROM tb_usuario WHERE id = '$user'");
  $stmt->execute();
  $stmt = $stmt->fetch();
  extract($stmt);

  $clinica = $conn->prepare("SELECT * FROM tb_clinica");
  $clinica->execute();
  $clinica_exibir = $clinica->fetch();
}

?>
<head>
<link rel="stylesheet" type="text/css" href="../sobreNós/assets/css/owl-carousel.css">
    <link rel="stylesheet" type="text/css" href="../sobreNós/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../sobreNós/assets/css/font-awesome.css">

</head>
<section class="section" id="services" >
        <div class="container" >
             
            <div class="row">
                <div class="owl-carousel owl-theme" >
                <?php
    // Consulta para buscar as publicações favoritadas pelo usuário
    $query = "SELECT * FROM tb_clinica JOIN tb_favorito ON tb_clinica.id = tb_favorito.clinica_id WHERE tb_favorito.user_id = :usuario_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_id', $_SESSION['id_user']);
    $stmt->execute();
    $lines = $stmt->rowCount();
    if($lines>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    ?>
                    <div class="item service-item" style="cursor:auto;">
         <center>
                    <img src="https://pbs.twimg.com/profile_images/1720238990383542272/rVBCG164_400x400.jpg" style="width:10rem; border-radius:50%;margin-bottom:10rem;">
<br><br><br>
                        <h5 class="service-title"><?php echo $row['nm_clinica'];?></h5>
                        
                        <p>Front-end | Back-end</p>

                    </div>
                    <?php
    }
  }else{
    echo "Sem clínicas favoritadas!";
  }
?>
                    
                   
                   
                </div>
            </div>
        </div>
    </section>
    <script src="../sobreNós/assets/js/jquery-2.1.0.min.js"></script>

<!-- Bootstrap -->



<!-- Plugins -->
<script src="../sobreNós/assets/js/owl-carousel.js"></script>
<script src="../sobreNós/assets/js/scrollreveal.min.js"></script>




<!-- Global Init -->
<script src="../sobreNós/assets/js/custom.js"></script>
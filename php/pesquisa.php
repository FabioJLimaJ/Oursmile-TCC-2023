<?php
  include('conecta.php');
// % pode indicar valor antes ou depois
  $pesq = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  if(!empty($pesq['pesquisar'])){
  $titulo = "%".$pesq['busca']."%";
  $query_postagem = "SELECT id, nm_postagem FROM tb_blog WHERE nm_postagem like :titulo ORDER BY nm_postagem ASC";
  $result_postagem = $conn->prepare($query_postagem);
  $result_postagem->bindParam(':titulo', $titulo);
  $result_postagem->execute();

  while($row_post = $result_postagem->fetch(PDO::FETCH_ASSOC)){
    extract($row_post);
    echo $row_post['nm_postagem'];
    }
  }
  
  ?>
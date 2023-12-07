<?php

include('../php/conecta.php');
if (isset($_SESSION['id_user'])) {
  header("location: ../index.php");
}
?>
<head>


<link href="../index/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="../index/assets/css/templatemo-chain-app-dev.css">
    <link rel="stylesheet" href="../index/assets/css/animated.css">
    <link rel="stylesheet" href="../index/assets/css/owl.css">
    <style>
      /* The Modal (background) */
.modal{
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 20rem; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  position:relative;
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.bS {
width:6rem;
padding:0.5rem;
  border: 0;
  border-radius: 100px;
  background-color: #2ba8fb;
  color: #ffffff;
  font-weight: Bold;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
}

.bS:hover {
  background-color: #6fc5ff;
  box-shadow: 0 0 20px #6fc5ff50;
  transform: scale(1.1);
}

.bS:active {
  background-color: #3d94cf;
  transition: all 0.25s;
  -webkit-transition: all 0.25s;
  box-shadow: none;
  transform: scale(0.98);
}
    </style>
</head>

<header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s" style="background-color:#Ffff;">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="../index.php" class="logo">
              <img src="../img/logoHorizontal.png" style="width:14rem;" id="logo">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">

              <li class="scroll-to-section"><a href="blog.php">Blog</a></li>
              <li class="scroll-to-section"><a href="../pag/clinicas.php">Clínicas</a></li>
 



         
<li class="scroll-to-section" style="display:none;"><a href=""></a></li>
            </ul>        
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
 
  <script src="../index/vendor/jquery/jquery.min.js"></script>
  <script src="../index/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../index/assets/js/owl-carousel.js"></script>
  <script src="../index/assets/js/animation.js"></script>
  <script src="../index/assets/js/imagesloaded.js"></script>
  
  <script src="../index/assets/js/custom.js"></script>
<script>
  var modal = document.getElementById("modal");

// Get the button that opens the modal
var btn = document.getElementById("btnSair");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
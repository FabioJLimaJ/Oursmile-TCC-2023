// var modal
var modal = document.getElementById("myModal");

// var botão
var btn = document.getElementById("myBtn");

var salvar = document.getElementById("salvarPub");

// <span> para fechar modal
var span = document.getElementsByClassName("close")[0];

// button cancelar
var btnClose = document.getElementsByClassName("close-btn")[0];

// ação clique no botão para abrir modal
btn.onclick = function() {
  modal.style.display = "block";
}

// x para fechar modal
span.onclick = function() {
  modal.style.display = "none";
}

// botão cancelar
btnClose.onclick = function() {
  modal.style.display = "none";
}

var modal2 = document.getElementById("myModal2");

var btn2 = document.getElementById("myBtn2");

// Get the <span> element that closes the modal
var span2 = document.getElementsByClassName("close2")[0];

// When the user clicks the button, open the modal 
btn2.onclick = function() {
  modal2.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span2.onclick = function() {
  modal2.style.display = "none";
}






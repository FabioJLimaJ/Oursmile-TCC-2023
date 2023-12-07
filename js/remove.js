// MODAL DE CONFIRMAÇÃO DE EXCLUSÃO

const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const apagar = document.getElementById("myModal2");

openModalBtn.addEventListener("click", () => {
  apagar.style.display = "flex";
});

closeModalBtn.addEventListener("click", () => {
  apagar.style.display = "none";
});
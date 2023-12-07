// preview da imagem
const input = document.querySelector("#previewImg");
// quando o usuário inserir a imagem
input.addEventListener("change", function(e){
    const tgt = e.target || window.event.srcElement;
    const files = tgt.files;
    const fr = new FileReader();
    
    fr.onload = function(){
        document.querySelector("#imagem-p").src = fr.result;
    }
    fr.readAsDataURL(files[0]);

})
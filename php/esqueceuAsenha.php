<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <title>Cadastro</title>
    <style>
        button {
 appearance: button;
 background-color: #1899D6;
 border: solid transparent;
 border-radius: 16px;
 border-width: 0 0 4px;
 box-sizing: border-box;
 color: #FFFFFF;
 cursor: pointer;
 display: inline-block;
 font-size: 15px;
 font-weight: 700;
 letter-spacing: .8px;
 line-height: 20px;
 margin: 0;
 outline: none;
 overflow: visible;
 padding: 13px 19px;
 text-align: center;
 text-transform: uppercase;
 touch-action: manipulation;
 transform: translateZ(0);
 transition: filter .2s;
 user-select: none;
 -webkit-user-select: none;
 vertical-align: middle;
 white-space: nowrap;
}

button:after {
 background-clip: padding-box;
 background-color: #1CB0F6;
 border: solid transparent;
 border-radius: 16px;
 border-width: 0 0 4px;
 bottom: -4px;
 content: "";
 left: 0;
 position: absolute;
 right: 0;
 top: 0;
 z-index: -1;
}

button:main, button:focus {
 user-select: auto;
}

button:hover:not(:disabled) {
 filter: brightness(1.1);
}

button:disabled {
 cursor: auto;
}

button:active:after {
 border-width: 0 0 0px;
}

button:active {
 padding-bottom: 10px;
}
.section{
    display:grid;
    justify-content:center;
    
    align-items:center;
    place-items:center;
 
}

    </style>
</head>
<body>
  <br><br>
    <center>

    <h1>Send Email</h1>
    Sender Name
    <input type="text" id="sendername"> <br>
    To (Email)
    <input type="text" id="to" value="fabinho.felipe456@gmail.com"><br>
    Subject
    <input type="text" id="subject"> <br>
    Reply To (Email)
    <input type="text" id="replyto"> <br>
    Message <br>
    <textarea id="message" cols="40" rows="8" name="codigo"></textarea> <br>
    <button onclick = "sendMail();">enviar</button>



</center>


<center><p id="resp"></p></center>

 <script>
function loadForm(){
    var loginForm = document.querySelector('form'); //Selecting the form
    loginForm.addEventListener('submit', login);    //looking for submit
}

function login(e){
    e.preventDefault(); //to stop form action i.e. submit
}

var bots = Math.floor(Math.random() * 20)
var botss = Math.floor(Math.random() * 50)


var number = document.querySelector("#message");
number.value = (bots) + (botss);
      function sendMail(){
        
        (function(){
          emailjs.init("T7idnMrrNcumypxec"); // Account Public Key
        })();

        var params = {
          sendername: document.querySelector("#sendername").value,
          to: document.querySelector("#to").value,
          subject: document.querySelector("#subject").value,
          replyto: document.querySelector("#replyto").value,
          message: document.querySelector("#message").value,
        };

        var serviceID = "service_uxwgxdi"; // Email Service ID
        var templateID = "template_95zzxpm"; // Email Template ID

        emailjs.send(serviceID, templateID, params)
        .then( res => {
            alert("Email sent successfully!!");
            
        })
        .catch();
      }

    </script>
</body>
</html>
const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");
const sendBtn = form.querySelector("button");
const chatBox = document.querySelector('.chat-box');

form.onsubmit = (e) => {
    e.preventDefault();
}

sendBtn.onclick = () => {
    // Requête AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            inputField.value = ""; //Une fois le message envoyé on remet le champ message vide
            scrollToBottom();
        }
    }
    // On envoie les données du formulaire d'AJAX à PHP
    let formData = new FormData(form); //On instancie un objet formData 
    xhr.send(formData); //On envoie les données du formulaire dans le fichier PHP
}

chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}
chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() => {
    // Requête AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            let data = xhr.response;
            chatBox.innerHTML = data;
            if (!chatBox.classList.contains('active')) {
                scrollToBottom();
            }
        }
    }

    let formData = new FormData(form); //On instancie un objet formData 
    xhr.send(formData); //On envoie les données du formulaire dans le fichier PHP
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}
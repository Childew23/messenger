const form = document.querySelector(".connexion form");
const continueBtn = form.querySelector(".button input");
const errorText = document.querySelector('.error-txt');

form.onsubmit = (e) => {
    e.preventDefault();
}

continueBtn.onclick = () => {
    // Requête AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            let data = xhr.response;
            console.log(data);
            if (data == "success"){
                location.href = "users.php";
            }else{
                errorText.textContent = data;
                errorText.style.display = 'block'; 
            }
        }
    }
    // On envoie les données du formulaire d'AJAX à PHP
    let formData = new FormData(form); //On instancie un objet formData 
    xhr.send(formData); //On envoie les données du formulaire dans le fichier PHP
}
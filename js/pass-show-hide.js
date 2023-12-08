// Affiche ou cache le mot de passe
const pwdField = document.querySelector(".form input[type='password']");
let toggleBtn = document.querySelector(".form .field i");

toggleBtn.onclick = () => {
    if (pwdField.type == "password") {
        pwdField.type = "text";
        toggleBtn.classList.add("active");
    } else {
        pwdField.type = "password";
        toggleBtn.classList.remove("active");
    }
}
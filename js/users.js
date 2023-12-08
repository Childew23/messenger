// Change la barre de recherche
const searchBar = document.querySelector(".users .search input");
searchBtn = document.querySelector(".users .search button");

searchBtn.onclick = () => {
    searchBar.classList.toggle('active');
    searchBar.focus();
    searchBtn.classList.toggle('active');
    searchBar.value = "";
}

searchBar.onkeyup = () => {
    let xhr = new XMLHttpRequest();
    let searchTerm = searchBar.value;
    if (searchTerm != '') {
        searchBar.classList.add("active");
    }else{
        searchBar.classList.remove("active");
    }
    xhr.open("POST", "php/search.php", true);
    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            let data = xhr.response;
            document.querySelector('.users-list').innerHTML = data;
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}

setInterval(() => {
    // Requête AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php/users.php", true);
    xhr.onload = () => {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            let data = xhr.response;
            if (!searchBar.classList.contains("active")) { //Si on utilise pas la barre de recherche ça va rechercher tous les utilisateurs connecté
                document.querySelector('.users-list').innerHTML = data;
            }
        }
    }
    xhr.send();
}, 500);
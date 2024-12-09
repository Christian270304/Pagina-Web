document.addEventListener('DOMContentLoaded', function() {
    loadPage(1, 6); // Cargar la primera página con 6 artículos por defecto

    document.getElementById('articlesPerPage').addEventListener('change', function() {
        const articlesPerPage = this.value;
        loadPage(1, articlesPerPage); // Cargar la primera página con el nuevo número de artículos por página
    });

    // Manejar el evento de clic en el botón "Inicio"
    document.getElementById('showAllArticles').addEventListener('click', function() {
        loadPage(1, 6, true); // Cargar la primera página con 6 artículos por defecto
    });

    document.getElementById('showMyArticles').addEventListener('click', function() {
        loadPage(1, 6, false); // Cargar la primera página con 6 artículos por defecto
    });

    // Modal functionality
    var modal = document.getElementById("articleModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Welcome Popup functionality
    var welcomePopup = document.getElementById("welcomePopup");
    if (welcomePopup) {
        welcomePopup.style.display = "block";
        var closeWelcome = document.getElementsByClassName("close-welcome")[0];

        closeWelcome.onclick = function() {
            welcomePopup.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == welcomePopup) {
                welcomePopup.style.display = "none";
            }
        }
    }
    // Mostrar popup debajo del botón si el usuario ha iniciado sesión
    var userLoggedIn = true; // Cambia esto según tu lógica de sesión
    if (userLoggedIn) {
        var popup = document.getElementById('welcomePopup');
        var button = document.getElementById('Inici');
        var rect = button.getBoundingClientRect();
        popup.style.top = rect.bottom + 'px';
        popup.style.left = rect.left + 'px';
        popup.style.display = 'block';
    }

    document.querySelector('.close-welcome').addEventListener('click', function() {
        document.getElementById('welcomePopup').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        var popup = document.getElementById('welcomePopup');
        if (event.target !== popup && !popup.contains(event.target) && event.target !== document.getElementById('popupButton')) {
            popup.style.display = 'none';
        }
    });
});

function loadPage(page, articlesPerPage, loadAll = false) {
    const url = `/ajax/load_articles.php?page=${page}&articlesPerPage=${articlesPerPage}` + (loadAll ? '&all=true' : '');
    fetch(url)
        .then(response => response.json())
        .then(data => {
            document.getElementById('articlesContainer').innerHTML = data.articles;
            document.getElementById('paginationContainer').innerHTML = data.pagination;
        })
        .catch(error => console.error('Error:', error));
}

function readArticle(articleId) {
    fetch(`/ajax/read_article.php?id=${articleId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalArticleContent').innerHTML = `
                <img src="${data.image}" alt="Imatge Article">
                <h2>${data.title}</h2>
                <p>${data.content}</p>
            `;
            var modal = document.getElementById("articleModal");
            modal.style.display = "block";
        })
        .catch(error => console.error('Error:', error));
}
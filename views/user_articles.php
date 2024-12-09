<!DOCTYPE html>
<html lang="cat">

<head>
    <title>Mis Artículos</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h2>Mis Artículos</h2>
        <div id="userArticlesContainer" class="content"></div>
        <div id="userPaginationContainer" class="pagination"></div>
    </div>
    <script src="/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadUserArticles(1, 6); // Cargar la primera página con 6 artículos por defecto

            document.getElementById('articlesPerPage').addEventListener('change', function() {
                const articlesPerPage = this.value;
                loadUserArticles(1, articlesPerPage); // Cargar la primera página con el nuevo número de artículos por página
            });
        });

        function loadUserArticles(page, articlesPerPage) {
            fetch(`/ajax/load_user_articles.php?page=${page}&articlesPerPage=${articlesPerPage}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('userArticlesContainer').innerHTML = data.articles;
                    document.getElementById('userPaginationContainer').innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>
<?php
if (isset($_SESSION['welcome_shown'])) {
    $_SESSION['welcome_shown'] = false;
    $showWelcomePopup = true;
} else {
    $showWelcomePopup = false;
}

?>
<!DOCTYPE html>
<html lang="cat">

<head>
    <title>F1-Articles</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <a href="/">
                    <img src="images/favicon.png" alt="Logotip de la pàgina">
                </a>
            </div>
            <?php if (isset($_SESSION['username'])): ?>
                <div id="Inici">
                    <a href="#" id="showAllArticles" >Inici</a>
                </div>
                <div>
                    <a href="#" id="showMyArticles" >My Articles</a>
                </div>
                <div class="add-article">
                    <button onclick="addArticle()">Añadir Artículo</button>
                </div>
                <?php endif; ?>
            <div class="search-bar">
                <input placeholder="Search..." type="text" />
            </div>

            <div class="articles-per-page">
                <label for="articlesPerPage">Artículos por página:</label>
                <input type="number" id="articlesPerPage" value="6" min="1" placeholder="Articles per pàgina">
            </div>
            <div class="sort-buttons">
                <button id="sortAsc">A-Z</button>
                <button id="sortDesc">Z-A</button>
            </div>
            
            <div class="user-icon">
                <label for="dropdown">
                    <img src="images/profile-user-account.svg" alt="User Icon" id="userIcon">
                </label>
                <input hidden class="dropdown" type="checkbox" id="dropdown" name="dropdown" />
                <div class="section-dropdown">
                <?php if (isset($_SESSION['username'])): ?>
                        <a href="/profile">Perfil <i class="uil uil-arrow-right"></i></a>
                        <?php if ($_SESSION['username'] === "admin"): ?>
                            <a href="/admin">Admin <i class="uil uil-arrow-right"></i></a>
                        <?php endif; ?>
                        <a href="/logout">Tancar Sessió <i class="uil uil-arrow-right"></i></a>
                    <?php else: ?>
                        <a href="/login">Iniciar Sessió <i class="uil uil-arrow-right"></i></a>
                        <a href="/signup">Crear Compte <i class="uil uil-arrow-right"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        
    
        </div>

        <div class="content" id="articlesContainer"></div>
        <div class="pagination" id="paginationContainer"></div>
    </div>
    <!-- Modal -->
    <div id="articleModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalArticleContent"></div>
        </div>
    </div>

    <!-- Welcome Popup -->
    <?php if ($showWelcomePopup): ?>
    <div id="welcomePopup" class="welcome-popup">
        <div class="welcome-popup-content">
            <span class="close-welcome">&times;</span>
            <h2>Bienvenido</h2>
            <p>Haz clic en "Inici" para ver todos los artículos.</p>
        </div>
    </div>
    <?php endif; ?>

    <script src="js/main.js"></script>
</body>

</html>
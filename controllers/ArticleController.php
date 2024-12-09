<?php
require 'models/Article.php';

class ArticleController {
    public function create() {
        // Lógica para crear un artículo
        //include 'views/create_article.php';
    }

    public function userArticles($page = 1, $articlesPerPage = 6) {
        
        if (!isset($_SESSION['username'])) {
            header('Location: /login');
            exit;
        }

        
        $articleModel = new Article();
        $userId = $articleModel->getIdByUser($_SESSION['username']);
        $offset = ($page - 1) * $articlesPerPage;
        $articles = $articleModel->getUserArticles($userId, $articlesPerPage, $offset);
        $totalArticles = $articleModel->getTotalUserArticles($userId);
        $totalPages = ceil($totalArticles / $articlesPerPage);

        ob_start();
        include 'views/articles.php';
        $articlesHtml = ob_get_clean();

        ob_start();
        include 'views/pagination.php';
        $paginationHtml = ob_get_clean();

        echo json_encode([
            'articles' => $articlesHtml,
            'pagination' => $paginationHtml,
        ]);
    }

    
}
?>
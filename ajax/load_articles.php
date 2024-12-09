<?php
require_once '../config/config.php';
require_once BASE_PATH . 'models/Article.php';

session_start();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$articlesPerPage = isset($_GET['articlesPerPage']) ? (int)$_GET['articlesPerPage'] : 6;
$loadAll = isset($_GET['all']) ? (bool)$_GET['all'] : false;

$articleModel = new Article();
$offset = ($page - 1) * $articlesPerPage;

if (!$loadAll && isset($_SESSION['username'])) {
    $userId = $articleModel->getIdByUser($_SESSION['username']);
    $articles = $articleModel->getUserArticles($userId, $articlesPerPage, $offset);
    $totalArticles = $articleModel->getTotalUserArticles($userId);
} else {
    $articles = $articleModel->getArticles($articlesPerPage, $offset);
    $totalArticles = $articleModel->getTotalArticles();
}

$totalPages = ceil($totalArticles / $articlesPerPage);

ob_start();
include BASE_PATH . 'views/articles.php';
$articlesHtml = ob_get_clean();

ob_start();
include BASE_PATH . 'views/pagination.php';
$paginationHtml = ob_get_clean();

echo json_encode([
    'articles' => $articlesHtml,
    'pagination' => $paginationHtml,
]);
?>
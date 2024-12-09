<?php
require_once '../config/config.php';
require_once BASE_PATH . 'models/Article.php';

$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$articleModel = new Article();
$article = $articleModel->getArticleById($articleId);

if ($article) {
    echo json_encode([
        'image' => $article['ruta_imagen'],
        'title' => $article['titol'],
        'content' => $article['cos']
    ]);
} else {
    echo json_encode(['error' => 'Artículo no encontrado']);
}
?>
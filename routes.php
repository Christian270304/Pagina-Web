<?php
require_once 'config/config.php';
require 'controllers/UserController.php';
require 'controllers/ArticleController.php';

class App {
    public function run($uri) {
        $uri = trim($uri, '/');
        $segments = explode('/', $uri);
        switch ($segments[0]) {
            case 'create-article':
                $controller = new ArticleController();
                $controller->create();
                break;
            case 'user_articles':
                include 'views/user_articles.php';
                break;
            case 'login':
                $controller = new UserController();
                $controller->login();
                break;
            case 'signup':
                $controller = new UserController();
                $controller->signup();
                break;
            case 'profile':
                $controller = new UserController();
                $controller->profile();
                break;
            case 'logout':
                $controller = new UserController();
                $controller->logout();
                break;
            case 'error':
                include 'views/error.php';
                break;
            case '':
                include 'home.php';
                break;
            default:
                include 'home.php';
                break;
        }
    }
}
?>
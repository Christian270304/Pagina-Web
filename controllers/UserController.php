<?php
require 'models/User.php';

class UserController {
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repitPassword = $_POST['repitPassword'];
            if ($username == "") {
                $errors[] = "El camp de l'usuari és obligatori";
            }
            if ($password == "") {
                $errors[] = "El camp de la contrasenya és obligatori";
            }
            // Validar los datos
            $errors = $this->validate($username, $email, $password, $repitPassword);

            if (empty($errors)) {
                $userModel = new User();
                if ($userModel->register($username,$email, $password)) {
                    // Registro exitoso
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['welcome_shown'] = true;
                    header('Location: /');
                } else {
                    // Error al registrar el usuario
                    $errors[] = "Error al registrar el usuario.";
                }
            }

            // Mostrar errores
            include 'views/signup.php';
        } else {
            include 'views/signup.php';
        }
    }

    public function profile() {
        if (!isset($_SESSION['username'])) {
            header('Location: /login');
            exit;
        }
        $userModel = new User();
        $userId = $userModel->getUserId($_SESSION['username']);
        $user = $userModel->getUser($userId);
        include 'views/profile.php';
    }

    private function validate($username, $email, $password, $repitPassword) {
        $errors = [];

        if (empty($username)) {
            $errors[] = "El nomb d'usuario és obligatori";
        }
        if (empty($email)) {
            $errors[] = "El camp del correu electrònic és obligatori";
        }

        if (empty($password)) {
            $errors[] = "La contrasenya és obligatòria";
        } else if (empty($repitPassword)) {
            $errors[] = "Si us plau repeteixi la contrasenya";
        }

        return $errors;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $username = $_POST['username'];
            $password = $_POST['password'];
            if ($username == "") {
                $errors[] = "El camp de l'usuari és obligatori";
            }
            if ($password == "") {
                $errors[] = "El camp de la contrasenya és obligatori";
            }

            if (empty($errors)) {
                $userModel = new User();
                if ($userModel->authenticate($username, $password)) {
                    // Iniciar sesión
                    session_start();
                    $_SESSION['username'] = $username;
                    header('Location: /');
                } else {
                    $errors[] = "El nom d'usuari o la contrasenya són incorrectes";
                    
                }
            }
            if (!empty($errors)) {
                include 'views/login.php';
            }
        } else {
            include 'views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        session_unset();
        header('Location: /');
    }
}
?>
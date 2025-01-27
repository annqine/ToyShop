<?php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Cart.php';
class UserController extends Controller{
 
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        $cartModel = new Cart();
        if (isset($_SESSION['user_id'])) {
            $cartModel->clearCart($_SESSION['user_id']);
        }

        header('Location: /login');
        exit;
    }
    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'];
            $password = $_POST['password'];
            $userModel = new User;
            $user = $userModel->authenticate($username, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                if ($user['is_admin']) {
                    header('Location: /admin');
                } else {
                    header('Location: /');
                }
                exit;
            } else {
                $this->view('login', ['error' => 'Неправильное имя пользователя или пароль']);
            }
        } else {
            $this->view('login');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new User;

            if ($userModel->userExists($username)) {
                $this->view('register', ['error' => 'Пользователь с таким именем уже существует']);
            } else {
                if ($userModel->register($username, $password)) {
                    header('Location: /login');
                    exit;
                } else {
                    $this->view('register', ['error' => 'Регистрация не удалась']);
                }
            }
        } else {
            $this->view('register');
        }
    }


}
?>
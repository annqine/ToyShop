<?php

use Core\Pagination;
use Core\Request;

require_once __DIR__ . '/../Models/Toy.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Cart.php';
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Pagination.php';
require_once __DIR__ . '/../Core/FileUploader.php';

class HomeController extends Controller
{
    public function index()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rows = isset($_GET['rows']) ? intval($_GET['rows']) : 10;
        $sidx = isset($_GET['sidx']) ? $_GET['sidx'] : 'id';
        $sord = isset($_GET['sord']) ? $_GET['sord'] : 'asc';
        $category = isset($_GET['category']) ? intval($_GET['category']) : null;
        $query = isset($_GET['query']) ? $_GET['query'] : null;

        $query = Request::get('query');
        $category = Request::get('category');

        $model = new Toy();
        $response = $model->getAllToys($category, $query, $page, $rows, $sidx, $sord);
        $this->view('home', [
            'data' => $response['data'],
            'page' => $page,
            'total' => $response['total'],
            'records' => count($response['data']),
            'rows' => $rows,
            'sidx' => $sidx,
            'sord' => $sord,
            'category' => $category,
            'query' => $query
        ]);
    }
    public function addToCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $toyId = $_POST['toy_id'];
        $quantity = $_POST['quantity'];

        $cartModel = new Cart();
        $cartModel->addToCart($userId, $toyId, $quantity);

        header('Location: /cart');
        exit;
    }
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }


    public function cart()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->view('login', ['error' => 'Пожалуйста, авторизуйтесь для доступа к корзине']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $cartModel = new Cart();
        $cartItems = $cartModel->getCart($userId);

        $this->view('cart', ['cartItems' => $cartItems]);
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


    public function admin()
    {
        $toyModel = new Toy();
        $toys = $toyModel->getAllToys();
        $this->view('admin', ['toys' => $toys]);
    }

    public function toys()
    {
        $pagination = new Pagination();

        $page = $_GET['page'] ?? 1;
        $rows = $_GET['rows'] ?? 10;
        $sidx = $_GET['sidx'] ?? 'id';
        $sord = $_GET['sord'] ?? 'asc';
        $category = $_GET['category'] ?? null; // Новое поле для фильтрации по категории

        $query = "SELECT t.*, CONCAT('/images/', i.filename) AS photo_url 
                  FROM all_toys t
                  LEFT JOIN images i ON t.id_photo = i.id";

        if ($category !== null) {
            $query .= " WHERE t.category = :category";
        }

        $response = $pagination->paginate($query, "all_toys", $page, $rows, $sidx, $sord, $category);

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function toysEdit()
    {
        $toyModel = new Toy();
        $name = Request::post('name_toys');
        $id = Request::post('toysTable_id');
        $price = Request::post('price');
        $category = Request::post('category'); // Новый параметр для категории

        if (Request::post('oper') == 'add' && !empty($_FILES)) {
            $toyModel->add($name, $price, $category, $_FILES['file']);
        } elseif (Request::post('oper') == 'edit' && $id) {
            $toyModel->edit($id, $name, $price, $category, $_FILES['file']);
        } elseif (Request::post('oper') == 'del' && Request::post('id')) {
            $toyModel->remove(Request::post('id'));
        }
    }
}
?>
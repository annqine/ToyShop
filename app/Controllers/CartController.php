<?php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Cart.php';
class CartController extends Controller{
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

    public function removeFromCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $toyId = $_POST['remove'];

        $cartModel = new Cart();
        $cartModel->removeFromCart($userId, $toyId);

        header('Location: /cart');
        exit;
    }


}
?>
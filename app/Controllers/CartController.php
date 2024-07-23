<?php
require_once '../models/CartModel.php';
// class CartController {
//     public function addToCart($toyId, $quantity = 1) {
//         // Вызываем метод модели для добавления товара в корзину
//         CartModel::addToCart($toyId, $quantity);
//         // Перенаправляем пользователя обратно на страницу, с которой был отправлен запрос
//         header("Location: {$_SERVER['HTTP_REFERER']}");
//         exit;
//     }

//     public function removeFromCart($toyId) {
//         // Вызываем метод модели для удаления товара из корзины
//         CartModel::removeFromCart($toyId);
//         // Перенаправляем пользователя обратно на страницу, с которой был отправлен запрос
//         header("Location: {$_SERVER['HTTP_REFERER']}");
//         exit;
//     }

//     public function clearCart() {
//         // Вызываем метод модели для очистки корзины
//         CartModel::clearCart();
//         // Перенаправляем пользователя обратно на страницу, с которой был отправлен запрос
//         header("Location: {$_SERVER['HTTP_REFERER']}");
//         exit;
//     }

//     public function viewCart() {
//         // Получаем содержимое корзины из модели
//         $cartContents = CartModel::getCartContents();
//         // Загружаем представление корзины
//         require_once '../views/cart.php';
//     }
// }
?>
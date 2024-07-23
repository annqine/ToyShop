<?php

class CartModel {
    // Метод для добавления товара в корзину
    public static function addToCart($toyId, $quantity = 1) {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Если товар уже есть в корзине, увеличиваем его количество
        if (array_key_exists($toyId, $_SESSION['cart'])) {
            $_SESSION['cart'][$toyId] += $quantity;
        } else {
            $_SESSION['cart'][$toyId] = $quantity;
        }
    }

    // Метод для удаления товара из корзины
    public static function removeFromCart($toyId) {

        if (isset($_SESSION['cart'][$toyId])) {
            unset($_SESSION['cart'][$toyId]);
        }
    }

    // Метод для очистки корзины
    public static function clearCart() {

        $_SESSION['cart'] = array();
    }

    // Метод для получения содержимого корзины
    public static function getCartContents() {

        return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    }
}
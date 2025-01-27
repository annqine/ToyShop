<?php
// require_once 'app/Core/Route.php';

// Route::start(); // Запускаем маршрутизацию

require_once 'app/Core/Route.php';

session_start();
Route::clear();

// Добавляем маршруты
Route::add('GET', '', 'HomeController@index'); // Главная страница
Route::add('GET', 'search', 'HomeController@index'); // Главная страница

Route::add('GET', 'toys', 'AdminController@toys'); // Админка
Route::add('GET', 'admin', 'AdminController@admin'); // Админка
Route::add('POST', 'toysEdit', 'AdminController@toysEdit'); // Админка

Route::add('GET', 'login', 'UserController@login');
Route::add('POST', 'login', 'UserController@login');
Route::add('GET', 'register', 'UserController@register');
Route::add('POST', 'register', 'UserController@register');
Route::add('GET', 'logout', 'UserController@logout');

Route::add('POST', 'addToCart', 'CartController@addToCart');
Route::add('GET', 'cart', 'CartController@cart');
Route::add('POST', 'cart/remove', 'CartController@removeFromCart');


// Запуск маршрутизатора
Route::start();

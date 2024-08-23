<?php
// require_once 'app/Core/Route.php';

// Route::start(); // Запускаем маршрутизацию

require_once 'app/Core/Route.php';

session_start();

// Добавляем маршруты
Route::add('GET', '', 'HomeController@index'); // Главная страница
Route::add('GET', 'admin', 'HomeController@admin'); // Админка
Route::add('GET', 'toys', 'HomeController@toys'); // Админка
Route::add('POST', 'toysEdit', 'HomeController@toysEdit'); // Админка
Route::add('GET', 'search', 'HomeController@index'); // Главная страница
Route::add('GET', 'login', 'HomeController@login');
Route::add('POST', 'login', 'HomeController@login');
Route::add('GET', 'register', 'HomeController@register');
Route::add('POST', 'register', 'HomeController@register');
Route::add('GET', 'logout', 'HomeController@logout');
Route::add('POST', 'addToCart', 'HomeController@addToCart');
Route::add('GET', 'cart', 'HomeController@cart');


// Запуск маршрутизатора
Route::start();

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

// Запуск маршрутизатора
Route::start();

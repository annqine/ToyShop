<?php
//Singleton
class Config
{
    // Статическая переменная для хранения единственного экземпляра
    private static $instance = null;

    // Константы для конфигурации
    const DB_HOST = 'localhost';
    const DB_NAME = 'index';
    const DB_USER = 'root';
    const DB_PASS = '';

    // Приватный конструктор, чтобы запретить создание объектов извне
    private function __construct() {}

    // Приватный метод для предотвращения клонирования
    private function __clone() {}

    // Статический метод для получения экземпляра класса
    public static function getInstance()
    {
        // Если экземпляр еще не существует, создаем его
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    // Метод для получения DSN для подключения к базе данных
    public static function getDSN()
    {
        return 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME;
    }
}
?>
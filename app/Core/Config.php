<?php
class Config
{
    const DB_HOST = 'localhost';
    const DB_NAME = 'index';
    const DB_USER = 'root';
    const DB_PASS = '';

    public static function getDSN()
    {
        return 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME;
    }
}
?>
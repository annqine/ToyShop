<?php
require_once 'Config.php';

class Model
{
	protected $db;

	public function __construct()
	{
		try {
			$this->db = new PDO(Config::getDSN(), Config::DB_USER, Config::DB_PASS);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die('Database Connection Error: ' . $e->getMessage());
		}
	}
}
class ModelFactory
{
    // Фабричный метод для создания объектов моделей
    public static function create(string $modelName): Model
    {
        $modelClass = ucfirst($modelName);

        $modelFile = __DIR__ . "/../Models/{$modelClass}.php";

        // Проверяем, существует ли файл модели
        if (!file_exists($modelFile)) {
            throw new Exception("Model file not found: {$modelFile}");
        }

        require_once $modelFile;

        // Проверяем, существует ли класс модели
        if (!class_exists($modelClass)) {
            throw new Exception("Model class not found: {$modelClass}");
        }

        return new $modelClass();
    }
}

// require_once 'app/Core/ModelFactory.php';

// try {
//     // Создаем объект модели через фабрику
//     $cartModel = ModelFactory::create('Cart');
//     $items = $cartModel->getItems();

//     print_r($items);
// } catch (Exception $e) {
//     echo 'Error: ' . $e->getMessage();
// }
?>

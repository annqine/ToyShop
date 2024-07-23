<?php
class Route
{
	private static $routes = array(); // Используем array() для совместимости

	public static function add($method, $uri, $action)
	{
		self::$routes[] = array( // Используем array() для совместимости
			'method' => strtoupper($method),
			'uri' => trim($uri, '/'),
			'action' => $action
		);
	}

	public static function start()
	{
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$uri = trim($_SERVER['REQUEST_URI'], '/');

		// Убираем параметры запроса из URI, если они есть
		$uriParts = explode('?', $uri);
		$uri = $uriParts[0];

		foreach (self::$routes as $route) {
			if ($route['method'] === $requestMethod && $route['uri'] === $uri) {
				list($controllerName, $actionName) = explode('@', $route['action']);
				$controllerFile = realpath(__DIR__ . "/../Controllers/{$controllerName}.php");

				if (file_exists($controllerFile)) {
					require_once $controllerFile;

                    $controller = new $controllerName();
					$controller->{$actionName}();

				} else {
					die("Контроллер не найден: " . $controllerFile);
				}
				return;
			}
		}

		die("404 Не найдено");
	}
}

?>
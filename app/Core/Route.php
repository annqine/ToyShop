<?php
abstract class RouteAbstractHandler {
	public $nextHandler = null;

	public function setNext(RouteAbstractHandler $handler) {
		$this->nextHandler = $handler;
		return $handler; // Для возможности цепочного вызова
	}

	abstract public function handle($requestMethod, $uri);
}

class RouteHandler extends RouteAbstractHandler {
	private $method;
	private $uri;
	private $action;

	public function __construct($method, $uri, $action) {
		$this->method = strtoupper($method);
		$this->uri = trim($uri, '/');
		$this->action = $action;
	}

	public function handle($requestMethod, $uri) {
		if ($this->method === $requestMethod && $this->uri === $uri) {
			list($controllerName, $actionName) = explode('@', $this->action);
			$controllerFile = realpath(__DIR__ . "/../Controllers/{$controllerName}.php");

			if (file_exists($controllerFile)) {
				require_once $controllerFile;

				$controller = new $controllerName();
				$controller->{$actionName}();
				return true; // Запрос обработан
			} else {
				die("Контроллер не найден: " . $controllerFile);
			}
		}

		// Передаём запрос следующему обработчику, если текущий не справился
		if ($this->nextHandler) {
			return $this->nextHandler->handle($requestMethod, $uri);
		}

		// Если нет обработчиков, завершаем цепочку
		return false;
	}
}

class Route {
	private static $rootHandler;

	public static function add($method, $uri, $action) {
		$newHandler = new RouteHandler($method, $uri, $action);

		if (self::$rootHandler === null) {
			self::$rootHandler = $newHandler; // Первый обработчик становится корнем цепочки
		} else {
			// Добавляем новый обработчик в конец цепочки
			$currentHandler = self::$rootHandler;
			while ($currentHandler->nextHandler !== null) {
				$currentHandler = $currentHandler->nextHandler;
			}
			$currentHandler->setNext($newHandler);
		}
	}

	public static function start() {
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		$uri = trim($_SERVER['REQUEST_URI'], '/');

		// Убираем параметры запроса из URI, если они есть
		$uriParts = explode('?', $uri);
		$uri = $uriParts[0];

		if (self::$rootHandler) {
			if (!self::$rootHandler->handle($requestMethod, $uri)) {
				die("404 Не найдено");
			}
		} else {
			die("Маршруты не настроены");
		}
	}

	public static function clear() {
		self::$rootHandler = null;
	}
}
?>

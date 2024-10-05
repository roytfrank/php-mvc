<?php declare (strict_types = 1);

namespace App\Routing;
use AltoRouter;

class RouteDispatcher {
	protected $controller;
	protected $method;
	protected $match;

	public function __construct(AltoRouter $router) {
		$this->match = $router->match();
		if ($this->match) {
			list($controller, $method) = explode('@', $this->match['target']);
			$this->controller = $controller;
			$this->method = $method;
			if (is_callable(array(new $this->controller, $this->method))) {
				call_user_func(array(new $this->controller, $this->method), array($this->match['params']));
			} else {
				echo "This method: {$this->method} is not found on this controller: {$this->controller}";
			}
		} else {
			header($_SERVER['SERVER_PROTOCOL'] . '404 not found');
			view("errors/404");
		}
	}
}
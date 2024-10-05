<?php declare (strict_types = 1);
if (!isset($_SESSION)) {
	session_start();
}
//require env and vendor autoload
require_once __DIR__ . '/../app/Config/_env.php';
//handle errors
new \App\Classes\Database();
set_error_handler([new \App\Exception\ErrorHandler(), 'handle']);
//allowed routes
require_once __DIR__ . '/../app/Routing/Routes.php';
//allowed route dispatcher and server output
new \App\Routing\RouteDispatcher($router);

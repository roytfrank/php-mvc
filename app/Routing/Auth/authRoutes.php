<?php declare (strict_types = 1);
/**
 * User Routes
 */
$router->map('GET', '/login', '\App\Controllers\Auth\AuthController@login', 'login-form');
$router->map('POST', '/login', '\App\Controllers\Auth\AuthController@auth', 'auth');
$router->map('GET', '/logout', '\App\Controllers\Auth\AuthController@signOut', 'logout-user');
$router->map('GET', '/verify/user/[*:action]', '\App\Controllers\Auth\AuthController@verify', 'email-verification');
$router->map('GET', '/register', '\App\Controllers\Auth\AuthController@create', 'register-form');
$router->map('POST', '/register', '\App\Controllers\Auth\AuthController@store', 'store-user');

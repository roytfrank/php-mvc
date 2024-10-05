<?php declare (strict_types = 1);

$router = new AltoRouter();

//Index routes
$router->map('GET', '/', '\App\Controllers\IndexController@show', 'home');
$router->map('GET', '/products', '\App\Controllers\IndexController@featured', 'home-products');
$router->map('GET', '/featured', '\App\Controllers\IndexController@featured', 'home-featured');

$router->map('GET', '/product/[*:action]', '\App\Controllers\IndexController@getitem', 'single-product');
$router->map('GET', '/productdetails/[i:id]/details', '\App\Controllers\IndexController@getproductdetails', 'single-product-details');
/****/
$router->map('POST', '/loadmore/product/', '\App\Controllers\IndexController@loadmore', 'more-product-details');

/**Add Item to Cart**/
$router->map('POST', '/addcartitem', '\App\Controllers\CartController@addItemToCart', 'item-to-cart');
$router->map('GET', '/cart', '\App\Controllers\CartController@show', 'display-cart');
$router->map('GET', '/cart/items', '\App\Controllers\CartController@getcartitems', 'get-cart-items');
$router->map('POST', '/cart/update', '\App\Controllers\CartController@updateQty', 'update-item-qty');
$router->map('POST', '/cart/remove', '\App\Controllers\CartController@removeItem', 'remove-cart-item');
//Admin routes
require_once __DIR__ . '/Admin/adminRoutes.php';
require_once __DIR__ . '/Auth/authRoutes.php';
